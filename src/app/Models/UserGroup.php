<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\RoleManager\app\Traits\HasRoles;
use LaravelEnso\ActivityLog\app\Traits\LogsActivity;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserGroup extends Model
{
    use HasRoles, LogsActivity;

    protected $fillable = ['name', 'description'];

    protected $loggableLabel = 'name';

    protected $loggable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class, 'group_id');
    }

    public function delete()
    {
        if ($this->users()->count()) {
            throw new ConflictHttpException(
                __("The user group has users attached and can't be deleted")
            );
        }

        parent::delete();
    }
}

public function handle(LdapUser $ldapUser, EloquentUser $eloquentUser)
    {
        if ($eloquentUser->id) {
            Log::info('user exists');
            $eloquentUser->person->name = $ldapUser->getCommonName();

            return;
        }
            
        Log::warning('new user: ' . $ldapUser->getCommonName());
        $person = Person::firstOrCreate(['email' => $ldapUser->getUserPrincipalName()]
            , [
                'title' => Titles::Mr,
                'name' => $ldapUser->getCommonName(),
                'appellative' => optional($ldapUser)->givenname[0],
                'gender' => Genders::Male,
                'birthday' => substr(optional($ldapUser)->whencreated[0],0,8), //you likely want something else here
                'phone' => optional($ldapUser)->telephonenumber[0],
            ]);
        $eloquentUser->person()->associate($person);
        $eloquentUser->group()->associate(2); // 2 = Default
        $eloquentUser->role()->associate(2); // 2 = Default
        $eloquentUser->is_active = true;
        }
    }
