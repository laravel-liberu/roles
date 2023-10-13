<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelLiberu\Forms\TestTraits\CreateForm;
use LaravelLiberu\Forms\TestTraits\DestroyForm;
use LaravelLiberu\Forms\TestTraits\EditForm;
use LaravelLiberu\Roles\Models\Role;
use LaravelLiberu\Tables\Traits\Tests\Datatable;
use LaravelLiberu\Users\Models\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use CreateForm, Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'system.roles';
    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = Role::factory()
            ->make();
    }

    /** @test */
    public function can_store_role()
    {
        $response = $this->post(
            route('system.roles.store'),
            $this->testModel->toArray()
        );

        $role = Role::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'redirect' => 'system.roles.edit',
                'param' => ['role' => $role->id],
            ])->assertJsonStructure(['message']);
    }

    /** @test */
    public function can_update_role()
    {
        $this->testModel->save();

        $this->testModel->name = 'edited';

        $this->patch(
            route('system.roles.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertEquals($this->testModel->name, $this->testModel->fresh()->name);
    }

    /** @test */
    public function cant_destroy_if_has_users()
    {
        $this->testModel->save();

        User::factory()->create([
            'role_id' => $this->testModel->id,
        ]);

        $this->delete(route('system.roles.destroy', $this->testModel->id, false))
            ->assertStatus(409);

        $this->assertNotNull($this->testModel->fresh());
    }
}
