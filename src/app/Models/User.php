<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LaravelEnso\ActionLogger\app\Traits\ActionLogger;
use LaravelEnso\AvatarManager\app\Models\Avatar;
use LaravelEnso\Core\app\Classes\DefaultPreferences;
use LaravelEnso\Core\app\Notifications\ResetPasswordNotification;
use LaravelEnso\Helpers\Traits\FormattedTimestamps;
use LaravelEnso\Helpers\Traits\IsActive;
use LaravelEnso\Impersonate\app\Traits\Impersonate;
use LaravelEnso\RoleManager\app\Models\Role;

class User extends Authenticatable
{
    use Impersonate, IsActive, FormattedTimestamps, ActionLogger, Notifiable;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['first_name', 'last_name', 'phone', 'is_active'];

    protected $attributes = ['is_active' => false];

    protected $appends = ['fullName'];

    protected $casts = ['is_active' => 'boolean'];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    public function preference()
    {
        return $this->hasOne(Preference::class);
    }

    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    public function getPreferencesAttribute()
    {
        $preferences = $this->preference
            ? $this->preference->value
            : (new DefaultPreferences())->getData();

        unset($this->preference);

        return $preferences;
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function getAvatarIdAttribute()
    {
        $id = $this->avatar ? $this->avatar->id : null;
        unset($this->avatar);

        return $id;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }
}
