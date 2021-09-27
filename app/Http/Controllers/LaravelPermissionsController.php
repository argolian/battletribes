<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionFormFields;
use App\Traits\RolesAndPermissionsHelpersTrait;
use App\Traits\RolesUsageAuthTrait;

class LaravelPermissionsController extends Controller
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
        $service = new PermissionFormFields();
        $data = $service->handle();

        return view('laravelroles.crud.permissions.create', $data);
    }

    public function store(StorePermissionRequest $request)
    {
        $permissionData = $request->permissionFillData();
        $permission = $this->storeNewPermission($permissionData);

        return redirect()->route('laravelroles::roles.index')
                         ->with('success', trans('laravelroles::laravelroles.flash-messages.permission-create', ['permission' => $permission->name]));
    }

    public function show($id)
    {
        $data = $this->getPermissionItemData($id);

        return view('laravelroles::laravelroles.crud.permissions.show', $data);
    }

    public function edit(Request $request, $id)
    {
        $service = new PermissionFormFields($id);
        $data = $service->handle();

        return view('laravelroles::laravelroles.crud.permissions.edit', $data);
    }

   public function update(UpdatePermissionRequest $request, $id)
    {
        $permissionData = $request->permissionFillData($id);
        $permission = $this->updatePermission($id, $permissionData);

        return redirect()->route('laravelroles::roles.index')
                         ->with('success', trans('laravelroles::laravelroles.flash-messages.permission-updated', ['permission' => $permission->name]));
    }

    public function destroy($id)
    {
        $permission = $this->deletePermission($id);

        return redirect(route('laravelroles::roles.index'))
            ->with('success', trans('laravelroles::laravelroles.flash-messages.successDeletedItem', ['type' => 'Permission', 'item' => $permission->name]));
    }
}
