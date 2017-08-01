<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Core\app\Models\User;

class Preference extends Model
{
    protected $fillable = ['value'];

    protected $casts = [
        'value' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
