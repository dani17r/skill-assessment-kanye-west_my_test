<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Daniel Rangel',
            'email' => 'admin@admin.com',
            'isAdmin' => true,
            'moderating' => 1000,
            'banning' => false,
        ]);

        $this->call([
            UsersSeeder::class,
        ]);
    }
}
