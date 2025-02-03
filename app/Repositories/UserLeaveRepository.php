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
}

?>
