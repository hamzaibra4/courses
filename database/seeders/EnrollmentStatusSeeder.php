<?php

namespace Database\Seeders;

use App\Models\RelatedCoursesStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $statuses = [
            [
                'name' => 'Pending',
                'key' => 'PE',
            ],
            [
                'name' => 'Partially Paid',
                'key' => 'PP',
            ],
            [
                'name' => 'Paid',
                'key' => 'PA',
            ],

        ];

        foreach ($statuses as $status) {
            $l = new RelatedCoursesStatus();
            $l->name = $status['name'];
            $l->key = $status['key'];
            $l->save();
        }

    }
}
