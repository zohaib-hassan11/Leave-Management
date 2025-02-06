<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $table = 'leave_balance';
    protected $fillable = ['user_id', 'leave_type_id', 'remaining_days'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function leaveType(){
        return $this->belongsTo(LeaveType::class);
    }
}
