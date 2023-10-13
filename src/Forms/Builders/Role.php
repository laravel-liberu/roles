<?php

namespace LaravelLiberu\Roles\Forms\Builders;

use LaravelLiberu\Forms\Services\Form;
use LaravelLiberu\Menus\Models\Menu;
use LaravelLiberu\Roles\Models\Role as Model;

class Role
{
    private const TemplatePath = __DIR__.'/../Templates/role.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form($this->templatePath()))
            ->options('menu_id', Menu::isNotParent()->get(['name', 'id']));
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Model $role)
    {
        return $this->form->edit($role);
    }

    protected function templatePath(): string
    {
        return self::TemplatePath;
    }
}
