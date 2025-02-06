<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Repositories\Contracts\BaseCrudRepository;

class RoleRepository extends BaseCrudRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function createRole(string $name)
    {
        return Role::create(['name' => $name]);
    }

    public function assignRoleToUser(int $userId, string $roleName)
    {
        $user = User::find($userId);
        if ($user) {
            $user->assignRole($roleName);
        }
        return $user;
    }

    public function getUserRoles(int $userId)
    {
        $user = User::find($userId);
        return $user ? $user->getRoleNames() : [];
    }

    public function removeRoleFromUser(int $userId, string $roleName)
    {
        $user = User::find($userId);
        if ($user) {
            $user->removeRole($roleName);
        }
        return $user;
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function syncRolesForUser(int $userId, string $roleName)
    {
        $user = User::find($userId);
        if ($user) {
            $user->syncRoles([$roleName]);
        }
        return $user;
    }

    public function getAllRolesWithPermissions()
    {
        return Role::with('permissions')->get();
    }
}


?>
