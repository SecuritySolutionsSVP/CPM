<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GroupOverview extends Component
{
    public $groups;
    public $selectedGroup;
    public $showModal = false;
    
    public function render()
    {
        return view('livewire.group-overview');
    }

    public function editGroupModal($groupId) {
        $this->selectedGroup = $this->findGroupById($groupId);
        $this->showModal = true;
    }

    private function findGroupById($groupId) {
        return $this->groups->first(function($group) use ($groupId) {
            return $group->id == $groupId;
        });
    }
}
