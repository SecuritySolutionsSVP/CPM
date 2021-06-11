<?php

namespace App\Mail;

use App\Models\TwoFactorCredentialToken;
use App\Models\TwoFactorUserToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The token instance.
     * 
     * @var \App\Models\TwoFactorUserToken
     */
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TwoFactorUserToken $token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.two_factor_user_mail')
                    ->with([
                        'token' => $this->token->token,
                        'expiration' => $this->token->expiration,
                        'user' => $this->token->user
                    ]);
    }
}
