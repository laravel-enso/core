<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\ActivityLog\app\Traits\LogActivity;
use LaravelEnso\Core\app\Classes\TeamMemberChanges;

class Team extends Model
{
    use LogActivity;

    protected $fillable = ['name'];

    protected $loggableLabel = 'name';

    protected $loggable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function store($attributes)
    {
        $team = null;

        \DB::transaction(function () use (&$team, $attributes) {
            $team = self::firstOrCreate(
                ['name' => $attributes['name']]
            );

            $synced = $team->users()->sync($attributes['userIds']);

            if (count($synced['attached']) && count($synced['detached'])) {
                (new TeamMemberChanges($team, $synced))
                    ->log();
            }
        });

        return $team;
    }

    public function delete()
    {
        try {
            parent::delete();
        } catch (\Exception $e) {
            throw new ConflictHttpException(__(
                'The team has activity in the system and cannot be deleted'
            ));
        }

        return ['message' => 'The team was successfully deleted'];
    }

    public function userIds()
    {
        return $this->users->pluck('id');
    }

    public function userList()
    {
        return $this->users->map(function ($user) {
            return [
                'name' => $user->fullName,
                'avatar' => $user->avatar,
            ];
        });
    }
}
