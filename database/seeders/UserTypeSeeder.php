<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role=new UserType();
        $role->name='Admin';
        $role->key="A";
        $role->save();

        $role2=new UserType();
        $role2->name='Student';
        $role2->key="S";
        $role2->save();
    }
}
