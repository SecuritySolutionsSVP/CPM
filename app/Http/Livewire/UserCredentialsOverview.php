<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\Credential;

class UserCredentialsOverview extends Component
{
    public $credentials;
    public $shownCredentials;
    public $searchString;
    public $userID;
    
    public $addModal = false;
    public $addCredentialSearchString;
    public $noneCredentials;
    public $shownNoneCredentials;

    public function mount() {
        $this->getNoneCredentials();
        $this->shownCredentials = $this->credentials;
    }
    public function render()
    {
        $credentials = $this->credentials;
        $foundCredentials = Credential::search($this->searchString)->get();

        $foundCredentials = $foundCredentials->filter(function($credential) use ($credentials) {
            return $credentials->contains('id', $credential->id);
        });

        if($foundCredentials->count() > 0) {
            $this->shownCredentials = $foundCredentials;
        } else {
            $this->shownCredentials = $this->credentials;
        }

        $noneCredentials = $this->noneCredentials;
        $foundNoneCredentials = Credential::search($this->addCredentialSearchString)->get();
        $foundNoneCredentials = $foundNoneCredentials->filter(function($credential) use ($noneCredentials) {
            return $noneCredentials->contains('id', $credential->id);
        });
        if($foundNoneCredentials->count() > 0) {
            $this->shownNoneCredentials = $foundNoneCredentials;
        } else {
            $this->shownNoneCredentials = $this->noneCredentials;
        }

        return view('livewire.user-credentials-overview');
    }

    public function addCredentialModal() {
        $this->getNoneCredentials();
        $this->addModal = true;
    }

    public function getNoneCredentials()
    {
        $request = new Request();
        $request->replace(['user_id' => $this->userID]);
        $this->noneCredentials = UserController::getNoneUserCredentials($request);
    }

    public function getCredentials()
    {
        $request = new Request();
        $request->replace(['user_id' => $this->userID]);
        $credentials = UserController::getUserCredentials($request);
        $request->replace(['id' =>  $credentials]);
        $this->credentials=CredentialController::getCredentialsInfo($request);
    }

    public function addCredential($id) {
        $request = new Request();
        $request->replace(['user_id' => $this->userID, 'credential_id' => $id]);
        UserController::addCredentialToUser($request);
        $this->getNoneCredentials();
        $this->getCredentials();
    }

    public function removeCredential($id) {
        $request = new Request();
        $request->replace(['user_id' => $this->userID, 'credential_id' => $id]);
        UserController::removeCredentialFromUser($request);
        $this->getNoneCredentials();
        $this->getCredentials();
    }
}
