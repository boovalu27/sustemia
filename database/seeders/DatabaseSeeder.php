<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llama a los seeders
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            AreaSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
