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
}

?>
