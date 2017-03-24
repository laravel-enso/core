<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'display_name', 'flag'];

    public static function allExceptDefault()
    {
        return self::where('name', '<>', config('app.fallback_locale'));
    }
}
