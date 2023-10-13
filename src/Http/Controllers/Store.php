<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Http\Requests\ValidateRole;
use LaravelLiberu\Roles\Models\Role;

class Store extends Controller
{
    public function __invoke(ValidateRole $request, Role $role)
    {
        $role->fill($request->validated())->save();
        $role->addDefaultPermissions();

        return [
            'message' => __('The role was created!'),
            'redirect' => 'system.roles.edit',
            'param' => ['role' => $role->id],
        ];
    }
}
