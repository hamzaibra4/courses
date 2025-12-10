<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User();
        $user->name='Admin';
        $user->email="admin@course.com";
        $user->password=Hash::make('123');
        $role = UserType::where("key","A")->firstOrFail();
        $user->user_type_id = $role->id;
        $user->save();

        $user=new User();
        $user->name='Student';
        $user->email="student@course.com";
        $user->password=Hash::make('123');
        $role = UserType::where("key","S")->firstOrFail();
        $user->user_type_id = $role->id;
        $user->save();

    }
}
