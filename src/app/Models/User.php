<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LaravelEnso\ActionLogger\app\Traits\ActionLogger;
use LaravelEnso\Core\app\Classes\DefaultPreferences;
use LaravelEnso\Core\app\Notifications\ResetPasswordNotification;
use LaravelEnso\Helpers\Traits\FormattedTimestamps;
use LaravelEnso\Helpers\Traits\IsActiveTrait;
use LaravelEnso\Impersonate\app\Traits\Impersonate;

class User extends Authenticatable
{
    use Impersonate, IsActiveTrait, FormattedTimestamps, ActionLogger, Notifiable;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['first_name', 'last_name', 'phone', 'is_active'];

    protected $appends = ['full_name'];

    public function owner()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\Owner');
    }

    public function avatar()
    {
        return $this->hasOne('LaravelEnso\AvatarManager\app\Models\Avatar');
    }

    public function getAvatarId()
    {
        $id = $this->avatar ? $this->avatar->id : null;
        unset($this->avatar);

        return $id;
    }

    public function role()
    {
        return $this->belongsTo('LaravelEnso\RoleManager\app\Models\Role');
    }

    public function logins()
    {
        return $this->hasMany('LaravelEnso\Core\app\Models\Login');
    }

    public function preference()
    {
        return $this->hasOne('LaravelEnso\Core\app\Models\Preference');
    }

    public function getPreferences()
    {
        $preferences = $this->preference ? $this->preference->value : (new DefaultPreferences())->getData();
        unset($this->preference);

        return $preferences;
    }

    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function getLanguage()
    {
        return $this->getPreferences()->global->lang;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }
}
