<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PasswordOverview extends Component
{

    public $showModal = false;


    public function render()
    {
        return view('livewire.password-overview');
    }
}
