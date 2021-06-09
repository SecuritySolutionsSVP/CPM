<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use Illuminate\Http\Request;
use App\Models\User;

class GroupUsersOverview extends Component
{
    public $users;
    public $noneUsers;
    public $groupID;
    public $addModal = false;

    public function render()
    {
        return view('livewire.group-users-overview');
    }

    public function addUserModal() {
        $this->getNoneUsers();
        $this->addModal = true;
    }

    public function getNoneUsers()
    {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID]);
        $this->noneUsers = GroupController::getNoneGroupUsers($request);
    }

    public function getUsers()
    {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID]);
        $users = GroupController::getGroupUsers($request);
        $request->replace(['id' =>  $users]);
        $this->users=UserController::getUsersInfo($request);
    }

    public function addUser($id) {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID, 'user_id' => $id]);
        GroupController::addUserToGroup($request);
        $this->getNoneUsers();
        $this->getUsers();
    }

    public function removeUser($id) {
        $request = new Request();
        $request->replace(['group_id' => $this->groupID, 'user_id' => $id]);
        GroupController::removeUserFromGroup($request);
        $this->getNoneUsers();
        $this->getUsers();
    }
}
