<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveType::create([
            'name' => 'Sick Leave',
            'allowed_days' => 12,
        ]);

        LeaveType::create([
            'name' => 'Annual Leave',
            'allowed_days' => 15,
        ]);

        LeaveType::create([
            'name' => 'Casual Leave',
            'allowed_days' => 8,
        ]);
    }
}
