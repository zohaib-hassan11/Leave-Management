<?php

// app/Repositories/PermissionRepository.php
namespace App\Repositories;

use Spatie\Permission\Models\Role;
use App\Repositories\Traits\GetTrait;
use Spatie\Permission\Models\Permission;
use App\Repositories\Contracts\BaseCrudRepository;

class PermissionRepository extends BaseCrudRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function createPermission(string $name)
    {
        return Permission::create(['name' => $name]);
    }

    public function assignPermissionToRole(string $roleName, string $permissionName)
    {
        $role = Role::findByName($roleName);
        $permission = Permission::findByName($permissionName);

        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }

        return $role;
    }

    public function getRolePermissions(string $roleName)
    {
        $role = Role::findByName($roleName);
        return $role ? $role->permissions : [];
    }

    public function removePermissionFromRole(string $roleName, string $permissionName)
    {
        $role = Role::findByName($roleName);
        $permission = Permission::findByName($permissionName);

        if ($role && $permission) {
            $role->revokePermissionTo($permission);
        }

        return $role;
    }

    public function getAllPermissions($search = null, $perPage = 15)
    {
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }
}

?>
