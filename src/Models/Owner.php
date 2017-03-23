<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'name', 'fiscal_code', 'reg_com_nr', 'city', 'county', 'bank', 'bank_account', 'postal_code', 'contact', 'phone', 'email', 'address', 'is_individual', 'is_active',
    ];

    public function comments()
    {
        return $this->morphMany('LaravelEnso\CommentsManager\Comment', 'commentable');
    }

    public function documents()
    {
        return $this->morphMany('LaravelEnso\DocumentsManager\Document', 'documentable');
    }

    public function users()
    {
        return $this->hasMany('LaravelEnso\Core\Models\User');
    }

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\Core\Models\Role');
    }

    public function getRolesListAttribute()
    {
        return $this->roles->pluck('id')->toArray();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeIndividual($query)
    {
        return $query->where('is_individual', 1);
    }
}
