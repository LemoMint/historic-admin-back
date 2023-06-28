<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('roles')->insert([
            ['name' => "ROLE_ADMIN", 'lable' => "Администратор", 'description' => 'В ваши полномочия входит управление различного рода содержимым продукта: статьями, категориями документов, печатными изданиями и авторами изданий.'],
            ['name' => "ROLE_SUPER_ADMIN", 'lable' => "Главный администратор", 'description' => 'Максимальные полномочия в системе: управление пользователями, статьями, категориями документов, печатными изданиями и авторами изданий.'],
        ]);
    }
}
