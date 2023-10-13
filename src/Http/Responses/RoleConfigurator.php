<?php

namespace LaravelLiberu\Roles\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use LaravelLiberu\Roles\Models\Role;
use LaravelLiberu\Roles\Services\PermissionTree;

class RoleConfigurator implements Responsable
{
    public function __construct(private readonly Role $role)
    {
    }

    public function toResponse($request)
    {
        return [
            'permissions' => (new PermissionTree())->get(),
            'role' => $this->role,
            'rolePermissions' => $this->rolePermissions(),
        ];
    }

    public function rolePermissions()
    {
        return $this->role->permissions()->pluck('id');
    }
}
