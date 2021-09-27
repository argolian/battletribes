<?php

namespace App\Http\Controllers;

use App\Models\BlockedItem;
use Illuminate\Http\Request;

class LaravelBlockerDeletedController extends LaravelBlockerController
{
    public static function getDeletedBlockedItem($id)
    {
        $item = BlockedItem::onlyTrashed()->where('id', $id)->get();
        if (count($item) != 1) {
            return abort(redirect('blocker-deleted')
                             ->with('error', trans('laravelblocker::laravelblocker.errors.errorBlockerNotFound')));
        }

        return $item[0];
    }

    public function index()
    {
        if (config('laravelblocker.blockerPaginationEnabled')) {
            $blocked = BlockedItem::onlyTrashed()->paginate(config('laravelblocker.blockerPaginationPerPage'));
        } else {
            $blocked = BlockedItem::onlyTrashed()->get();
        }

        return view('laravelblocker::laravelblocker.deleted.index', compact('blocked'));
    }

    public function show($id)
    {
        $item = self::getDeletedBlockedItem($id);
        $typeDeleted = 'deleted';

        return view('laravelblocker::laravelblocker.show', compact('item', 'typeDeleted'));
    }

    public function restoreBlockedItem(Request $request, $id)
    {
        $item = self::getDeletedBlockedItem($id);
        $item->restore();

        return redirect('blocker')
            ->with('success', trans('laravelblocker::laravelblocker.messages.successRestoredItem'));
    }

   public function restoreAllBlockedItems(Request $request)
    {
        $items = BlockedItem::onlyTrashed()->get();
        foreach ($items as $item) {
            $item->restore();
        }

        return redirect('blocker')
            ->with('success', trans('laravelblocker::laravelblocker.messages.successRestoredAllItems'));
    }

    public function destroy($id)
    {
        $item = self::getDeletedBlockedItem($id);
        $item->forceDelete();

        return redirect('blocker-deleted')
            ->with('success', trans('laravelblocker::laravelblocker.messages.successDestroyedItem'));
    }

    public function destroyAllItems(Request $request)
    {
        $items = BlockedItem::onlyTrashed()->get();

        foreach ($items as $item) {
            $item->forceDelete();
        }

        return redirect('blocker')
            ->with('success', trans('laravelblocker::laravelblocker.messages.successDestroyedAllItems'));
    }

   public function search(SearchBlockerRequest $request)
    {
        $searchTerm = $request->validated()['blocked_search_box'];
        $results = BlockedItem::onlyTrashed()->where('id', 'like', $searchTerm.'%')->onlyTrashed()
                              ->orWhere('typeId', 'like', $searchTerm.'%')->onlyTrashed()
                              ->orWhere('value', 'like', $searchTerm.'%')->onlyTrashed()
                              ->orWhere('note', 'like', $searchTerm.'%')->onlyTrashed()
                              ->orWhere('userId', 'like', $searchTerm.'%')->onlyTrashed()
                              ->get();

        $results->map(function ($item) {
            $item['type'] = $item->blockedType->slug;

            return $item;
        });

        return response()->json([
                                    json_encode($results),
                                ], Response::HTTP_OK);
    }
}
