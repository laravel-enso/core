<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = ['user_id', 'value'];

    protected $casts = ['value' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
