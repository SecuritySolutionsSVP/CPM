<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserOverview extends Component
{
    
    public $showModal = false;


    public function render()
    {
        return view('livewire.user-overview');
    }


}
