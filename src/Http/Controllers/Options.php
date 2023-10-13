<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Models\Role;
use LaravelLiberu\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    public function query()
    {
        return Role::visible();
    }
}
