<?php

namespace App\Repositories;
use App\Repositories\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface{

    public function register(array $data)
    {
        return User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    public function logout(){

        return Auth::logout();
    }
}

?>
