<?php

namespace App\Http\Livewire;

use App\Mail\TwoFactorCredentialMail;
use App\Models\Credential;
use App\Models\CredentialGroup;
use App\Models\TwoFactorCredentialToken;
use App\Models\UserCredentialAccessLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class PasswordOverview extends Component
{
    
    public $credentials;
    public $shownCredentials;
    public $searchString;

    public $selectedCredential;
    public $shouldCreateNewCredentialGroup = false;
    
    public $showModal = false;
    public $editModal = false;
    public $createModal = false; 

    public $requireTwoFactor = false;
    public $showPassword = false;
    
    public $error = false;
    public $success = false;
    public $refreshPage = false;

    public $token;

    public function mount() {
        $this->shownCredentials = $this->credentials;
    }

    public function render()
    {
        $credentials = $this->credentials;
        $foundCredentials = Credential::search($this->searchString)->get();
        $foundCredentials = $foundCredentials->filter(function($cred) use ($credentials) {
            return $credentials->contains('id', $cred->id);
        });
        if($foundCredentials->count() > 0) {
            $this->shownCredentials = $foundCredentials;
        } else {
            $this->shownCredentials = $this->credentials;
        }
        return view('livewire.password-overview');
    }

    public function requestAccessToCredential() {
        $credential = $this->selectedCredential;
        $user = Auth::user();

        if($this->userCanAccessCredential($credential->id)) {
            // user is allowed to access password
            
            if($credential->is_sensitive) {
                $token = TwoFactorCredentialToken::create([
                    'credential_id' => $credential->id,
                    'token' => TwoFactorCredentialToken::generateCode(6),
                    'expiration' => Carbon::now()->addMinutes(10),
                ]);
                
                Mail::to($user)->send(new TwoFactorCredentialMail($token));
                $this->token = $token;
                $this->requireTwoFactor = true;
            } else {
                $this->showPassword($user, $credential);
            }
        } else {
            $this->error = true;
        }
    }
    public function userCanAccessCredential($credentialId) {
        $user = Auth::user();
        $userCredentials = $user->getAllCredentialPrivileges();
        return $user->role->priviledge_level <= 1 || $userCredentials->contains('id', $credentialId);
    }

    public function validateTwoFactorCode($formData) {
        $credential = $this->selectedCredential;
        $user = Auth::user();

        if($formData['token'] == $this->token->token) {
            $this->showPassword($user, $credential);
        } else {
            $this->error = true;
        }
    }

    private function showPassword($user, $credential) {
        UserCredentialAccessLog::create([
            'user_id' => $user->id,
            'credential_id' => $credential->id
        ]);
        $this->error = false;
        $this->requireTwoFactor = false;
        $this->showPassword = true;
    }

    public function createCredential($formData) {
        $credential = new Credential;
        $credentialGroup = filter_var($this->shouldCreateNewCredentialGroup, FILTER_VALIDATE_BOOLEAN)
            ? CredentialGroup::factory()->create(["name" => $formData['asset']])
            : $this->findCredentialGroupByName($formData['asset']);
        $credential->credentialGroup()->associate($credentialGroup);
        $credential->is_sensitive = isset($formData['is_sensitive']) 
            ? $formData['is_sensitive'] == "on"
            : false;
        $credential->username = $formData['username'];
        $credential->password = $formData['password'];
        $credential->password_last_updated_at = Carbon::now();
        $credential->save();

        // Fetch current user
        $user = Auth::user();

        // Give the user who made the credential access to the credential
        $credential->privilegedUsers()->attach($user->id);

        // Create an association that the user has read the password.
        UserCredentialAccessLog::create([
            'user_id' => $user->id,
            'credential_id' => $credential->id
        ]);

        $this->success = true;
        $this->refreshPage = true;
    }

    public function editPassword($formData) {
        $this->selectedCredential->password = $formData['password'];
        $this->selectedCredential->password_last_updated_at = Carbon::now();
        $this->selectedCredential->save();
        $this->success = true;
        $this->refreshPage = true;
    }

    public function deleteCredential($credId) {
        $credential = $this->findCredentialById($credId);
        $credential->delete();
        $this->refreshPage = true;
    }

    public function displayCredentialAccessModal($credId) {
        $this->hideAllModals();
        $this->selectedCredential = $this->findCredentialById($credId);
        $this->showModal = true;
    }

    public function displayCredentialCreateModal() {
        $this->hideAllModals();
        $this->shouldCreateNewCredentialGroup = "false";
        $this->createModal = true;
    }

    public function displayCredentialEditModal($credId) {
        $this->hideAllModals();
        $this->selectedCredential = $this->findCredentialById($credId);
        $this->editModal = true;
    }

    private function findCredentialById($id) {
        return $this->credentials->first(function ($credential) use ($id) {
            return $credential->id == $id;
        });
    }
    private function findCredentialGroupByName($name) {
        return CredentialGroup::firstWhere('name', $name);
    }

    public function hideAllModals() {
        $this->showModal = false;
        $this->editModal = false;
        $this->createModal = false;
        $this->shouldCreateNewCredentialGroup = "false";
        $this->selectedCredential = null;
        $this->showPassword = false;
        $this->requireTwoFactor = false;
        $this->success = null;
        $this->error = null;
    }
}
