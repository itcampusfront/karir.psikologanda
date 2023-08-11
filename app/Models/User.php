<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends \Ajifatur\FaturHelper\Models\User
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the attribute associated with the user.
     */
    public function attribute()
    {
        return $this->hasOne(UserAttribute::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Get the socmed associated with the user.
     */
    public function socmed()
    {
        return $this->hasOne(UserSocmed::class);
    }

    /**
     * Get the guardian associated with the user.
     */
    public function guardian()
    {
        return $this->hasOne(UserGuardian::class);
    }

    /**
     * Get the attachments for the user.
     */
    public function attachments()
    {
        return $this->hasMany(UserAttachment::class);
    }

    /**
     * Get the skills for the user.
     */
    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }

    /**
     * Get the results for the user.
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
