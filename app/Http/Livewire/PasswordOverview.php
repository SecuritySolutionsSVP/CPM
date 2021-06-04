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
    public $editModal = false;
    public $createModal = false; 

    public function render()
    {
        return view('livewire.password-overview');
    }

    public function displayCredentialAccessModal($credId) {
        $this->selectedCredential = $this->findCredentialById($credId);
        $this->showModal = true;
        $this->editModal = false;
        $this->createModal = false;
    }

    public function displayCredentialCreateModal() {
        $this->showModal = false;
        $this->editModal = false;
        $this->createModal = true;
    }

    public function displayCredentialEditModal($credId) {
        $this->selectedCredential = $this->findCredentialById($credId);
        $this->showModal = false;
        $this->editModal = true;
        $this->createModal = false;
    }

    private function findCredentialById($id) {
        return $this->credentials->first(function ($credential) use ($id) {
            return $credential->id == $id;
        });
    }
}
