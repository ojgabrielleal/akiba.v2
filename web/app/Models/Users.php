<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
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
        return $this->hasMany(UsersExternalsLinks::class);
    }

    public function permissions()
    {
        return $this->hasMany(UsersPermissions::class);
    }

    /** 
     * Relationship from model 'Shows'
    */
    public function shows()
    {
        return $this->hasMany(Shows::class);
    }

    /**
     * Relationship from model 'Autodj'
     */
    public function autodj()
    {
        return $this->hasOne(Autodj::class);
    }

    /**
     * Relationship from model 'Podcasts'
     */
    public function podcasts()
    {
        return $this->hasMany(Podcasts::class);
    }

    /**
     * Relationship from model 'ReviewsContents'
     */
    public function reviewsContents()
    {
        return $this->hasMany(ReviewsContents::class);
    }

    /**
     * Relationship from model 'Posts'
     */
    public function posts()
    {
        return $this->hasMany(Posts::class);
    }

    /**
     * Relationship from model 'Events'
     */
    public function events()
    {
        return $this->hasMany(Events::class);
    }

    /**
     * Relationship from model 'Tasks'
     */
    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

    /**
     * Relationship from model 'Calendar'
     */
    public function calendar()
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * Relationship from model 'Alerts'
     */
    public function alerts()
    {
        return $this->hasMany(Alerts::class);
    }

    /**
     * Relationship from model 'AlertsSignatures'
     */
    public function alertsSignatures()
    {
        return $this->hasMany(AlertsSignatures::class);
    }
}
