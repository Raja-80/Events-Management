<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword')
        ]);

        // Create a regular user
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('userpassword')
        ]);
    }
}
