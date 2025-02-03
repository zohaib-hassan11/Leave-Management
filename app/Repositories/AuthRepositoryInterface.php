<?php

namespace App\Repositories;
use App\Repositories\AuthRepository;

interface AuthRepositoryInterface{

    public function register(array $data);
    public function login(array $credentials);
    public function logout();
}

?>
