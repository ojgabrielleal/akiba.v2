<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'slug',
        'username',
        'password',
        'name',
        'nickname',
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
    ];

    protected $casts = [
        'birthday' => 'date',
        'password' => 'hashed',
    ];


    /**
     * Relationships from models 'UsersExternalLink' and 'UsersPermissions'
     */
    public function externalLinks()
    {
        return $this->hasMany(UserExternalLinkModel::class, 'user_id');
    }

    public function permissions()
    {
        return $this->hasMany(UserPermissionModel::class, 'user_id');
    }

    /** 
     * Relationship from model 'Shows'
    */
    public function shows()
    {
        return $this->hasMany(ShowsModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Autodj'
     */
    public function autodj()
    {
        return $this->hasOne(AutodjModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Podcasts'
     */
    public function podcasts()
    {
        return $this->hasMany(PodcastsModel::class, 'user_id');
    }

    /**
     * Relationship from model 'ReviewsContents'
     */
    public function reviewsContents()
    {
        return $this->hasMany(ReviewsContentsModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Posts'
     */
    public function posts()
    {
        return $this->hasMany(PostsModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Events'
     */
    public function events()
    {
        return $this->hasMany(EventsModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Tasks'
     */
    public function tasks()
    {
        return $this->hasMany(TasksModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Calendar'
     */
    public function calendar()
    {
        return $this->hasMany(CalendarModel::class, 'user_id');
    }

    /**
     * Relationship from model 'Alerts'
     */
    public function alerts()
    {
        return $this->hasMany(AlertsModel::class, 'user_id');
    }

    /**
     * Relationship from model 'AlertsSignatures'
     */
    public function alertsSignatures()
    {
        return $this->hasMany(AlertsSignaturesModel::class, 'user_id');
    }
}
