<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Forms\Builders\Role;
use LaravelLiberu\Roles\Models\Role as Model;

class Edit extends Controller
{
    public function __invoke(Model $role, Role $form)
    {
        return ['form' => $form->edit($role)];
    }
}
