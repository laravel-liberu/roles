<?php

namespace LaravelLiberu\Roles\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelLiberu\Menus\Models\Menu;
use LaravelLiberu\Roles\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'display_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'menu_id' => Menu::factory(),
        ];
    }
}
