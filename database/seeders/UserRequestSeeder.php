<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Database\Seeder;
use App\Models\UserRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first();
        $leaveType = LeaveType::first();

        // Create a user request
        UserRequest::create([
            'user_id' => $user->id ?? 1,
            'leave_type_id' => $leaveType->id ?? 1,
            'start_date' => Carbon::now()->addDays(2),
            'end_date' => Carbon::now()->addDays(4),
            'reason' => 'Medical treatment',
            'status' => 'pending',
            'approved_by' => null,
        ]);

        UserRequest::create([
            'user_id' => $user->id ?? 1,
            'leave_type_id' => $leaveType->id ?? 3,
            'start_date' => Carbon::now()->addDays(5),
            'end_date' => Carbon::now()->addDays(7),
            'reason' => 'Family event',
            'status' => 'approved',
            'approved_by' => 1,
        ]);
    }
}
