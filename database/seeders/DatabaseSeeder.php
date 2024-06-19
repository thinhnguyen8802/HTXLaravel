<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\CategoriesDefault;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(addAdminDefault::class);
        $this->call(CategoriesDefault::class);
        $this->call(LocationSeeder::class);
    }
}
