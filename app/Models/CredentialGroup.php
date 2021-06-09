<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class CredentialGroup extends Model
{
    use HasFactory, Searchable;

    public function credentials() {
        return $this->hasMany(Credential::class)->withTimestamps();
    }

    public function groups() {
        return $this->belongsToMany(Group::class, 'group_credential_privileges')->withTimestamps();
    }

    public function usersByPersonalPrivilege() {
        return $this->belongsToMany(User::class, 'user_credential_privileges')->withTimestamps();
    }
}
