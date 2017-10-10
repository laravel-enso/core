<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\TestHelper\app\Classes\TestHelper;

class OwnerTest extends TestHelper
{
    use DatabaseMigrations;

    private $role;
    private $faker;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->signIn(User::first());
        $this->role = Role::first(['id']);
        $this->faker = Factory::create();
    }

    /** @test */
    public function index()
    {
        $this->get('/administration/owners')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/core::administration.owners.index');
    }

    /** @test */
    public function create()
    {
        $this->get('/administration/owners/create')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/core::administration.owners.create')
            ->assertViewHas('form');
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/administration/owners', $postParams);
        $owner = Owner::whereName($postParams['name'])->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message'  => 'The entity was created!',
                'redirect' => '/administration/owners/'.$owner->id.'/edit',
            ]);
    }

    /** @test */
    public function edit()
    {
        $postParams = $this->postParams();
        $owner = Owner::create($postParams);

        $this->get('/administration/owners/'.$owner->id.'/edit')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/core::administration.owners.edit')
            ->assertViewHas('form');
    }

    /** @test */
    public function update()
    {
        $postParams = $this->postParams();
        $owner = Owner::create($postParams);
        $owner->name = 'edited';

        $this->patch('/administration/owners/'.$owner->id, $owner->toArray())
            ->assertStatus(200)
            ->assertJson(['message' => __(config('labels.savedChanges'))]);

        $this->assertEquals('edited', $owner->fresh()->name);
    }

    /** @test */
    public function destroy()
    {
        $postParams = $this->postParams();
        $owner = Owner::create($postParams);

        $this->delete('/administration/owners/'.$owner->id)
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'redirect']);

        $this->assertNull($owner->fresh());
    }

    /** @test */
    public function cant_destroy_if_has_users_attached()
    {
        $postParams = $this->postParams();
        $owner = Owner::create($postParams);
        $this->attachUser($owner);

        $this->delete('/administration/owners/'.$owner->id)
            ->assertStatus(455);
    }

    private function attachUser($owner)
    {
        $user = new User([
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'phone'      => $this->faker->phoneNumber,
            'is_active'  => 1,
        ]);
        $user->email = $this->faker->email;
        $user->owner_id = $owner->id;
        $user->role_id = $this->role->id;
        $user->save();
    }

    private function postParams()
    {
        return [
            'name'        => $this->faker->firstName,
            'description' => $this->faker->sentence,
            'is_active'   => 1,
            '_method'     => 'POST',
        ];
    }
}
