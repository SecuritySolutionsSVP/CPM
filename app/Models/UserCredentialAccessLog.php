<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredentialAccessLog extends Model
{
    use HasFactory;


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function credential() {
        return $this->belongsTo(Credential::class);
    }
}
