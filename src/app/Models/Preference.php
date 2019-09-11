<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Rememberable\app\Traits\Rememberable;

class Preference extends Model
{
    use Rememberable;

    protected $fillable = ['user_id', 'value'];

    protected $casts = ['value' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
