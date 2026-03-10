<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Localisation\Models\Language;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Users\Models\User;

class Preferences extends Model
{
    use HasFactory;
    use Rememberable;

    protected array $rememberableKeys = ['id', 'user_id'];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lang(): string
    {
        return $this->global('lang');
    }

    public function global(?string $preference = null): mixed
    {
        return $preference
            ? $this->value['global'][$preference]
            : $this->value['global'];
    }

    public function local(?string $preference = null): mixed
    {
        return $preference
            ? $this->value['local'][$preference]
            : $this->value['local'];
    }

    public function setGlobal(mixed $global): void
    {
        $this->value['global'] = $global;

        $this->update(['value' => $this->value]);
    }

    public function setLocal(string $route, mixed $local): void
    {
        $this->value['local'][$route] = $local;

        $this->update(['value' => $this->value]);
    }

    public function setTheme(string $theme): void
    {
        $value = $this->value;
        $value['global']['theme'] = $theme;

        $this->update(['value' => $value]);
    }

    public function setLanguage(Language $language): void
    {
        $value = $this->value;
        $value['global']['lang'] = $language->name;

        $this->update(['value' => $value]);
    }

    public function reset(): void
    {
        $this->update(['value' => self::factory()->make()->value]);
    }

    protected function casts(): array
    {
        return ['value' => 'array'];
    }
}
