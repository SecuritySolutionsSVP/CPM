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
        return $this->belongsToMany(Group::class, 'group_credential_privileges');
    }

    public function privilegedUsers() {
        return $this->belongsToMany(User::class, 'user_Credential_privileges');
    }

    public function credentialAccessLogs() {
        return $this->hasMany(UserCredentialAccessLog::class, 'user_credential_access_log');
    }
}
