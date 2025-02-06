<?php

namespace App\Repositories;

interface PermissionRepositoryInterface
{
    public function createPermission(string $name);
    public function assignPermissionToRole(string $roleName, string $permissionName);
    public function getRolePermissions(string $roleName);
    public function removePermissionFromRole(string $roleName, string $permissionName);
    public function getAllPermissions($search = null, $perPage = 15);
}

?>
