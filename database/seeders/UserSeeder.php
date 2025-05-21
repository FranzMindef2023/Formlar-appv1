<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            "ci" => "12013",
            "grado" => "lic",
            "nombres" => "Marco Antonio",
            "appaterno" => "Justiniano",
            "apmaterno" => "Salazar",
            "email" => "juan@example.com",
            "celular" => 69409792,
            "usuario" => "nukkua",
            "password" => bcrypt("password123"),
            "status" => true,
        ];

        DB::table("users")->insert($user);
    }
}
