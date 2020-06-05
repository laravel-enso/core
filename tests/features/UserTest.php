<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Core\App\Notifications\ResetPassword;
use LaravelEnso\Forms\App\TestTraits\DestroyForm;
use LaravelEnso\Forms\App\TestTraits\EditForm;
use LaravelEnso\Tables\App\Traits\Tests\Datatable;
use Tests\TestCase;

class UserTest extends TestCase
{
    use Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'administration.users';
    private $testModel;

    protected function setUp(): void
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
        Notification::fake();

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
                'param' => ['user' => $user->id],
            ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /** @test */
    public function can_update_user()
    {
        $this->testModel->save();

        $this->testModel->is_active = ! $this->testModel->is_active;

        $this->patch(
            route('administration.users.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
        ->assertJsonStructure(['message']);

        $this->assertEquals($this->testModel->is_active, $this->testModel->fresh()->is_active);
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
        ->assertJsonFragment(['name' => $this->testModel->person->name]);
    }
}
