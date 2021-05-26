<?php

namespace Database\Seeders;

use App\Models\Credential;
use App\Models\Group;
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
        // generate models
        $users = User::factory(10)->create();

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
