<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{

	protected $fillable = ['user_id', 'original_name', 'saved_name'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
