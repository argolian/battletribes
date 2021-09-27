<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleFormFields;
use App\Traits\RolesAndPermissionsHelpersTrait;
use App\Traits\RolesUsageAuthTrait;
use Illuminate\Http\Request;

class LaravelRolesController extends Controller
{
    use RolesAndPermissionsHelpersTrait;
    use RolesUsageAuthTrait;

    public function index()
    {
        $data = $this->getDashboardData();
        return view($data['view'], $data['data']);
    }

    public function create()
    {
        $service = new RoleFormFields();
        $data = $service->handle();
        return view('laravelroles.crud.roles.create', $data);
    }

    public function store(StoreRoleRequest $request)
    {
        $roleData = $request->roleFillData();
        $rolePermissions = $request->get('permissions');
        $role = $this->storeRoleWithPermissions($roleData, $rolePermissions);
        return redirect()->route('laravelroles::roles.index')
            ->with('success', trans('laravelroles.flash-messages.role-create'));
    }

    public function show($id)
    {
        $item = $this->getRole($id);
        return view('laravelroles.crud.roles.show', compact('item'));
    }

    public function edit(Request $request, $id)
    {
        $service = new RoleFormFields($id);
        $data = $service->handle();
        return view('laravelroles.crud.roles.edit', $data);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $roleData = $request->roleFillData();
        $rolePermissions = $request->get('permissions');
        $role = $this->updateRoleWithPermissions($id, $roleData, $rolePermissions);

        return redirect()->route('laravelroles::roles.index')
            ->with('success', trans('laravelroles.flash-messages.role-updated'));
    }

    public function destroy($id)
    {
        $role = $this->deleteRole($id);
        return redirect(route('laravelroles::roles.index'))
            ->with('success', trans('laravelroles.flash-messages.successDeletedItem'));
    }
}
