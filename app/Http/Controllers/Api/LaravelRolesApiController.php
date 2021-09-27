<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Traits\RolesAndPermissionsHelpersTrait;
use App\Traits\RolesUsageAuthTrait;

class LaravelRolesApiController extends Controller
{
    use RolesAndPermissionsHelpersTrait;

    public function index()
    {
        $data = $this->getDashboardData();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Success returning all roles and permissions data.',
            'data'      => $data['data'],
                                ], 200);
    }

    public function store(StoreRoleRequest $request)
    {
        $roleData = $request->roleFillData();
        $rolePermissions = $request->get('permissions');
        $role = $this->storeRoleWithPermissions($roleData, $rolePermissions);

        return response()->json([
                                    'code'      => 201,
                                    'status'    => 'created',
                                    'message'   => 'Success created new role.',
                                    'role'      => $role,
                                ], 201);
    }
}
