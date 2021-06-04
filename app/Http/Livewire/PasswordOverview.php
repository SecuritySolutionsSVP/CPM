<?php

namespace App\Http\Livewire;

use App\Models\Credential;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PasswordOverview extends Component
{
    
    public $credentials;
    public $selectedCredential;
    
    public $showModal = false;

    public function render()
    {
        return view('livewire.password-overview');
    }

    public function displayCredentialModal($credId) {
        $this->selectedCredential = $this->findCredentialById($credId);
        $this->showModal = true;
    } 

    private function findCredentialById($id) {
        return $this->credentials->first(function ($credential) use ($id) {
            return $credential->id == $id;
        });
    }
}
