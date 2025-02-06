<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\RolePermissionRepositoryInterface;

class RolePermissionController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;
    protected $rolePermissionRepository;

    public function __construct(RolePermissionRepositoryInterface $rolePermissionRepository){
        $this->rolePermissionRepository = $rolePermissionRepository;
    }

    public function index()
    {
        $roles = $this->rolePermissionRepository->getAllRolesWithPermissions();
        $roles = $this->rolePermissionRepository->getAll();
        return view('RoleAndPermission.RoleHasPermission.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rolesAndPermission = $this->rolePermissionRepository->getAllRolesWithPermissions()->find($id);
        $allPermissions = $this->rolePermissionRepository->getAllPermissions();

        return view('RoleAndPermission.RoleHasPermission.edit', compact('rolesAndPermission', 'allPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role_name' => 'required|exists:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role =$this->rolePermissionRepository->getAllRolesWithPermissions()->where('name', $request->role_name)->firstOrFail();
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Permissions updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = $this->rolePermissionRepository->getAllRolesWithPermissions()->find($id);
        $permissions = $role->permissions->pluck('name')->toArray();
        $this->rolePermissionRepository->revokePermissionsFromRole($id, $permissions);

        return redirect()->route('role-permission.index')->with('success', 'All permissions revoked successfully.');
    }

    public function showAssignForm()
    {
        $roles = $this->rolePermissionRepository->getAllRoles();
        $permissions = $this->rolePermissionRepository->getAllPermissions();
        $users = User::all();

        return view('RoleAndPermission.RoleHasPermission.create', compact('roles', 'permissions', 'users'));
    }
}
