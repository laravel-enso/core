<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

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
        $team = self::firstOrCreate(
            ['name' => $attributes['name']]
        );

        $team->users()->sync($attributes['userList']);

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
