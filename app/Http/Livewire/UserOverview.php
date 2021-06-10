<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class UserOverview extends Component
{
    public $users;
    public $shownUsers;
    public $searchString;
    public $selectedUser;
    public $showModal = false;


    public function render()
    {
        $users = $this->users;
        $foundUsers = User::search($this->searchString)->get();

        $foundUsers = $foundUsers->filter(function($user) use ($users) {
            return $users->contains('id', $user->id);
        });

        if($foundUsers->count() > 0) {
            $this->shownUsers = $foundUsers;
        } else {
            $this->shownUsers = $this->users;
        }
        return view('livewire.user-overview');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUser = '';
    }

    public function createUser($formData)
    {
        $password = Hash::make(Str::random(8));
        $request = [
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'role_id' => $formData['role_id'],
            'email' => $formData['email'],
            'password' => $password,
            'c_password' => $password,
            'locale' => $formData['locale']
        ];
        $user = new User();
        $user->create($request);
        return redirect('/users');
    }

    public function editUser($formData)
    {
        $request = [
            'id' => $formData['id'],
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'role_id' => $formData['role_id'],
            'email' => $formData['email'],
            'locale' => $formData['locale'],
        ];
        $user = $this->findUserById($formData['id']);
        $user->update($request);
        return redirect('/users');
    }

    public function deleteUser($userId)
    {
        $user = $this->findUserById($userId);
        $user->delete();
        return redirect('/users');
    }

    public function editUserModal($userId)
    {
        $this->selectedUser = $this->findUserById($userId);
        $this->showModal = true;
    }

    private function findUserById($userId)
    {
        return $this->users->first(function ($user) use ($userId) {
            return $user->id == $userId;
        });
    }
}
