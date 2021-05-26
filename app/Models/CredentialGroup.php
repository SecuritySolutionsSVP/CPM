<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CredentialGroup extends Model
{
    use HasFactory;

    public function credentials() {
        return $this->hasMany(Credential::class);
    }

    public function groups() {
        return $this->belongsToMany(Group::class, 'group_credential_privileges');
    }

    public function usersByPersonalPrivilege() {
        return $this->belongsToMany(User::class, 'user_credential_privileges');
    }
}
