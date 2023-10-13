<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Http\Requests\ValidateRole;
use LaravelLiberu\Roles\Models\Role;

class Update extends Controller
{
    public function __invoke(ValidateRole $request, Role $role)
    {
        $role->update($request->validated());

        return ['message' => __('The role was successfully updated')];
    }
}
