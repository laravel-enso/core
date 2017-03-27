<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['user_id', 'ip'];

    public function user()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\User');
    }

    public function create(Login $login)
    {
        $login->save;
    }
}
