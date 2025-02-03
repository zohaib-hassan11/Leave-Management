<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $table = 'leave_balance';

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function leaveType(){
        return $this->belongsTo(LeaveType::class);
    }
}
