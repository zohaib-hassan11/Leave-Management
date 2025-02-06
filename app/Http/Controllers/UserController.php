<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository , RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = $this->userRepository->getAll($search);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->create($request->validated());
        $this->roleRepository->assignRoleToUser($user->id, $request->role);

        return redirect()->back()->with('success', 'User created successfully');
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userRepository->findById($id);
        if(!$user){
            return redirect()->back()->with('errors', 'User not found.');
        }
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = $this->userRepository->update($id, $request->validated());

        if ($user) {
            $this->roleRepository->syncRolesForUser($user->id, $request->role);

            return redirect()->back()->with('success', 'User updated successfully.');
        }

        return redirect()->back()->with('errors', 'Failed to update user.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->userRepository->delete($id)){
            return redirect()->back()->with('success', 'User Deleted successfully');
        }
            return redirect()->back()->with('errors', 'User Not Found');

    }
}
