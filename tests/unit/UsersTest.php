<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\RoleManager\app\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    private $user;
    private $owner;
    private $role;

    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
        $this->user = User::first();
        $this->faker = Factory::create();
        $this->owner = Owner::first(['id']);
        $this->role = Role::first(['id']);
        $this->actingAs($this->user);
    }

    /** @test */
    public function index()
    {
        $response = $this->get('/administration/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function create()
    {
        $response = $this->get('/administration/users/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/administration/users', $postParams);

        $user = User::whereFirstName($postParams['first_name'])->first(['id']);

        $response->assertRedirect('/administration/users/'.$user->id.'/edit');
        $this->hasSessionConfirmation($response);
    }

    /** @test */
    public function edit()
    {
        $user = User::latest()->first();

        $response = $this->get('/administration/users/'.$user->id.'/edit');

        $response->assertStatus(200);
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function update()
    {
        $user = User::first();
        $user->last_name = 'edited';
        $data = $user->toArray();
        $data['_method'] = 'PATCH';

        $response = $this->patch('/administration/users/'.$user->id, $data);

        $response->assertStatus(302);
        $this->hasSessionConfirmation($response);
        $this->assertTrue($this->wasUpdated());
    }

    /** @test */
    public function destroy()
    {
        $user = User::latest()->first(['id']);

        $response = $this->delete('/administration/users/'.$user->id);

        $this->hasJsonConfirmation($response);
        $response->assertStatus(200);
    }

    private function postParams()
    {
        return [
            'first_name'   => $this->faker->firstName,
            'last_name'                  => $this->faker->lastName,
            'role_id'           => $this->role->id,
            'phone'                  => $this->faker->phoneNumber,
            'is_active'               => 1,
            'email'               => $this->faker->email,
            'owner_id'               => $this->owner->id,
            '_method'               => 'POST',
        ];
    }

    private function wasUpdated()
    {
        $user = User::first(['last_name']);

        return $user->last_name === 'edited';
    }

    private function hasSessionConfirmation($response)
    {
        return $response->assertSessionHas('flash_notification');
    }

    private function hasJsonConfirmation($response)
    {
        return $response->assertJsonFragment(['message']);
    }
}
