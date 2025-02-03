<?php

namespace App\Models;

use App\Models\UserRequest;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    public function leaveRequest(){
        return $this->hasMany(UserRequest::class);
    }

    public function leaveBalance(){
        return $this->hasMany(LeaveBalance::class);
    }
}
