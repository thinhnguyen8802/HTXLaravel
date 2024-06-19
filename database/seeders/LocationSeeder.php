<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sql = File::get(database_path('seeders/sql/provinces.sql'));
        DB::unprepared($sql);

        $sql = File::get(database_path('seeders/sql/districts.sql'));
        DB::unprepared($sql);

        $sql = File::get(database_path('seeders/sql/wards.sql'));
        DB::unprepared($sql);
    }
}
