<?php

namespace LaravelLiberu\Roles\Traits;

use LaravelLiberu\Roles\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function updateWithRoles(array $attributes, array $roles)
    {
        tap($this)->update($attributes)
            ->roles()->sync($roles);
    }

    public function storeWithRoles(array $attributes, array $roles)
    {
        $this->fill($attributes);

        tap($this)->save()
            ->roles()->sync($roles);

        return $this;
    }
}
