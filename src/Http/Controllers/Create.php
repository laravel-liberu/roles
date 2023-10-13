<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Forms\Builders\Role;

class Create extends Controller
{
    public function __invoke(Role $form)
    {
        return ['form' => $form->create()];
    }
}
