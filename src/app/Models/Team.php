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

    public function getUserListAttribute()
    {
        $userList = $this->users->pluck('id');
        $this->users->each->append('avatarId');

        return $userList;
    }

    public static function store($attributes)
    {
        $team = null;

        \DB::transaction(function () use (&$team, $attributes) {
            $team = self::firstOrCreate(
                ['name' => $attributes['name']]
            );

            $synced = $team->users()->sync($attributes['userList']);

            if (count($synced['attached']) && count($synced['detached'])) {
                (new TeamMemberChanges($team, $synced))
                    ->log();
            }
        });

        return $team->append('userList');
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
}
