<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class ProfileSettings extends Component
{
    public $user;


    public function render()
    {
        return view('livewire.profile-settings');
    }

    public function editUser($formData)
    {
        $request = [
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'email' => $formData['email'],
            'locale' => $formData['locale'],
        ];
        $user = $this->user;
        $user->update($request);
        return redirect('/profile');
    }

    public function deleteUser($userId)
    {
        $user = $this->findUserById($userId);
        $user->delete();
        return redirect('/');
    }
}
