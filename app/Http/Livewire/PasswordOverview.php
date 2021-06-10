<?php

namespace App\Http\Livewire;

use App\Models\Credential;
use App\Models\CredentialGroup;
use App\Models\UserCredentialAccessLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class PasswordOverview extends Component
{
    
    public $credentials;
    public $selectedCredential;
    public $shouldCreateNewCredentialGroup = false;
    
    public $showModal = false;
    public $editModal = false;
    public $createModal = false; 
    public $success = false;

    public $refreshPage = false;

    public function render()
    {
        return view('livewire.password-overview');
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
        $this->success = null;
    }
}
