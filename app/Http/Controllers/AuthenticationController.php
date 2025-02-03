<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Repositories\AuthRepository;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepositoryInterface;

class AuthenticationController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository){

        $this->authRepository = $authRepository;
    }

    public function showRegisterForm()
    {
        return view('Authentication.register');
    }

    public function showLoginForm()
    {
        return view('Authentication.login');
    }


    public function register(RegisterRequest $request){

        $this->authRepository->register($request->validated());

        return redirect()->route('dashboard')->with('success', 'User Register Successfully');
    }

    public function login(LoginRequest $request){

        if($this->authRepository->login($request->validated())){
            return redirect()->route('dashboard')->with('success', 'User Login Successfully');
        }

        return redirect()->back()->with('errors', 'Invalid credentials.');
    }

    public function logout(){
        $this->authRepository->logout();

        return redirect()->route('auth.login')->with('Logged out successfully.');
    }
}
