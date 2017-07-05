<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\RoleManager\app\Models\Role;
use Tests\TestCase;

class OwnerTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->user = User::first();
        $this->role = Role::first(['id']);
        $this->faker = Factory::create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function index()
    {
        $response = $this->get('/administration/owners');

        $response->assertStatus(200);
    }

    /** @test */
    public function create()
    {
        $response = $this->get('/administration/owners/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/administration/owners', $postParams);

        $owner = Owner::whereName($postParams['name'])->first(['id']);

        $response->assertRedirect('/administration/owners/'.$owner->id.'/edit');
        $this->hasSessionConfirmation($response);
    }

    /** @test */
    public function edit()
    {
        Owner::create($this->postParams());
        $owner = Owner::orderBy('id', 'desc')->first();

        $response = $this->get('/administration/owners/'.$owner->id.'/edit');

        $response->assertStatus(200);
        // $response->assertViewHas('owner', $owner);
    }

    /** @test */
    public function update()
    {
        Owner::create($this->postParams());
        $owner = Owner::orderBy('id', 'desc')->first();
        $owner->name = 'edited';
        $data = $owner->toArray();
        $data['_method'] = 'PATCH';

        $response = $this->patch('/administration/owners/'.$owner->id, $data);

        $response->assertStatus(302);
        $this->hasSessionConfirmation($response);
        $this->assertTrue($this->wasUpdated());
    }

    /** @test */
    public function destroy()
    {
        $postParams = $this->postParams();
        Owner::create($postParams);
        $owner = Owner::whereName($postParams['name'])->first();

        $response = $this->delete('/administration/owners/'.$owner->id);

        $this->hasJsonConfirmation($response);
        $this->wasDeleted($owner);
        $response->assertStatus(200);
    }

    /** @test */
    public function cantDestroyIfHasUsersAttached()
    {
        $postParams = $this->postParams();
        Owner::create($postParams);
        $owner = Owner::whereName($postParams['name'])->first();
        $this->attachUser($owner);

        $response = $this->delete('/administration/owners/'.$owner->id);

        $response->assertStatus(302);
        $this->assertTrue($this->hasSessionErrorMessage());
        $this->wasNotDeleted($owner);
    }

    private function wasUpdated()
    {
        $owner = Owner::orderBy('id', 'desc')->first();

        return $owner->name === 'edited';
    }

    private function wasDeleted($owner)
    {
        return $this->assertNull(Owner::whereName($owner->name)->first());
    }

    private function wasNotDeleted($owner)
    {
        return $this->assertNotNull(Owner::whereName($owner->name)->first());
    }

    private function hasSessionConfirmation($response)
    {
        return $response->assertSessionHas('flash_notification');
    }

    private function hasJsonConfirmation($response)
    {
        return $response->assertJsonFragment(['message']);
    }

    private function hasSessionErrorMessage()
    {
        return session('flash_notification')[0]->level === 'danger';
    }

    private function attachUser($owner)
    {
        $user = new User([
            'first_name'                 => $this->faker->firstName,
            'last_name'                  => $this->faker->lastName,
            'role_id'                    => $this->role->id,
            'phone'                      => $this->faker->phoneNumber,
            'is_active'                  => 1,
        ]);
        $user->email = $this->faker->email;
        $user->owner_id = $owner->id;
        $user->save();
    }

    private function postParams()
    {
        return [
            'name'                         => $this->faker->firstName,
            'description'                  => $this->faker->sentence,
            'is_active'                    => 1,
            '_method'                      => 'POST',
        ];
    }
}
