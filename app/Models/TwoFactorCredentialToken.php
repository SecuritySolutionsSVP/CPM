<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorCredentialToken extends Model
{
    use HasFactory;

    public function credential() {
        return $this->belongsTo(Credential::class);
    }

    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public function generateCode($codeLength = 4)
    {
        // Code snippet from https://www.sitepoint.com/secure-laravel-apps-2fa-via-sms/
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }
}
