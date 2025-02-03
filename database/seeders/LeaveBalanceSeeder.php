<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $leaveTypes = LeaveType::all();

        foreach ($users as $user) {
            foreach ($leaveTypes as $leaveType) {
                LeaveBalance::create([
                    'user_id' => $user->id,
                    'leave_type_id' => $leaveType->id,
                    'remaining_days' => $leaveType->allowance_days ?? 30,
                ]);
            }
        }
    }
}
