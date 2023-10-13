<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Tables\Builders\Role;
use LaravelLiberu\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = Role::class;
}
