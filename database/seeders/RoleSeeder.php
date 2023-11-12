<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Role::values() as $key => $role){
            \App\Models\Role::create([
                "name" => $role,
                "guard_name" => "jwt",
                "is_mutable" => false,
            ]);
        }

        $roleAdmin = \App\Models\Role::findByName(Role::ADMIN->value);
        foreach (Permission::values() as $permission){
            $roleAdmin->givePermissionTo($permission);
        }
    }
}
