<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\BaseCrudRepository;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends BaseCrudRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getFilteredUsers(array $filters = [])
    {
        $query = User::with(['leaveRequest', 'leaveBalance']);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['roles'])) {
            $query->where('role', $filters['roles']);
        }

        return $query->paginate(10);
    }

}

?>
