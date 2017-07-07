<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['user_id', 'ip', 'user_agent'];

    public function user()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\User');
    }

    public function setUserAgentAttribute($value)
    {
    	$this->attributes['user_agent'] = $value ?
            substr($value, 0, 254) : null;
    }
}
