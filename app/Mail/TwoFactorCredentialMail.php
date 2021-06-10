<?php

namespace App\Mail;

use App\Models\TwoFactorCredentialToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCredentialMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The token instance.
     * 
     * @var \App\Models\TwoFactorCredentialToken
     */
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TwoFactorCredentialToken $token)
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
        return $this->view('mail.two_factor_credential_mail')
                    ->with([
                        'token' => $this->token->name,
                        'expiration' => $this->token->expiration,
                        'credential' => $this->token->credential
                    ]);
    }
}
