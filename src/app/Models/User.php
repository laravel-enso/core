<?php

namespace LaravelEnso\Core\app\Models;

use LaravelEnso\Core\app\Enums\Themes;
use Illuminate\Notifications\Notifiable;
use LaravelEnso\Helpers\app\Traits\IsActive;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\AvatarManager\app\Models\Avatar;
use LaravelEnso\Impersonate\app\Traits\Impersonate;
use LaravelEnso\Core\app\Classes\DefaultPreferences;
use LaravelEnso\ActionLogger\app\Traits\ActionLogger;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LaravelEnso\Core\app\Notifications\ResetPasswordNotification;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class User extends Authenticatable
{
    use Impersonate, IsActive, ActionLogger, Notifiable;

    private const AdminRoleId = 1;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['first_name', 'last_name', 'phone', 'is_active', 'email', 'owner_id', 'role_id'];

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
        return $this->role_id === self::AdminRoleId;
    }

    public function theme()
    {
        return Themes::get($this->preferences->global->theme);
    }

    public function getPreferencesAttribute()
    {
        $preferences = $this->preference
            ? $this->preference->value
            : (new DefaultPreferences())->data();

        unset($this->preference);

        return $preferences;
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function getAvatarIdAttribute()
    {
        $id = optional($this->avatar)->id;

        unset($this->avatar);

        return $id;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }

    public function delete()
    {
        if ($this->logins()->count()) {
            throw new ConflictHttpException(__('The user has activity in the system and cannot be deleted'));
        }

        parent::delete();
    }
}
