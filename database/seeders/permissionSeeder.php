<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Add_Role']);
        Permission::create(['name' => 'Edit_Role']);
        Permission::create(['name' => 'Delete_Role']);
        Permission::create(['name' => 'List_Role']);





        Permission::create(['name' => 'Assign_Permission']);
        $admin = User::first();
        $admin->givePermissionTo(Permission::all()); // Admin gets all permissions
    }


}
