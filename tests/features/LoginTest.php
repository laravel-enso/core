<?php

namespace LaravelEnso\Core\Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\PersonalAccessToken;
use LaravelEnso\Core\Models\Login as LoginModel;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use Datatable {
        can_view_index as private canViewLoginsTable;
    }

    private const Password = 'password';
    private const WrongPassword = 'wrong_password';
    private const SpaUrl = 'spa.test';

    private $permissionGroup = 'system.logins';
    private $testModel;
    private $spaGuard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->testModel = $this->user();

        $this->spaGuard = Arr::wrap(Config::get('sanctum.guard', 'web'))[0];

        Config::set('sanctum.stateful', [self::SpaUrl]);
    }

    #[Test]
    public function can_login_from_spa()
    {
        $response = $this->loginSpa();

        $response->assertJson(['auth' => true]);

        $this->assertAuthenticatedAs($this->testModel, $this->spaGuard);
    }

    #[Test]
    public function can_login_from_api()
    {
        $response = $this->loginApi();

        $this->assertTokenAuthenticate($response->json('token'));
    }

    #[Test]
    public function can_login_from_webview()
    {
        $response = $this->disableCookieEncryption()
            ->withCookie('webview', true)
            ->loginApi(null, self::SpaUrl);

        $this->assertTokenAuthenticate($response->json('token'));
    }

    #[Test]
    public function can_authenticate_token_api()
    {
        $response = $this->loginApi();

        $this->get(route('core.home.index'), [
            'Authorization' => 'Bearer '.$response->json('token'),
        ])->assertOk();
    }

    #[Test]
    public function can_authenticate_cookie_api()
    {
        $response = $this->loginApi();

        $this->disableCookieEncryption()
            ->withCookie('Authorization', $response->json('token'))
            ->get(route('core.home.index'))
            ->assertOk();
    }

    #[Test]
    public function can_logout_from_spa()
    {
        $this->loginSpa();

        $this->post(route('logout'), [], [
            'referer' => self::SpaUrl,
        ]);

        $this->assertFalse($this->isAuthenticated($this->spaGuard));
    }

    #[Test]
    public function can_logout_from_api()
    {
        $response = $this->loginApi();

        $this->post(route('logout'), [], [
            'Authorization' => 'Bearer '.$response->json('token'),
        ]);

        $this->assertFalse($this->isAuthenticated('sanctum'));

        $this->assertTrue($this->testModel->tokens->isEmpty());
    }

    #[Test]
    public function cannot_login_from_api()
    {
        $this->loginApi(self::WrongPassword);

        $this->assertFalse($this->isAuthenticated('sanctum'));
    }

    #[Test]
    public function cannot_login_from_spa()
    {
        $this->loginSpa(self::WrongPassword);

        $this->assertFalse($this->isAuthenticated());
    }

    #[Test]
    public function can_view_index()
    {
        $this->actingAs($this->testModel);

        $this->canViewLoginsTable();
    }

    #[Test]
    public function filters_logins_by_user()
    {
        $other = User::factory()->create();

        LoginModel::create([
            'user_id' => $this->testModel->id,
            'ip' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ]);

        LoginModel::create([
            'user_id' => $other->id,
            'ip' => '127.0.0.2',
            'user_agent' => 'PHPUnit',
        ]);

        $params = $this->tableParams([
            'filters' => [
                'logins' => [
                    'user_id' => $this->testModel->id,
                ],
            ],
        ]);

        $this->actingAs($this->testModel)
            ->get(route('system.logins.tableData', $params, false))
            ->assertStatus(200)
            ->assertJsonFragment(['ip' => '127.0.0.1'])
            ->assertJsonMissing(['ip' => '127.0.0.2']);
    }

    #[Test]
    public function filters_logins_by_created_at_interval()
    {
        LoginModel::create([
            'user_id' => $this->testModel->id,
            'ip' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'created_at' => Carbon::parse('2026-05-12 10:00:00'),
        ]);

        LoginModel::create([
            'user_id' => $this->testModel->id,
            'ip' => '127.0.0.2',
            'user_agent' => 'PHPUnit',
            'created_at' => Carbon::parse('2026-05-10 10:00:00'),
        ]);

        $params = $this->tableParams([
            'intervals' => [
                'logins' => [
                    'created_at' => [
                        'min' => '2026-05-12 00:00:00',
                        'max' => '2026-05-12 23:59:59',
                    ],
                ],
            ],
        ]);

        $this->actingAs($this->testModel)
            ->get(route('system.logins.tableData', $params, false))
            ->assertStatus(200)
            ->assertJsonFragment(['ip' => '127.0.0.1'])
            ->assertJsonMissing(['ip' => '127.0.0.2']);
    }

    #[Test]
    public function creates_logins_structure()
    {
        $this->assertTrue(Permission::whereName('system.logins.index')->exists());
        $this->assertTrue(Permission::whereName('system.logins.initTable')->exists());
        $this->assertTrue(Permission::whereName('system.logins.tableData')->exists());
        $this->assertTrue(Permission::whereName('system.logins.exportExcel')->exists());

        $this->assertTrue(Menu::whereName('Logins')
            ->whereHas('permission', fn ($query) => $query
                ->whereName('system.logins.index'))
            ->exists());
    }

    private function loginApi($password = null, $referer = null): TestResponse
    {
        return $this->post(route('login'), [
            'email'       => $this->testModel->email,
            'password'    => $password ?? self::Password,
            'device_name' => 'mobile',
        ], [
            'referer' => $referer,
        ]);
    }

    private function loginSpa($password = null): TestResponse
    {
        return $this->post(route('login'), [
            'email'    => $this->testModel->email,
            'password' => $password ?? self::Password,
        ], ['referer' => self::SpaUrl]);
    }

    private function tableParams(array $params = []): array
    {
        return [
            'columns' => [],
            'meta' => '{"start":0,"length":10,"sort":false,"search":"","forceInfo":false,"searchMode":"full"}',
            'filters' => json_encode($params['filters'] ?? [], JSON_THROW_ON_ERROR),
            'intervals' => json_encode($params['intervals'] ?? [], JSON_THROW_ON_ERROR),
        ];
    }

    private function user(): User
    {
        $user = User::first();
        $user->password = Hash::make(self::Password);
        $user->is_active = true;

        return tap($user)->save();
    }

    protected function assertTokenAuthenticate($token): void
    {
        $token = PersonalAccessToken::findToken($token);
        $this->assertTrue($token->tokenable->is($this->testModel));
    }
}
