<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public const DATA_USER = [
        [
            "name" => "superadmin",
            "password" => "admin",
            "email" => "superadmin@mail.com",
            "phone_number" => "+62895351172040",
            "phone_number_verified_at" => "2023-10-14",
            "email_verified_at" => "2023-10-14",
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::DATA_USER as $user) {
            User::create($user);
        }
    }
}
