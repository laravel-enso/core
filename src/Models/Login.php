<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelEnso\Tables\Traits\TableCache;
use LaravelEnso\Users\Models\User;

class Login extends Model
{
    use TableCache;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
