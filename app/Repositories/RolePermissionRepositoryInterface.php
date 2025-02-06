<?php

namespace App\Repositories;

interface RolePermissionRepositoryInterface
{
    public function getAllRolesWithPermissions();
    public function getAllRoles();
    public function getAllPermissions();
    public function assignPermissionsToRole($roleId, array $permissionIds);
    public function revokePermissionsFromRole($roleId, array $permissionIds);
    public function getUserPermissions($userId);

}
