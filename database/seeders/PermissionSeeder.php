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

        Permission::create(['name' => 'Add_Students_Type']);
        Permission::create(['name' => 'Edit_Students_Type']);
        Permission::create(['name' => 'Delete_Students_Type']);
        Permission::create(['name' => 'List_Students_Type']);

        Permission::create(['name' => 'Add_Students']);
        Permission::create(['name' => 'Edit_Students']);
        Permission::create(['name' => 'Delete_Students']);
        Permission::create(['name' => 'List_Students']);

        Permission::create(['name' => 'Add_Users']);
        Permission::create(['name' => 'Edit_Users']);
        Permission::create(['name' => 'Delete_Users']);
        Permission::create(['name' => 'List_Users']);
        Permission::create(['name' => 'ResetPassword_User']);

        Permission::create(['name' => 'Add_Custom_Field']);
        Permission::create(['name' => 'Edit_Custom_Field']);
        Permission::create(['name' => 'Delete_Custom_Field']);
        Permission::create(['name' => 'List_Custom_Field']);

        Permission::create(['name' => 'Add_Payments']);
        Permission::create(['name' => 'Edit_Payments']);
        Permission::create(['name' => 'Delete_Payments']);
        Permission::create(['name' => 'List_Payments']);

        Permission::create(['name' => 'Add_Courses_Status']);
        Permission::create(['name' => 'Edit_Courses_Status']);
        Permission::create(['name' => 'Delete_Courses_Status']);
        Permission::create(['name' => 'List_Courses_Status']);

        Permission::create(['name' => 'Add_Section']);
        Permission::create(['name' => 'Edit_Section']);
        Permission::create(['name' => 'Delete_Section']);
        Permission::create(['name' => 'List_Section']);

        Permission::create(['name' => 'Add_Chapter']);
        Permission::create(['name' => 'Edit_Chapter']);
        Permission::create(['name' => 'Delete_Chapter']);
        Permission::create(['name' => 'List_Chapter']);

        Permission::create(['name' => 'Add_Course']);
        Permission::create(['name' => 'Edit_Course']);
        Permission::create(['name' => 'Delete_Course']);
        Permission::create(['name' => 'List_Course']);

        Permission::create(['name' => 'Add_Section_Video']);
        Permission::create(['name' => 'Edit_Section_Video']);
        Permission::create(['name' => 'Delete_Section_Video']);
        Permission::create(['name' => 'List_Section_Video']);

        Permission::create(['name' => 'Add_Material']);
        Permission::create(['name' => 'Edit_Material']);
        Permission::create(['name' => 'Delete_Material']);
        Permission::create(['name' => 'List_Material']);

        Permission::create(['name' => 'Add_Watched_Video']);
        Permission::create(['name' => 'Edit_Watched_Video']);
        Permission::create(['name' => 'Delete_Watched_Video']);
        Permission::create(['name' => 'List_Watched_Video']);

        Permission::create(['name' => 'Add_Favorite_Video']);
        Permission::create(['name' => 'Edit_Favorite_Video']);
        Permission::create(['name' => 'Delete_Favorite_Video']);
        Permission::create(['name' => 'List_Favorite_Video']);

        Permission::create(['name' => 'Add_enRolled_Course']);
        Permission::create(['name' => 'Edit_enRolled_Course']);
        Permission::create(['name' => 'Delete_enRolled_Course']);
        Permission::create(['name' => 'List_enRolled_Course']);

        Permission::create(['name' => 'Edit_Company']);
        Permission::create(['name' => 'List_Company']);


        Permission::create(['name' => 'Assign_Permission']);
        $admin = User::first();
        $admin->givePermissionTo(Permission::all()); // Admin gets all permissions
    }


}
