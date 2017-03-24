<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['user_id', 'ip'];

    public function user()
    {
        return $this->belongsTo('LaravelEnso\Core\App\Models\User');
    }

    public function create(Login $login)
    {
        $login->save;
    }
}
