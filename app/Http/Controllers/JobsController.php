<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Job;
use App\Http\Requests;

class JobsController extends Controller
{
    public function index() {
        $jobs = Job::all();
        return view('notes.index', compact('jobs'));
    }

    public function add() {
        return view('notes.add');
    }

    public function edit(Job $job) {
        return view('notes.edit', compact('job'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'workorder' => 'required',
            'customer' => 'required',
            'notes' => 'required'
        ]);

        $job = new Job;
        $job->status_id = 1;
        $job->store_id = 1;
        $job->user_id = 1;
        $job->workorder = $request->workorder;
        $job->customer = $request->customer;
        $job->phone = (isset($request->phone)) ? $request->phone : 'No number given';
        $job->device = $request->device;
        $job->password = $request->password;
        $job->has_power_adapter = ($request->power_adapter == 'on') ? 1 : 0;
        $job->has_carrying_case = ($request->carrying_case == 'on') ? 1 : 0;
        $job->notes = $request->notes;
        $job->save();

        return back();
    }

    public function update(Request $request, Job $job) {
        $this->validate($request, [
            'workorder' => 'required',
            'customer' => 'required',
            'notes' => 'required'
        ]);

        $job->workorder = $request->workorder;
        $job->customer = $request->customer;
        $job->phone = $request->phone;
        $job->device = $request->device;
        $job->password = $request->password;
        $job->has_power_adapter = ($request->power_adapter == 'on') ? 1 : 0;
        $job->has_carrying_case = ($request->carrying_case == 'on') ? 1 : 0;
        $job->notes = $request->notes;
        $job->save();

        return back();
    }
}
