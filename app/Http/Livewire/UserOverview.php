<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserOverview extends Component
{
    public $users;
    public $selectedUser;
    public $showModal = false;


    public function render()
    {
        return view('livewire.user-overview');
    }

    public function editUserModal($userId) {
        $this->selectedGroup = $this->findGroupById($userId);
        $this->showModal = true;
    }

    private function findUserById($userId) {
        return $this->users->first(function($user) use ($userId) {
            return $user->id == $userId;
        });
    }


}
