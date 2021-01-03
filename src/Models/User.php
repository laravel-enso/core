<?php

namespace LaravelEnso\Core\Models;

use Exception;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use LaravelEnso\Calendar\Models\Event;
use LaravelEnso\Core\Enums\UserGroups;
use LaravelEnso\Core\Exceptions\UserConflict;
use LaravelEnso\Core\Services\DefaultPreferences;
use LaravelEnso\Core\Traits\HasPassword;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Files\Models\File;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\Traits\CascadesMorphMap;
use LaravelEnso\People\Models\Person;
use LaravelEnso\People\Traits\IsPerson;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Roles\Enums\Roles;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Tables\Traits\TableCache;
use LaravelEnso\Teams\Models\Team;

class User extends Authenticatable implements Activatable, HasLocalePreference
{
    use ActiveState,
        AvoidsDeletionConflicts,
        CascadesMorphMap,
        HasApiTokens,
        HasFactory,
        HasPassword,
        IsPerson,
        Notifiable,
        Abilities,
        Rememberable,
        TableCache;

    protected $hidden = ['password', 'remember_token', 'password_updated_at'];

    protected $guarded = ['id', 'password'];

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
        return $this->group_id === App::make(UserGroups::class)::Admin;
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
        return $this->preferences()->global->lang;
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

    public function erase(bool $person = false)
    {
        if ($person) {
            return DB::transaction(fn () => tap($this)->delete()->person->delete());
        }

        return $this->delete();
    }

    public function delete()
    {
        if ($this->logins()->exists()) {
            throw UserConflict::hasActivity();
        }

        try {
            return parent::delete();
        } catch (Exception $exception) {
            throw UserConflict::hasActivity();
        }
    }

    private function storePreferences($preferences)
    {
        $this->preference()->updateOrCreate(
            ['user_id' => $this->id],
            ['value' => $preferences]
        );
    }

    private function defaultPreferences()
    {
        return new Preference([
            'value' => DefaultPreferences::data(),
        ]);
    }
}
