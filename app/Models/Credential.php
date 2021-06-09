<?php

namespace App\Models;

use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Credential extends Model
{
    use HasFactory, Searchable, EncryptableDbAttribute, SoftDeletes;

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
        return $this->hasMany(UserCredentialAccessLog::class);
    }

     /** 
      * The attributes that should be encrypted/decrypted
      *
      * @var array
      */
    protected $encryptable = [
        'password',
    ];
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
