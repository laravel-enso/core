<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\TestHelper\app\Classes\TestHelper;

class UserTest extends TestHelper
{
    use DatabaseMigrations;

    private $owner;
    private $role;
    private $faker;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->signIn(User::first());
        $this->faker = Factory::create();
        $this->owner = Owner::first(['id']);
        $this->role = Role::first(['id']);
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
        $this->get('/administration/users/create')
            ->assertStatus(200)
            ->assertViewHas('form');
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/administration/users', $postParams);
        $user = User::whereFirstName($postParams['first_name'])->first(['id']);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message'  => 'The user was created!',
                'redirect' => '/administration/users/'.$user->id.'/edit',
            ]);
    }

    /** @test */
    public function edit()
    {
        $user = $this->createUser();

        $this->get('/administration/users/'.$user->id.'/edit')
            ->assertStatus(200)
            ->assertViewHas('form');
    }

    /** @test */
    public function update()
    {
        $user = $this->createUser();
        $user->last_name = 'edited';

        $this->patch('/administration/users/'.$user->id, $user->toArray())
            ->assertStatus(200)
            ->assertJson(['message' => __(config('labels.savedChanges'))]);

        $this->assertEquals('edited', $user->fresh()->last_name);
    }

    /** @test */
    public function destroy()
    {
        $user = $this->createUser();

        $this->delete('/administration/users/'.$user->id)
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'redirect']);

        $this->assertNull($user->fresh());
    }

    private function createUser()
    {
        $user = new User($this->postParams());
        $user->email = $this->faker->email;
        $user->owner_id = $this->owner->id;
        $user->role_id = $this->role->id;
        $user->save();

        return $user;
    }

    private function postParams()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'role_id'    => $this->role->id,
            'phone'      => $this->faker->phoneNumber,
            'is_active'  => 1,
            'email'      => $this->faker->email,
            'owner_id'   => $this->owner->id,
            '_method'    => 'POST',
        ];
    }
}
