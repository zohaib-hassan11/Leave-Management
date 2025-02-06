<?php

namespace App\Repositories;

interface RoleRepositoryInterface
{
    public function createRole(string $name);
    public function assignRoleToUser(int $userId, string $roleName);
    public function syncRolesForUser(int $userId, string $roleName);
    public function getUserRoles(int $userId);
    public function removeRoleFromUser(int $userId, string $roleName);
    public function getAllRoles();
    public function getAllRolesWithPermissions();
}

?>
