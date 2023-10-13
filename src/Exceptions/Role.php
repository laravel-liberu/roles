<?php

namespace LaravelLiberu\Roles\Exceptions;

use LaravelLiberu\Helpers\Exceptions\EnsoException;

class Role extends EnsoException
{
    public static function adminRole()
    {
        return new self(__(
            'The admin role already has all permissions and does not need syncing'
        ));
    }
}
