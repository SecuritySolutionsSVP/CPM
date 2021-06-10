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
    public $shownUsers;
    public $searchString;
    public $noneUsers;
    public $groupID;
    public $addModal = false;

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
