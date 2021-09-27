<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\RolesAndPermissionsHelpersTrait;
use App\Traits\RolesUsageAuthTrait;


class LaravelpermissionsDeletedController extends Controller
{
    use RolesUsageAuthTrait;
    use RolesAndPermissionsHelpersTrait;

    public function index()
    {
        $deletedPermissions = $this->getDeletedPermissions()->get();
        $data = [
            'deletedPermissions' => $deletedPermissions,
        ];

        return view('laravelroles.crud.permissions.deleted.index', $data);
    }

    public function show($id)
    {
        $item = $this->getDeletedPermissionAndDetails($id);
        $typeDeleted = 'deleted';

        return view('laravelroles.crud.permissions.show', compact('item', 'typeDeleted'));
    }

   public function restoreAllDeletedPermissions(Request $request)
    {
        $deletedPermissions = $this->restoreAllTheDeletedPermissions();

        if ($deletedPermissions['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                             ->with('success', trans_choice('laravelroles::laravelroles.flash-messages.successRestoredAllPermissions', $deletedPermissions['count'], ['count' => $deletedPermissions['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
                         ->with('error', trans('laravelroles.flash-messages.errorRestoringAllPermissions'));
    }

    public function restorePermission(Request $request, $id)
    {
        $permission = $this->restoreDeletedPermission($id);

        return redirect()->route('laravelroles::roles.index')
                         ->with('success', trans('laravelroles::laravelroles.flash-messages.successRestoredPermission', ['permission' => $permission->name]));
    }

   public function destroyAllDeletedPermissions(Request $request)
    {
        $deletedPermissions = $this->destroyAllTheDeletedPermissions();

        if ($deletedPermissions['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                             ->with('success', trans_choice('laravelroles.flash-messages.successDestroyedAllPermissions', $deletedPermissions['count'], ['count' => $deletedPermissions['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
                         ->with('error', trans('laravelroles::laravelroles.flash-messages.errorDestroyingAllPermissions'));
    }

  public function destroy($id)
    {
        $permission = $this->destroyPermission($id);

        return redirect()->route('laravelroles::roles.index')
                         ->with('success', trans('laravelroles.flash-messages.successDestroyedPermission', ['permission' => $permission->name]));
    }
}
