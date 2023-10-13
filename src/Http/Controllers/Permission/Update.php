<?php

namespace LaravelLiberu\Roles\Http\Controllers\Permission;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Models\Role;

class Update extends Controller
{
    public function __invoke(Request $request, Role $role)
    {
        $role->syncPermissions($request->get('rolePermissions'));

        return ['message' => __("The role's permissions were successfully updated")];
    }
}
