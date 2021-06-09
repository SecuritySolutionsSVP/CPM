<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Credential extends Model
{
    use HasFactory, Searchable;

    public function credentialGroup() {
        return $this->belongsTo(CredentialGroup::class);
    }

    public function privilegedGroups() {
        return $this->belongsToMany(Group::class, 'group_credential_privileges')->withTimestamps();
    }

    public function privilegedUsers() {
        return $this->belongsToMany(User::class, 'user_credential_privileges')->withTimestamps();
    }

    public function credentialAccessLogs() {
        return $this->hasMany(UserCredentialAccessLog::class)->withTimestamps();
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'credential_group_id',
        'is_sensitive',
    ];
}
