<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{

    protected $fillable = ['key', 'value'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
