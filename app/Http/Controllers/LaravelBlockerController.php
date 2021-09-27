<?php

namespace App\Http\Controllers;

use App\Models\BlockedItem;
use App\Models\BlockedType;
use Illuminate\Http\Request;

class LaravelBlockerController extends Controller
{
    private $_authEnabled, $_rolesEnabled, $_rolesMiddleware;

    public function __construct()
    {
        $this->_authEnabled = config('laravelblocker.authEnabled');
        $this->_rolesEnabled = config('laravelblocker.rolesEnabled');
        $this->_rolesMiddleware = config('laravelblocker.rolesMiddleware');

        if($this->_authEnabled) $this->middleware('auth');
        if($this->_rolesEnabled) $this->middleware($this->_rolesMiddleware);
    }

    public function index()
    {
        if(config('laravelblocker.blockerPaginationEnabled'))
        {
            $blocked = BlockedItem::paginate(config('laravelblocker.blockerPaginationPerPage'));
        } else {
            $blocked = BlockedItem::all();
        }

        $deletedBlockedItems = BlockedItem::onlyTrashed();

        return view('laravelblocker.index', compact('blocked', 'deletedBlockedItems'));
    }

    public function create()
    {
        $blockedTypes = BlockedType::all();
        $users = config('laravelblocker.defaultUserModel')::all();
        return view('laravelblocker.create', compact('blockedTypes', 'users'));
    }

    public function store(StoreBlockerRequest $request)
    {
        BlockedItem::create($request->blockedFillData());

        return redirect('blocker')
            ->with('success', trans('laravelblocker.messages.blocked-creation-success'));
    }

    public function edit($id)
    {
        $blockedTypes = BlockedType::all();
        $users = config('laravelblocker.defaultUserModel')::all();
        $item = BlockedItem::findOrFail($id);

        return view('laravelblocker.edit', compact('blockedTypes', 'users', 'item'));
    }

    public function update(UpdateBlockerRequest $request, $id)
    {
        $item = BlockedItem::findOrFail($id);
        $item->fill($request->blockedFillData());
        $item->save();

        return redirect()
            ->back()
            ->with('success', trans('laravelblocker.messages.update-success'));
    }

    public function destroy($id)
    {
        $blockedItem = BlockedItem::findOrFail($id);
        $blockedItem->delete();

        return redirect('blocker')
            ->with('success', trans('laravelblocker.messages.delete-success'));
    }

    public function search(SearchBlockerRequest $request)
    {
        $searchTerm = $request->validated()['blocked_search_box'];
        $results = BlockedItem::where('id', 'like', $searchTerm.'%')
                              ->orWhere('typeId', 'like', $searchTerm.'%')
                              ->orWhere('value', 'like', $searchTerm.'%')
                              ->orWhere('note', 'like', $searchTerm.'%')
                              ->orWhere('userId', 'like', $searchTerm.'%')
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
