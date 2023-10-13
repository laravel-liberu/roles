<?php

namespace LaravelLiberu\Roles\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use LaravelLiberu\Menus\Models\Menu;
use LaravelLiberu\Permissions\Models\Permission;
use LaravelLiberu\Rememberable\Traits\Rememberable;
use LaravelLiberu\Roles\Exceptions\RoleConflict;
use LaravelLiberu\Roles\Services\ConfigWriter;
use LaravelLiberu\Tables\Traits\TableCache;
use LaravelLiberu\UserGroups\Enums\UserGroups;
use LaravelLiberu\UserGroups\Models\UserGroup;
use LaravelLiberu\Users\Models\User;

class Role extends Model
{
    use HasFactory, Rememberable, TableCache;

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function scopeVisible(Builder $query): Builder
    {
        $isSuperior = Auth::user()->belongsToAdminGroup();

        return $query->when(! $isSuperior, fn ($query) => $query
            ->whereHas('userGroups', fn ($groups) => $groups->when(
                Config::get('liberu.roles.restrictedToOwnGroup'),
                fn ($groups) => $groups->whereId(Auth::user()->group_id),
                fn ($groups) => $groups->where('id', '<>', UserGroups::Admin),
            )));
    }

    public function syncPermissions($permissionList)
    {
        $this->permissions()
            ->sync($permissionList);

        $this->clearPermissionCache();
    }

    public function delete()
    {
        if ($this->users()->exists()) {
            throw RoleConflict::inUse();
        }

        parent::delete();
    }

    public function writeConfig()
    {
        (new ConfigWriter($this))->handle();
    }

    public function addDefaultPermissions()
    {
        $this->permissions()
            ->sync(Permission::implicit()->pluck('id'));
    }

    public function clearPermissionCache(): void
    {
        if (App::isProduction()) {
            Cache::forget(self::permissionCacheKey($this->id));
        }
    }

    public static function permissionList(int $id): Collection
    {
        $collection = fn () => self::find($id)
            ->permissions()->pluck('name');

        if (! App::isProduction()) {
            return $collection();
        }

        $key = self::permissionCacheKey($id);

        return Cache::get($key)
            ?? Cache::remember($key, Carbon::now()->addHour(), $collection);
    }

    public static function permissionCacheKey(int $id): string
    {
        $stub = Config::get('liberu.roles.permissionKey');

        return Str::of($stub)->replace('id', $id);
    }
}
