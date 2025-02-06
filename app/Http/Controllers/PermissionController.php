<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepo;

    public function __construct(PermissionRepositoryInterface $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        $permissions = $this->permissionRepo->getAllPermissions();
        $permissions = $this->permissionRepo->getAll();

        return view('RoleAndPermission.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('RoleAndPermission.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|unique:permissions,name'
        ]);

        $permission = $this->permissionRepo->createPermission($request->permission_name);
        return redirect()->back()->with('success', 'Permission Save Successfully.');
    }

    public function show($id)
    {
        $permission = $this->permissionRepo->createPermission()->find($id);
        return response()->json($permission);
    }

    public function edit($id)
    {
        $permission = $this->permissionRepo->findById($id);
        return view('RoleAndPermission.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'permission_name' => 'required|unique:permissions,name,' . $id
        ]);

        $permission = $this->permissionRepo->update($id, ['name' => $request->permission_name]);

        if($permission){
            return redirect()->back()->with('success', 'Permission Update Successfully.');
        }
        return redirect()->back()->with('errors', 'Faild to Update Permission.');
    }

    public function destroy($id)
    {
        $permission = $this->permissionRepo->delete($id);
        // $permission->delete();
        return redirect()->back()->with('success','Permission deleted successfully');

    }

    public function assignPermissionsToRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|exists:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        foreach ($request->permissions as $permission) {
            $this->permissionRepo->assignPermissionToRole($request->role_name, $permission);
        }

        return back()->with('success', 'Permissions assigned successfully.');
    }
}

