<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesDefault extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sql = File::get(database_path('seeders/sql/categories.sql'));
        DB::unprepared($sql);
    }
}
