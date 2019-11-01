<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use LaravelEnso\ActionLogger\app\Traits\ActionLogs;
use LaravelEnso\Avatars\app\Traits\HasAvatar;
use LaravelEnso\Calendar\app\Models\Event;
use LaravelEnso\Core\app\Services\DefaultPreferences;
use LaravelEnso\Core\app\Traits\HasPassword;
use LaravelEnso\DynamicMethods\app\Traits\Relations;
use LaravelEnso\Files\app\Models\File;
use LaravelEnso\Files\app\Traits\Uploads;
use LaravelEnso\Helpers\app\Contracts\Activatable;
use LaravelEnso\Helpers\app\Traits\ActiveState;
use LaravelEnso\Helpers\app\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Impersonate\app\Traits\Impersonates;
use LaravelEnso\People\app\Models\Person;
use LaravelEnso\People\app\Traits\IsPerson;
use LaravelEnso\Rememberable\app\Traits\Rememberable;
use LaravelEnso\Roles\app\Enums\Roles;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Tables\app\Traits\TableCache;
use LaravelEnso\Teams\app\Models\Team;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class User extends Authenticatable implements Activatable, HasLocalePreference
{
    use ActionLogs, ActiveState, AvoidsDeletionConflicts, HasAvatar,
        HasPassword, Impersonates, IsPerson, Notifiable, Relations,
        Rememberable, TableCache, Uploads;

    protected $hidden = ['password', 'remember_token', 'password_updated_at'];

    protected $fillable = ['person_id', 'group_id', 'role_id', 'email', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean', 'person_id' => 'int', 'group_id' => 'int', 'role_id' => 'int',
    ];

    protected $dates = ['password_updated_at'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function group()
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->person->company();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function files()
    {
        return $this->hasMany(File::class, 'created_by');
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
        return $this->role_id === App::make(Roles::class)::Admin;
    }

    public function isSupervisor()
    {
        return $this->role_id === App::make(Roles::class)::Supervisor;
    }

    public function belongsToAdminGroup()
    {
        return $this->group_id === App::make('user-groups')::Admin;
    }

    public function isPerson(Person $person)
    {
        return $this->person_id === $person->id;
    }

    public function resetPreferences()
    {
        $this->storePreferences($this->defaultPreferences());
    }

    public function preferences()
    {
        $preferences = $this->preference
            ? $this->preference->value
            : $this->defaultPreferences()->value;

        unset($this->preference);

        return $preferences;
    }

    public function preferredLocale()
    {
        return $this->lang();
    }

    public function lang()
    {
        return $this->preferences()
            ->global
            ->lang;
    }

    private function defaultPreferences()
    {
        return new Preference([
            'value' => DefaultPreferences::data(),
        ]);
    }

    public function storeGlobalPreferences($global)
    {
        $preferences = $this->preferences();
        $preferences->global = $global;

        $this->storePreferences($preferences);
    }

    public function storeLocalPreferences($route, $value)
    {
        $preferences = $this->preferences();
        $preferences->local->$route = $value;

        $this->storePreferences($preferences);
    }

    public function delete()
    {
        if ($this->logins()->first() !== null) {
            throw new ConflictHttpException(__(
                'The user has activity in the system and cannot be deleted'
            ));
        }

        try {
            parent::delete();
        } catch (\Exception $e) {
            throw new ConflictHttpException(__(
                'The user has assigned resources in the system and cannot be deleted'
            ));
        }
    }

    private function storePreferences($preferences)
    {
        $this->preference()->updateOrCreate(
            ['user_id' => $this->id],
            ['value' => $preferences]
        );
    }
}
