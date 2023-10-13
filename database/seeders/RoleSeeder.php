<?php

namespace LaravelLiberu\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LaravelLiberu\Menus\Models\Menu;
use LaravelLiberu\Permissions\Models\Permission;
use LaravelLiberu\Roles\Models\Role;

class RoleSeeder extends Seeder
{
    protected array $roles = [
        ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.'],
        ['name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor role.'],
    ];

    public function run()
    {
        $menu = Menu::firstWhere('name', 'Dashboard');

        $roles = Collection::wrap($this->roles)
            ->map(fn ($role) => Role::factory()
                ->create($role + ['menu_id' => $menu->id]));

        $permissions = Permission::pluck('is_default', 'id');

        $roles->first()
            ->syncPermissions($permissions->keys()->toArray());

        $roles->last()
            ->syncPermissions($permissions->filter()->keys()->toArray());
    }
}
