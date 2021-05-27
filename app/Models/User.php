<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Searchable;

    // gets the role of the current user by exposing prop "$role"
    public function role() {
        return $this->belongsTo(Role::class);
    }

    // gets the users 2FA tokens by exposing prop "$twoFactorTokens"
    public function twoFactorTokens() {
        return $this->hasMany(TwoFactorUserToken::class);
    }

    // creates prop "$credentialAccessLog" that accesses list of credentials via user_credential_access_log table
    public function credentialAccessLogs() {
        return $this->hasMany(UserCredentialAccessLog::class, 'user_credential_access_log');
    }

    // public function credentialsAccessed() {
    //     return $this->belongsToMany(Credential::class, "user_credential_access_log");
    // }

    // creates prop "$personalCredentialPrivileges" that accesses list of credentials via user_credential_privileges table
    public function personalCredentialPrivileges() {
        return $this->belongsToMany(Credential::class, 'user_credential_privileges');
    }
    // creates prop "$groups" that accesses list of groups via user_group table
    public function groups() {
        return $this->belongsToMany(Group::class, 'user_group');
    }

    public function getGroupCredentialPrivileges() {
        // $credentials = new Collection();
        // $this->groups->each(function ($group, $key) use ($credentials) {
        //     $credentials->merge($group->credentialPrivileges);
        // });
        // return $credentials;

        return $this->groups
            ->map(function ($group) {
                return $group->credentialPrivileges;
            })
            ->flatten(1)
            ->unique('id');
    }

    public function getAllCredentialPrivileges() {
        return $this->getGroupCredentialPrivileges()
            ->merge($this->personalCredentialPrivileges)
            ->unique('id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
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
    ];
}
