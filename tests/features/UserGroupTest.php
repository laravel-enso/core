<?php

use Faker\Factory;
use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Models\UserGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\FormBuilder\app\TestTraits\EditForm;
use LaravelEnso\FormBuilder\app\TestTraits\CreateForm;
use LaravelEnso\FormBuilder\app\TestTraits\DestroyForm;
use LaravelEnso\VueDatatable\app\Traits\Tests\Datatable;

class UserGroupTest extends TestCase
{
    use CreateForm, Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'administration.userGroups';
    private $testModel;

    protected function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = factory(UserGroup::class)
            ->make();
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
            ]
        )->assertStatus(200)
        ->assertJsonStructure(['message']);

        $this->assertEquals('edited', $this->testModel->fresh()->name);
    }

    /** @test */
    public function cant_destroy_user_group_when_having_users_attached()
    {
        $this->testModel->save();

        $this->testModel->users()->save(
            factory(User::class)->make()
        );

        $this->delete(route('administration.userGroups.destroy', $this->testModel->id, false))
            ->assertStatus(409);

        $this->assertNotNull($this->testModel->fresh());
    }
}
