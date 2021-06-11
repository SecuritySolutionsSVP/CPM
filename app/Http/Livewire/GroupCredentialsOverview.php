<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use App\Models\Credential;

class GroupCredentialsOverview extends Component
{
    public $credentials;
    public $shownCredentials;
    public $searchString;
    public $groupID;
    
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

        return view('livewire.group-credentials-overview');
    }

    public function addCredentialModal() {
        $this->getNoneCredentials();
        $this->addModal = true;
    }

    public function getNoneCredentials()
    {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID]);
        $this->noneCredentials = GroupController::getNoneGroupCredentials($request);
    }

    public function getCredentials()
    {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID]);
        $credentials = GroupController::getGroupCredentials($request);
        $request->replace(['id' =>  $credentials]);
        $this->credentials=CredentialController::getCredentialsInfo($request);
    }

    public function addCredential($id) {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID, 'credential_id' => $id]);
        GroupController::addCredentialToGroup($request);
        $this->getNoneCredentials();
        $this->getCredentials();
    }

    public function removeCredential($id) {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID, 'credential_id' => $id]);
        GroupController::removeCredentialFromGroup($request);
        $this->getNoneCredentials();
        $this->getCredentials();
    }
}
