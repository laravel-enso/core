<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\RoleManager\app\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    private $user;
    private $owner;
    private $role;
    private $faker;

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

        $response->assertStatus(200)
            ->assertJsonFragment([
            'message' => 'The user was created!',
            'redirect'=> '/administration/users/'.$user->id.'/edit',
        ]);
    }

    /** @test */
    public function edit()
    {
        $this->addNewUser();
        $user = User::orderBy('id', 'desc')->first();

        $response = $this->get('/administration/users/'.$user->id.'/edit');

        $response->assertStatus(200);
    }

    /** @test */
    public function update()
    {
        $this->addNewUser();
        $user = User::orderBy('id', 'desc')->first();
        $user->last_name = 'edited';
        $data = $user->toArray();
        $data['_method'] = 'PATCH';

        $response = $this->patch('/administration/users/'.$user->id, $data)
            ->assertStatus(200)
            ->assertJson(['message' => __(config('labels.savedChanges'))]);

        $this->assertTrue($this->wasUpdated());
    }

    /** @test */
    public function destroy()
    {
        $this->addNewUser();
        $user = User::orderBy('id', 'desc')->first();

        $response = $this->delete('/administration/users/'.$user->id);

        $this->hasJsonConfirmation($response);
        $this->wasDeleted($user);
        $response->assertStatus(200);
    }

    private function wasUpdated()
    {
        $user = User::orderBy('id', 'desc')->first(['last_name']);

        return $user->last_name === 'edited';
    }

    private function wasDeleted($user)
    {
        return $this->assertNull(User::whereFirstName($user->first_name)->first());
    }

    private function hasSessionConfirmation($response)
    {
        return $response->assertSessionHas('flash_notification');
    }

    private function hasJsonConfirmation($response)
    {
        return $response->assertJsonFragment(['message']);
    }

    private function addNewUser()
    {
        $user = new User($this->postParams());
        $user->email = $this->faker->email;
        $user->owner_id = $this->owner->id;
        $user->role_id = $this->role->id;
        $user->save();
    }

    private function postParams()
    {
        return [
            'first_name'                 => $this->faker->firstName,
            'last_name'                  => $this->faker->lastName,
            'role_id'                    => $this->role->id,
            'phone'                      => $this->faker->phoneNumber,
            'is_active'                  => 1,
            'email'                      => $this->faker->email,
            'owner_id'                   => $this->owner->id,
            '_method'                    => 'POST',
        ];
    }
}
