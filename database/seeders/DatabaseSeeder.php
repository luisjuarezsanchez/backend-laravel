<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Llamar al seeder AdminSeeder
        $this->call(AdminSeeder::class);

        // Llamar al seeder UserSeeder
        $this->call(UserSeeder::class);
    }
}
