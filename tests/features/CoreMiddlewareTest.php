<?php

namespace LaravelEnso\Core\Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\Exceptions\Authentication;
use LaravelEnso\Core\Http\Middleware\AuthorizationCookie;
use LaravelEnso\Core\Http\Middleware\EnsureFrontendRequestsAreStateful;
use LaravelEnso\Core\Http\Middleware\VerifyActiveState;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CoreMiddlewareTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    #[Test]
    public function authorization_cookie_populates_header_when_bearer_token_is_missing(): void
    {
        $request = Request::create('/test', 'GET');
        $request->cookies->set('Authorization', 'cookie-token');

        $response = (new AuthorizationCookie())->handle(
            $request,
            fn (Request $request) => $request->header('Authorization')
        );

        $this->assertSame('Bearer cookie-token', $response);
    }

    #[Test]
    public function authorization_cookie_does_not_override_existing_bearer_token(): void
    {
        $request = Request::create('/test', 'GET');
        $request->headers->set('Authorization', 'Bearer header-token');
        $request->cookies->set('Authorization', 'cookie-token');

        $response = (new AuthorizationCookie())->handle(
            $request,
            fn (Request $request) => $request->header('Authorization')
        );

        $this->assertSame('Bearer header-token', $response);
    }

    #[Test]
    public function ensure_frontend_requests_are_stateful_accepts_frontend_requests_and_rejects_webviews(): void
    {
        Config::set('sanctum.stateful', ['spa.test']);

        $frontend = Request::create('/api/core/home', 'GET', [], [], [], [
            'HTTP_REFERER' => 'https://spa.test/dashboard',
        ]);
        $webviewHeader = Request::create('/api/core/home', 'GET', [], [], [], [
            'HTTP_REFERER' => 'https://spa.test/dashboard',
            'HTTP_WEBVIEW' => '1',
        ]);
        $webviewCookie = Request::create('/api/core/home', 'GET');
        $webviewCookie->headers->set('referer', 'https://spa.test/dashboard');
        $webviewCookie->cookies->set('webview', true);

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($frontend));
        $this->assertFalse(EnsureFrontendRequestsAreStateful::fromFrontend($webviewHeader));
        $this->assertFalse(EnsureFrontendRequestsAreStateful::fromFrontend($webviewCookie));
    }

    #[Test]
    public function verify_active_state_allows_active_users(): void
    {
        $user = new class() {
            public function isInactive(): bool
            {
                return false;
            }
        };

        $request = Request::create('/api/core/home', 'GET');
        $request->setUserResolver(fn () => $user);

        $response = (new VerifyActiveState())->handle(
            $request,
            fn () => 'ok'
        );

        $this->assertSame('ok', $response);
    }

    #[Test]
    public function verify_active_state_throws_for_inactive_api_users_and_deletes_their_token(): void
    {
        $token = Mockery::mock();
        $token->shouldReceive('delete')->once();

        $user = Mockery::mock();
        $user->shouldReceive('isInactive')->once()->andReturn(true);
        $user->shouldReceive('currentAccessToken')->once()->andReturn($token);

        $request = Request::create('/api/core/home', 'GET');
        $request->attributes->set('sanctum', false);
        $request->setUserResolver(fn () => $user);

        $this->expectException(Authentication::class);
        $this->expectExceptionMessage(__('Your account has been disabled. Please contact the administrator'));

        (new VerifyActiveState())->handle($request, fn () => 'ok');
    }
}
