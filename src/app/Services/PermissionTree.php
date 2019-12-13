<?php

namespace LaravelEnso\Roles\app\Services;

use LaravelEnso\Helpers\app\Classes\Obj;
use LaravelEnso\Permissions\app\Models\Permission;

class PermissionTree
{
    private $tree;
    private $current;

    public function __construct()
    {
        $this->tree = $this->emptyNode();
    }

    public function get()
    {
        Permission::with('menu:permission_id')
            ->orderBy('name')
            ->get()
            ->each(function ($permission) {
                $this->current = $this->tree;
                $this->endingNode($permission);
                $this->current->get('_items')
                    ->push($permission);
            });

        return $this->tree;
    }

    private function endingNode($permission)
    {
        collect(explode('.', $permission->name))
            ->slice(0, -1)->each(function ($segment) {
                if (! $this->current->has($segment)) {
                    $this->current->set($segment, $this->emptyNode());
                }

                $this->current = $this->current->get($segment);
            });
    }

    private function emptyNode()
    {
        $node = new Obj();
        $node->set('_items', collect());

        return $node;
    }
}
