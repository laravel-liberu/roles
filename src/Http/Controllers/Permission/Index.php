<?php

namespace LaravelLiberu\Roles\Http\Controllers\Permission;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Http\Responses\RoleConfigurator;
use LaravelLiberu\Roles\Models\Role;

class Index extends Controller
{
    public function __invoke(Role $role)
    {
        return new RoleConfigurator($role);
    }
}
