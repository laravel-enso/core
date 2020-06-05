<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\PersonalAccessToken;
use LaravelEnso\Core\App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    const PASSWORD = 'password';
    private $permissionGroup = 'administration.users';
    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed();

        $this->testModel = factory(User::class)
            ->create([
                'password' => Hash::make(self::PASSWORD),
                'is_active' => true,
            ]);
    }

    /** @test */
    public function can_login_from_spa()
    {
        $resp = $this->loginSpa();

        $resp->assertJson([
            'auth' => true
        ]);

        $this->assertAuthenticatedAs($this->testModel);
    }

    /** @test */
    public function cannot_login_from_api()
    {
        $this->loginApi('WRONG_PASSWORD');

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    public function cannot_login_from_spa()
    {
        $this->loginSpa('WRONG_PASSWORD');

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    public function can_login_from_api()
    {
        $resp = $this->loginApi();

        $this->assertAuthenticatedAs($this->testModel);

        $this->assertEquals(PersonalAccessToken::findToken($resp->json('token'))
            ->tokenable->id, $this->testModel->id);
    }

    private function loginApi($password = null): TestResponse
    {
        return $this->post(route('login'), [
            'email' => $this->testModel->email,
            'password' => $password ?? self::PASSWORD,
            'device_name' => 'mobile',
        ]);
    }

    private function loginSpa($password = null): TestResponse
    {
        Config::set('sanctum.stateful', ['spa.test']);

        return $this->post(route('login'), [
            'email' => $this->testModel->email,
            'password' => $password ?? self::PASSWORD,
        ], [
            'referer' => 'spa.test'
        ]);
    }
}
