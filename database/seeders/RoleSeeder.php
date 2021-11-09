<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("permission_role")->delete();
        DB::table("role_user")->delete();
        DB::table("roles")->delete();
        Role::create([
            "name" => "admin",
            "display_name" => "Administrator",
        ]);

        Role::create([
            "name" => "creator",
            "display_name" => "Quote creators",
        ]);

        Role::create([
            "name" => "customer",
            "display_name" => "Customer",
        ]);
    }
}
