<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;
use App\User\Model\InternalUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $user = InternalUser::factory()->create();

        $token = $user->createToken('Default Token');

        dump(
            'Token for requests:', $token->plainTextToken
        );
    }
}
