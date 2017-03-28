<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = ['user_id', 'original_name', 'saved_name'];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
