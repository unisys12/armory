<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ManifestSeeder::class,
            ItemSeeder::class,
            CollectionSeeder::class,
        ]);

        // $this->call([ManifestSeeder::class]);
        // $this->call([ItemSeeder::class]);
        // $this->call([CollectionSeeder::class]);
    }
}
