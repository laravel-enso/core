<?php

namespace LaravelEnso\Core\app\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LaravelEnso\AvatarManager\app\Models\Avatar;
use LaravelEnso\Core\app\Notifications\ResetPasswordNotification;
use LaravelEnso\Impersonate\app\Traits\Model\Impersonate;

class User extends Authenticatable
{
    use Notifiable, Impersonate;

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'is_active', 'role_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['avatar_id', 'full_name', 'preferences'];

    public function owner()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\Owner');
    }

    public function avatar()
    {
        return $this->hasOne('LaravelEnso\AvatarManager\app\Models\Avatar');
    }

    public function getAvatarIdAttribute()
    {
        $id = $this->avatar ? $this->avatar->id : null;
        unset($this->avatar);

        return $id;
    }

    public function role()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\Role');
    }

    public function logins()
    {
        return $this->hasMany('LaravelEnso\Core\app\Models\Login');
    }

    public function preference()
    {
        return $this->hasOne('LaravelEnso\Core\app\Models\Preference');
    }

    public function action_logs()
    {
        return $this->hasMany('LaravelEnso\ActionLogger\app\Models\ActionLog');
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function hasAccessTo($route)
    {
        return $this->role->permissions->pluck('name')->search($route) !== false;
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    public function getBirthdayAttribute()
    {
        //
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }
}
