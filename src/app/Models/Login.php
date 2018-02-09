<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['user_id', 'ip', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
