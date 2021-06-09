<?php

namespace App\Http\Livewire;

use App\Models\User;
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

    public function closeModal(){
        $this->showModal=false;
        $this->selectedUser='';
    }

    public function createUser(){
        
    }

    public function deleteUser($userId){
        $user = $this->findUserById($userId);
        $user->delete();
    }

    public function editUserModal($userId) {
        $this->selectedUser = $this->findUserById($userId);
        $this->showModal = true;
    }

    private function findUserById($userId) {
        return $this->users->first(function($user) use ($userId) {
            return $user->id == $userId;
        });
    }


}
