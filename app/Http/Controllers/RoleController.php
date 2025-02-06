<?php


namespace App\Http\Controllers;

use App\Repositories\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        $roles = $this->roleRepo->getAllRoles();
        $roles = $this->roleRepo->getAll();
        return view('RoleAndPermission.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('RoleAndPermission.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name'
        ]);

        $role = $this->roleRepo->createRole($request->role_name);
        return redirect()->back()->with('success', 'Role Save Successfully.');
    }

    public function show($id)
    {
        $role = $this->roleRepo->getAllRoles()->find($id);
        return response()->json($role);
    }

    public function edit($id)
    {
        $role = $this->roleRepo->findById($id);
        return view('RoleAndPermission.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name'
        ]);

        $role = $this->roleRepo->update($id, ['name' => $request->role_name]);

        if($role){
            return redirect()->back()->with('success', 'Role Update Successfully.');
        }
        return redirect()->back()->with('errors', 'Faild to Update Role.');
    }

    public function destroy($id)
    {
        $role = $this->roleRepo->delete($id);
        return redirect()->back()->with('success','Role deleted successfully');
    }
}

