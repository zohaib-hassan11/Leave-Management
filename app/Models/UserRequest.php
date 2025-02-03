<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $table = 'user_request';
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function leaveType(){
        return $this->belongsTo(LeaveType::class);
    }
}
