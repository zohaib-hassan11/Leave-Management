<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\Contracts\BaseCrudRepository;
use App\Repositories\RolePermissionRepositoryInterface;

class RolePermissionRepository extends BaseCrudRepository implements RolePermissionRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getAllRolesWithPermissions()
    {
        return Role::with('permissions')->get();
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function assignPermissionsToRole($roleId, array $permissionIds)
    {
        $role = Role::findOrFail($roleId);
        return $role->syncPermissions($permissionIds);
    }

    public function revokePermissionsFromRole($roleId, array $permissionIds)
    {
        $role = Role::findOrFail($roleId);
        return $role->revokePermissionTo($permissionIds);
    }
    public function getUserPermissions($userId)
    {
        $user = User::with('roles.permissions')->find($userId);
        return $user ? $user->getAllPermissions() : collect();
    }
}
