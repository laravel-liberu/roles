<?php

namespace LaravelLiberu\Roles\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelLiberu\Menus\Models\Menu;
use LaravelLiberu\Permissions\Models\Permission;
use LaravelLiberu\Roles\Models\Role;
use Symfony\Component\Finder\SplFileInfo;

class Sync
{
    public function handle(): void
    {
        Collection::wrap(File::files(config_path('local/roles')))
            ->map(fn ($file) => Config::get("local.roles.{$this->role($file)}"))
            ->sortBy('order')
            ->each(fn ($config) => $this->sync($config));
    }

    private function sync(array $config): void
    {
        Role::updateOrCreate([
            'name' => $config['role']['name'],
        ], [
            'display_name' => $config['role']['display_name'],
            'menu_id' => $this->menu($config)?->id,
        ])->syncPermissions($this->permissionIds($config));
    }

    private function menu($config): ?Menu
    {
        if (! $config['default_menu']) {
            return null;
        }

        return Menu::query()
            ->whereHas('permission', fn ($permission) => $permission
                ->whereName($config['default_menu']))->first();
    }

    private function permissionIds($config): array
    {
        return Permission::whereIn('name', $config['permissions'])
            ->pluck('id')->toArray();
    }

    private function role(SplFileInfo $file): string
    {
        return Str::of($file->getFilename())->replace('.php', '');
    }
}
