<?php

namespace Database\Seeders;

use App\Models\User;
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
            "profile" => [
                "address" => "Bandung",
                "gender" => "male",
                "avatar" => null,
                "birth_date" => "1999-02-16",
                "birth_place" => "bandung",
            ]
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::DATA_USER as $user) {
            $profile = null;
            if (isset($user["profile"])) {
                $profile = $user["profile"];
                unset($user["profile"]);
            }
            $user = User::create($user);

            if ($profile){
                $user->profile()->create($profile);
            }
        }


        User::factory()->count(100)->create();
    }
}
