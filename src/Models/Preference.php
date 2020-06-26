<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Preference extends Model
{
    use Rememberable;

    protected $guarded = ['id'];

    protected $casts = ['value' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
