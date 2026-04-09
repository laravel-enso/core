<?php

namespace LaravelEnso\Core\Tests;

use LaravelEnso\Core\Http\Middleware\XssSanitizer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class XssSanitizerTest extends TestCase
{
    #[Test]
    public function it_sanitizes_nested_string_payloads(): void
    {
        $request = new class() {
            private array $data = [
                'title' => '<b>Hello</b>',
                'meta'  => ['body' => '<div style="color:red" onclick="alert(1)">World</div>'],
            ];

            public function all(array $fields): array
            {
                return array_intersect_key($this->data, array_flip($fields));
            }

            public function merge(array $data): void
            {
                $this->data = array_replace($this->data, $data);
            }

            public function data(): array
            {
                return $this->data;
            }
        };

        $middleware = new XssSanitizer();

        $middleware->handle($request, fn ($request) => $request, 'title', 'meta');

        $this->assertSame('Hello', $request->data()['title']);
        $this->assertSame('World', $request->data()['meta']['body']);
    }

    #[Test]
    public function it_leaves_non_string_values_untouched(): void
    {
        $request = new class() {
            private array $data = [
                'count' => 5,
                'flags' => [true, false, null],
            ];

            public function all(array $fields): array
            {
                return array_intersect_key($this->data, array_flip($fields));
            }

            public function merge(array $data): void
            {
                $this->data = array_replace($this->data, $data);
            }

            public function data(): array
            {
                return $this->data;
            }
        };

        $middleware = new XssSanitizer();

        $middleware->handle($request, fn ($request) => $request, 'count', 'flags');

        $this->assertSame(5, $request->data()['count']);
        $this->assertSame([true, false, null], $request->data()['flags']);
    }
}
