<?php

namespace Database\Seeders;

use App\Enums\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Permission::values() as $key => $permission){
            \App\Models\Permission::create([
                "name" => $permission,
                "guard_name" => "jwt",
            ]);
        }
    }
}
