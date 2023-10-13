<?php

namespace LaravelLiberu\Roles;

use LaravelLiberu\Enums\EnumServiceProvider as ServiceProvider;
use LaravelLiberu\Roles\Enums\Roles;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'roles' => Roles::class,
    ];
}
