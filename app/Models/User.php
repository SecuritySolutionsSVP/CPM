<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Searchable, SoftDeletes;

    // gets the role of the current user by exposing prop "$role"
    public function role() {
        return $this->belongsTo(Role::class);
    }

    // gets the users 2FA tokens by exposing prop "$twoFactorTokens"
    public function twoFactorTokens() {
        return $this->hasMany(TwoFactorUserToken::class)->withTimestamps();
    }

    // creates prop "$credentialAccessLog" that accesses list of credentials via user_credential_access_log table
    public function credentialAccessLogs() {
        return $this->hasMany(UserCredentialAccessLog::class)->withTimestamps();
    }

    // creates prop "$groups" that accesses list of groups via user_group table
    public function groups() {
        return $this->belongsToMany(Group::class, 'user_group')->withTimestamps();
    }

    // creates prop "$personalCredentialPrivileges" that accesses list of credentials via user_credential_privileges table
    public function personalCredentialPrivileges() {
        return $this->belongsToMany(Credential::class, 'user_credential_privileges')->withTimestamps();
    }

    public function getGroupCredentialPrivileges() {
        return new Collection($this->groups
            ->map(function ($group) {
                return $group->credentialPrivileges;
            })
            ->flatten(1)
            ->unique('id'));
    }

    public function getAllCredentialPrivileges() {
        return $this->personalCredentialPrivileges
            ->merge($this->getGroupCredentialPrivileges())
            ->unique('id');
    }

    public function fullName() {
        return "$this->first_name $this->last_name";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
    protected $dates = [
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];
}
