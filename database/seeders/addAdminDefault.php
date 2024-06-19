<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class addAdminDefault extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sql = File::get(database_path('seeders/sql/users.sql'));
        DB::unprepared($sql);
    }
}
