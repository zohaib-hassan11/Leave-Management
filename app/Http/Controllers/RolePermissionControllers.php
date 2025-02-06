<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\RolePermissionRepositoryInterface;

class RolePermissionController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;
    protected $rolePermissionInterface;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository, RolePermissionRepositoryInterface $rolePermissionInterface){
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(){
        $roles = $this->rolePermissionInterface->getAllRolesWithPermissions();
        dd($roles);
        return view('RoleAndPermission.RoleHasPermission.index',compact('roles'));
    }

}

