<?php

namespace App\Http\Controllers;

use App\Traits\RolesAndPermissionsHelpersTrait;
use App\Traits\RolesUsageAuthTrait;
use Illuminate\Http\Request;

class LaravelRolesDeletedController extends Controller
{
    use RolesAndPermissionsHelpersTrait;
    use RolesUsageAuthTrait;

    public function index()
    {
        $deletedRoleItems = $this->getDeletedRoles()->get();
        $data = [
            'deletedRoleItems' => $deletedRoleItems,
        ];

        return view('laravelroles::laravelroles.crud.roles.deleted.index', $data);
    }

    public function show($id)
    {
        $item = $this->getDeletedRole($id);
        $typeDeleted = 'deleted';

        return view('laravelroles::laravelroles.crud.roles.show', compact('item', 'typeDeleted'));
    }

    public function restoreAllDeletedRoles(Request $request)
    {
        $deletedRoles = $this->restoreAllTheDeletedRoles();

        if ($deletedRoles['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                             ->with('success', trans_choice('laravelroles.flash-messages.successRestoredAllRoles', $deletedRoles['count'], ['count' => $deletedRoles['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
                         ->with('error', trans('laravelroles.flash-messages.errorRestoringAllRoles'));
    }

    public function restoreRole(Request $request, $id)
    {
        $role = $this->restoreDeletedRole($id);

        return redirect()->route('laravelroles::roles.index')
                         ->with('success', trans('laravelroles.flash-messages.successRestoredRole', ['role' => $role->name]));
    }

    public function destroyAllDeletedRoles(Request $request)
    {
        $deletedRoles = $this->destroyAllTheDeletedRoles();

        if ($deletedRoles['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                             ->with('success', trans_choice('laravelroles.flash-messages.successDestroyedAllRoles', $deletedRoles['count'], ['count' => $deletedRoles['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
                         ->with('error', trans('laravelroles.flash-messages.errorDestroyingAllRoles'));
    }

    public function destroy($id)
    {
        $role = $this->destroyRole($id);

        return redirect()->route('laravelroles::roles.index')
                         ->with('success', trans('laravelroles.flash-messages.successDestroyedRole', ['role' => $role->name]));
    }
}
