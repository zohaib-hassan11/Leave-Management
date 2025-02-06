<?php

namespace App\Repositories;

use App\Models\LeaveBalance;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\Contracts\BaseCrudRepository;

class LeaveBalanceRepository extends BaseCrudRepository implements LeaveBalanceRepositoryInterface
{
    public function __construct(LeaveBalance $model)
    {
        parent::__construct($model);
    }

    public function getFilteredLeavesBalance($id)
    {
        $query = LeaveBalance::with(['user', 'leaveType']);

        if (!empty($id)) {
            $query->where('user_id', $id);
        }

        return $query->paginate(5);
    }
}

?>
