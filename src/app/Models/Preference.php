<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Multitenancy\app\Traits\SystemConnection;

class Preference extends Model
{
    use SystemConnection;

    protected $fillable = ['user_id', 'value'];

    protected $casts = ['value' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
