<?php

namespace LaravelLiberu\Roles\Http\Controllers\Permission;

use LaravelLiberu\Roles\Models\Role;

class ConfigWriter
{
    public function __invoke(Role $role)
    {
        $role->writeConfig();

        return ['message' => __('The config file was successfully written')];
    }
}
