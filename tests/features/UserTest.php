<?php

use Faker\Factory;
use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\FormBuilder\app\TestTraits\EditForm;
use LaravelEnso\FormBuilder\app\TestTraits\DestroyForm;
use LaravelEnso\VueDatatable\app\Traits\Tests\Datatable;
use LaravelEnso\Core\app\Notifications\ResetPasswordNotification;

class UserTest extends TestCase
{
    use Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'administration.users';
    private $testModel;

    protected function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = factory(User::class)
            ->make();
    }

    /** @test */
    public function can_view_create_form()
    {
        $this->get(route($this->permissionGroup.'.create', [$this->testModel->person->id], false))
            ->assertStatus(200)
            ->assertJsonStructure(['form']);
    }

    /** @test */
    public function can_store_user()
    {
        \Notification::fake();

        $response = $this->post(
            route('administration.users.store', [], false),
            $this->testModel->toArray()
        );

        $user = User::whereEmail($this->testModel->email)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'administration.users.edit',
                'id' => $user->id,
            ]);

        \Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    /** @test */
    public function can_update_user()
    {
        $this->testModel->save();

        $initialState = $this->testModel->is_active;
        $this->testModel->is_active = !$initialState;

        $this->patch(
            route('administration.users.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
        ->assertJsonStructure(['message']);

        $this->assertEquals(!$initialState, $this->testModel->fresh()->is_active);
    }

    /** @test */
    public function get_option_list()
    {
        $this->testModel->is_active = true;
        $this->testModel->save();

        $this->get(route('administration.users.options', [
            'query' => $this->testModel->person->name,
            'limit' => 10,
        ], false))
        ->assertStatus(200)
        ->assertJsonFragment([
            'name' => $this->testModel->person->name,
        ]);
    }
}
