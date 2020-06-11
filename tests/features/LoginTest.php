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

    private const Password = 'password';
    private const WrongPassword = 'wrong_password';
    private $permissionGroup = 'administration.users';
    private $testModel;
    private $spaGuard;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed();

        $this->testModel = factory(User::class)
            ->create([
                'password' => Hash::make(self::Password),
                'is_active' => true,
            ]);

        $this->spaGuard = Config::get('sanctum.guard', 'web');
    }

    /** @test */
    public function can_login_from_spa()
    {
        $response = $this->loginSpa();

        $response->assertJson(['auth' => true]);

        $this->assertAuthenticatedAs($this->testModel, $this->spaGuard);
    }

    /** @test */
    public function can_login_from_api()
    {
        $response = $this->loginApi();
        $token = PersonalAccessToken::findToken($response->json('token'));

        $this->assertTrue($token->tokenable->is($this->testModel));
    }

    /** @test */
    public function can_logout_from_spa()
    {
        $this->loginSpa();

        $this->postSpa('logout');

        $this->assertFalse($this->isAuthenticated($this->spaGuard));
    }

    /** @test */
    public function can_logout_from_api()
    {
        $response = $this->loginApi();

        $response = $this->post(route('logout'), [], [
            'Authorization' => 'Bearer '.$response->json('token'),
        ]);

        $this->assertFalse($this->isAuthenticated('sanctum'));

        $this->assertTrue($this->testModel->tokens->isEmpty());
    }

    /** @test */
    public function cannot_login_from_api()
    {
        $this->loginApi(self::WrongPassword);

        $this->assertFalse($this->isAuthenticated('sanctum'));
    }

    /** @test */
    public function cannot_login_from_spa()
    {
        $this->loginSpa(self::WrongPassword);

        $this->assertFalse($this->isAuthenticated());
    }

    private function loginApi($password = null): TestResponse
    {
        return $this->post(route('login'), [
            'email' => $this->testModel->email,
            'password' => $password ?? self::Password,
            'device_name' => 'mobile',
        ]);
    }

    private function loginSpa($password = null): TestResponse
    {
        return $this->postSpa('login', [
            'email' => $this->testModel->email,
            'password' => $password ?? self::Password,
        ]);
    }

    private function postSpa($route, $params = [])
    {
        Config::set('sanctum.stateful', ['spa.test']);

        return $this->post(route($route), $params, [
            'referer' => 'spa.test',
        ]);
    }
}
