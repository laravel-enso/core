<?php

namespace LaravelEnso\Core\App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use LaravelEnso\ActionLogger\App\Traits\ActionLogs;
use LaravelEnso\Avatars\App\Traits\HasAvatar;
use LaravelEnso\Calendar\App\Models\Event;
use LaravelEnso\Core\App\Enums\UserGroups;
use LaravelEnso\Core\App\Exceptions\UserConflict;
use LaravelEnso\Core\App\Services\DefaultPreferences;
use LaravelEnso\Core\App\Traits\HasPassword;
use LaravelEnso\DynamicMethods\App\Traits\Relations;
use LaravelEnso\Files\App\Models\File;
use LaravelEnso\Files\App\Traits\Uploads;
use LaravelEnso\Helpers\App\Contracts\Activatable;
use LaravelEnso\Helpers\App\Traits\ActiveState;
use LaravelEnso\Helpers\App\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\App\Traits\CascadesMorphMap;
use LaravelEnso\Impersonate\App\Traits\Impersonates;
use LaravelEnso\People\App\Models\Person;
use LaravelEnso\People\App\Traits\IsPerson;
use LaravelEnso\Rememberable\App\Traits\Rememberable;
use LaravelEnso\Roles\App\Enums\Roles;
use LaravelEnso\Roles\App\Models\Role;
use LaravelEnso\Tables\App\Traits\TableCache;
use LaravelEnso\Teams\App\Models\Team;

class User extends Authenticatable implements Activatable, HasLocalePreference
{
    use HasApiTokens, ActionLogs, ActiveState, AvoidsDeletionConflicts, CascadesMorphMap,
        HasAvatar, HasPassword, Impersonates, IsPerson, Notifiable,
        Relations, Rememberable, TableCache, Uploads;

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
