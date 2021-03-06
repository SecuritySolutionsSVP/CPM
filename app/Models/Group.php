<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Group extends Model
{
    use HasFactory, Searchable;

    // creates prop "$groupCredentialPrivileges" that accesses list of credentials via group_credential_privileges table
    public function credentialPrivileges() {
        return $this->belongsToMany(Credential::class, 'group_credential_privileges')->withTimestamps();
    }
    // creates prop "$users" that accesses list of users via user_group table
    public function users() {
        return $this->belongsToMany(User::class, 'user_group')->withTimestamps();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
