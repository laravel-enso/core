<?php

use App\Owner;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->user = User::first();
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
        $owner = Owner::first();

        $response = $this->get('/administration/owners/'.$owner->id.'/edit');

        $response->assertStatus(200);
        $response->assertViewHas('owner', $owner);
    }

    /** @test */
    public function update()
    {
        $owner = Owner::first();
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
        Owner::create($this->postParams());
        $owner = Owner::latest()->first(['id']);

        $response = $this->delete('/administration/owners/'.$owner->id);

        $this->hasJsonConfirmation($response);
        $response->assertStatus(200);
    }

    /** @test */
    public function cantDestroyIfHasUsersAttached()
    {
        $owner = Owner::first(['id']);

        $response = $this->delete('/administration/owners/'.$owner->id);

        $response->assertStatus(302);
        $this->assertTrue($this->hasSessionErrorMessage());
    }

    private function postParams()
    {
        return [
            'name'   => $this->faker->firstName,
            'description'                  => $this->faker->sentence,
            'is_active'               => 1,
            '_method'               => 'POST',
        ];
    }

    private function wasUpdated()
    {
        $owner = Owner::first(['name']);

        return $owner->name === 'edited';
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
}
