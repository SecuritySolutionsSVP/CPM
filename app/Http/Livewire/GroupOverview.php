<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GroupOverview extends Component
{
    public $groups;
    public $showModal = false;
    
    public function render()
    {
        return view('livewire.group-overview');
    }
}
