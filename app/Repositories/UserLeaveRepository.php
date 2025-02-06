<?php

namespace App\Repositories;

use App\Models\UserRequest;
use App\Repositories\Contracts\BaseCrudRepository;
use App\Repositories\UserLeaveRepositoryInterface;

class UserLeaveRepository extends BaseCrudRepository implements UserLeaveRepositoryInterface
{
    public function __construct(UserRequest $model)
    {
        parent::__construct($model);
    }

    public function getFilteredLeaves(array $filters = [])
    {
        $query = UserRequest::with(['user', 'leaveType']);

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['leave_type'])) {
            $query->where('leave_type_id', $filters['leave_type']);
        }

        if (!empty($filters['roles'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('role', $filters['roles']);
            });
        }

        return $query->paginate(10);
    }
}

?>
