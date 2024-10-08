<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Users\Models\User;

class Preference extends Model
{
    use Rememberable;

    protected array $rememberableKeys = ['id', 'user_id'];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return ['value' => 'object'];
    }
}
