<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorUserToken extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public static function generateCode($codeLength = 4)
    {
        // Code snippet from https://www.sitepoint.com/secure-laravel-apps-2fa-via-sms/
        $min = pow(10, $codeLength - 1);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'expiration'
    ];
}
