<?php

namespace App\Repositories;

interface UserRepositoryInterface{

    public function getFilteredUsers(array $filters = []);

}

?>
