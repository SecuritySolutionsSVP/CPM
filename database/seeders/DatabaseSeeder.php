<?php

namespace Database\Seeders;

use App\Models\Credential;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'Administrator', 'priviledge_level' => 1]);
        $managerRole = Role::create(['name' => 'Manager', 'priviledge_level' => 2]);
        $standardRole = Role::create(['name' => 'Standard', 'priviledge_level' => 3]);
        // generate models
        $users = User::factory(10)->create(['role_id' => $standardRole->id]);
        $adminUser = $users[0];
        $adminUser->role_id = $adminRole->id;
        $adminUser->save();
        $managerUser = $users[1];
        $managerUser->role_id = $managerRole->id;
        $managerUser->save();

        $credentials = Credential::factory(10)->create();

        $groups = Group::factory(10)->create();

        // populate pivot tables
        $users->each(function ($user) use ($groups, $credentials) {
            $user->groups()->attach(
                $groups->random(rand(1, 3))->pluck('id')->toArray()
            );

            $user->personalCredentialPrivileges()->attach(
                $credentials->random(rand(1,3))->pluck('id')->toArray()
            );
        });

        $groups->each(function ($group) use ($credentials) {
            $group->credentialPrivileges()->attach(
                $credentials->random(rand(1,3))->pluck('id')->toArray()
            );
        });

    }
}
