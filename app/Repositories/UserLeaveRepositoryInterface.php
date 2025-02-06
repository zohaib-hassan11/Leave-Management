<?php

namespace App\Repositories;

interface UserLeaveRepositoryInterface{

    public function getFilteredLeaves(array $filters = []);
}

?>
