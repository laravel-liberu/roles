<?php

namespace LaravelLiberu\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLiberu\Roles\Tables\Builders\Role;
use LaravelLiberu\Tables\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = Role::class;
}
