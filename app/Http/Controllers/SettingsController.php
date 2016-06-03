<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Store;
use App\Status;
use App\Http\Requests;

class SettingsController extends Controller
{
    public function index() {
        $stores = Store::all();
        $statuses = Status::all();

        return view('settings.index', compact('stores', 'statuses'));
    }

    public function addstore(Request $request) {
        $store = new Store;
        $store->name = $request->name;
        $store->save();

        return back();
    }

    public function deletestore(Request $request, Store $store) {
        return back();
    }

    public function addstatus(Request $request) {
        $status = new Status;
        $status->name = $request->name;
        $status->color = "#9b59b6";
        $status->save();

        return back();
    }

    public function deletestatus(Request $request, Status $status) {
        return back();
    }
}
