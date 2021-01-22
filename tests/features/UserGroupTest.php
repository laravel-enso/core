<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Core\Models\UserGroup;
use LaravelEnso\Forms\TestTraits\CreateForm;
use LaravelEnso\Forms\TestTraits\DestroyForm;
use LaravelEnso\Forms\TestTraits\EditForm;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use Tests\TestCase;

class UserGroupTest extends TestCase
{
    use CreateForm, Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'administration.userGroups';
    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = UserGroup::factory()->make();
    }

    /** @test */
    public function can_store_user_group()
    {
        $response = $this->post(
            route('administration.userGroups.store', [], false),
            $this->testModel->toArray() + ['roles' => []]
        );

        $group = UserGroup::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'administration.userGroups.edit',
                'param' => ['userGroup' => $group->id],
            ]);
    }

    /** @test */
    public function can_update_user_group()
    {
        $this->testModel->save();

        $this->testModel->name = 'edited';

        $this->patch(
            route('administration.userGroups.update', $this->testModel->id, false),
            $this->testModel->toArray() + [
                'roles' => $this->testModel->roles()
                    ->pluck('id')
                    ->toArray()
            ])->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertEquals('edited', $this->testModel->fresh()->name);
    }

    /** @test */
    public function cant_destroy_user_group_when_having_users_attached()
    {
        $this->testModel->save();

        $this->testModel->users()->save(
            User::factory()->make()
        );

        $this->delete(route('administration.userGroups.destroy', $this->testModel->id, false))
            ->assertStatus(409);

        $this->assertNotNull($this->testModel->fresh());
    }
}
