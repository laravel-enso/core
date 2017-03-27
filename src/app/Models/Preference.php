<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = ['key', 'value'];

    public function user()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\User');
    }
}
