<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\GroupController;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupOverview extends Component
{
    public $groups;
    public $selectedGroup;
    public $createModal = false;
    public $editModal = false;
    
    public function render()
    {
        return view('livewire.group-overview');
    }

    public function createGroupModal() {
        $this->hideAllModals();
        $this->createModal = true;
    }

    public function editGroupModal($groupId) {
        $this->hideAllModals();
        $this->selectedGroup = $this->findGroupById($groupId);
        $this->editModal = true;
    }

    public function deleteGroupModal($groupId) {
        $this->selectedGroup = $this->findGroupById($groupId);

        $request = new Request();
        $request->replace(['id' => $groupId]);
        GroupController::delete($request);
    }

    private function findGroupById($groupId) {
        return $this->groups->first(function($group) use ($groupId) {
            return $group->id == $groupId;
        });
    }

    private function hideAllModals() {
        $this->editModal = false;
        $this->createModal = false;
    }

    public function createGroup($input) {
        if ($input['name'] != null){
            $request = new Request();
            $request->replace(['name' => $input['name']]);
            GroupController::create($request);
        } else {
            $this->hideAllModals();
        }
    }

    public function saveGroup($input) {
        if ($this->selectedGroup->name != $input['name']){
            $request = new Request();
            $request->replace(['id' => (int) $input['id'], 'name' => $input['name']]);
            GroupController::update($request);
        } else {
            $this->hideAllModals();
        }
    }
}
