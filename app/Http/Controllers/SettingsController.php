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

    public function setStatusColor(Request $request, Status $status) {
        if(isset($request->color)) {
            $status->color = $request->color;
            $status->save();
        }
        return $status->color;
    }

    public function setStatusName(Request $request, Status $status) {
        if(isset($request->name)) {
            $status->name = $request->name;
            $status->save();
        }
        return $status->name;
    }

    public function addStatusName(Request $request) {
        if(isset($request->name) && isset($request->color)) {
            $status = new Status;
            $status->name = $request->name;
            $status->color = $request->color;
            $status->save();

            return $status->id;
        }

        return 0;
    }
}
