<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Memanggil seeder yang telah dibuat
        $this->call([
            //CategorySeeder::class,
            //TagSeeder::class,
            //PostSeeder::class,
            UserSeeder::class,
        ]);
    }
}
