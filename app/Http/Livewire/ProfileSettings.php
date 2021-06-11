<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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

        $credentials['email'] = $formData['email'];
        $credentials['password'] = $formData['current_password'];

        $user = $this->user;
        if (!empty($formData['password']) && Auth::attempt($credentials,false,false) && $formData['password'] == $formData['c_password']) {
            $user->password = bcrypt($formData['password']);
        }

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
