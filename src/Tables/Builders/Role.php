<?php

namespace LaravelLiberu\Roles\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelLiberu\Roles\Models\Role as Model;
use LaravelLiberu\Tables\Contracts\Table;

class Role implements Table
{
    private const TemplatPath = __DIR__.'/../Templates/roles.json';

    public function query(): Builder
    {
        return Model::selectRaw('
            roles.id, roles.name, roles.display_name, roles.description,
            roles.created_at, menus.name as menu
        ')->leftJoin('menus', 'roles.menu_id', '=', 'menus.id');
    }

    public function templatePath(): string
    {
        return static::TemplatPath;
    }
}
