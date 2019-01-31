<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Multitenancy\app\Traits\SystemConnection;

class Login extends Model
{
    use SystemConnection;

    protected $fillable = ['user_id', 'ip', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
