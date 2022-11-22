<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => "user", 'email' => 'user@test.com', 'password' => '1234', 'role_id' => null],
            ['name' => "admin", 'email' => 'admin@test.com', 'password' => '1234', 'role_id' => Role::where('name', 'ROLE_ADMIN')->first()->id],
            ['name' => "super_admin", 'email' => 'super-admin@test.com', 'password' => '1234', 'role_id' => Role::where('name', 'ROLE_SUPER_ADMIN')->first()->id]
        ]);
    }
}
