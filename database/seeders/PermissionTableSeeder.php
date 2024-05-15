<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $permissions = [
            ['name' => 'role-list','guard_name'=>'web'],
            ['name' => 'role-create','guard_name'=>'web'],
            ['name' => 'role-edit','guard_name'=>'web'],
            ['name' => 'role-show','guard_name'=>'web'],
            ['name' => 'role-delete','guard_name'=>'web'],
            ['name' => 'user-list','guard_name'=>'web'],
            ['name' => 'user-create','guard_name'=>'web'],
            ['name' => 'user-edit','guard_name'=>'web'],
            ['name' => 'user-delete','guard_name'=>'web'],
        ];
        Permission::upsert($permissions, 'name');
       
    }
}
