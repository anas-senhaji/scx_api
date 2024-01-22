<?php

namespace App\Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Role\Models\Role;
use App\Http\Controllers\Controller;
use App\Modules\Role\Services\RoleService;
use App\Modules\Role\Http\Requests\RoleRequest;

class RoleController extends Controller
{

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function create(RoleRequest $request){
        return $this->roleService->create($request);
    }

    public function update(Role $role, RoleRequest $request){
        return $this->roleService->create($request, $role);
    }

    public function delete(Role $role){
        return $this->roleService->delete($role);
    }

    public function getOne(Role $role){
        return $this->roleService->getOne($role);
    }
    
    public function getAll(){
        return $this->roleService->getAll();
    }
}
