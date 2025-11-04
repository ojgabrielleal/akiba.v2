<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'slug',
        'username',
        'password',
        'name',
        'nickname',
        'gender',
        'avatar',
        'email',
        'birthday',
        'city',
        'state',
        'country',
        'bibliography',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
        'password' => 'hashed',
    ];

    protected $with = [
        'permissions', 
        'externalLinks',
        'likes'
    ];

    protected $appends = ['permissions_keys'];
    
    /**
    * Set accessor 'permissions_keys' in response
    */
    public function getPermissionsKeysAttribute()
    {
        $permissions = $this->getRelationValue('permissions');
        return $permissions ? $permissions->pluck('permission') : collect();
    }

    /**
     * Relationships from models 'UsersExternalLink' and 'UsersPermissions'
     */
    public function externalLinks()
    {
        return $this->hasMany(UserExternalLink::class, 'user_id');
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(UserLike::class, 'user_id');
    }

    /** 
     * Relationship from model 'Shows'
    */
    public function shows()
    {
        return $this->hasMany(Show::class, 'user_id');
    }

    /**
     * Relationship from model 'Autodj'
     */
    public function autodj()
    {
        return $this->hasOne(Autodj::class, 'user_id');
    }

    /**
     * Relationship from model 'Podcasts'
     */
    public function podcasts()
    {
        return $this->hasMany(Podcast::class, 'user_id');
    }

    /**
     * Relationship from model 'ReviewsContents'
     */
    public function reviewsContents()
    {
        return $this->hasMany(ReviewContent::class, 'user_id');
    }

    /**
     * Relationship from model 'Posts'
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * Relationship from model 'Events'
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    /**
     * Relationship from model 'Tasks'
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    /**
     * Relationship from model 'Calendar'
     */
    public function calendar()
    {
        return $this->hasMany(Calendar::class, 'user_id');
    }

    /**
     * Relationship from model 'Alerts'
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class, 'user_id');
    }

    /**
     * Relationship from model 'AlertsSignatures'
     */
    public function alertsSignatures()
    {
        return $this->hasMany(AlertSignature::class, 'user_id');
    }
}
