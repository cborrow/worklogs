<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Job;
use App\Status;
use App\Store;
use App\Http\Requests;

class JobsController extends Controller
{
    public function index() {
        $count = Job::where('status_id', '>', '1')->count();

        $jobsPerPage = 15;
        $totalPages = 0;
        $page = 0;

        if($count > $jobsPerPage) {
            $page = 1;
            $totalPages = ceil(($count / $jobsPerPage));
            $jobs = Job::where('status_id', '>', '1')
				    ->orderBy('status_id')->orderBy('id', 'desc')
                    ->skip((($page - 1) * $jobsPerPage))->take($jobsPerPage)->get();
        }
        else
            $jobs = Job::where('status_id', '>', '1')->orderBy('status_id')->orderBy('id', 'desc')->get();
        return view('notes.index', compact('jobs', 'page', 'totalPages'));
    }

    public function add() {
        return view('notes.add');
    }

    public function edit(Job $job) {
        return view('notes.edit', compact('job'));
    }

    public function dashboard() {
        $jobs = Job::all();
        $stores = Store::all();
        return view('notes.dashboard', compact('jobs', 'stores'));
    }

    public function jobsByStatus(Status $status, $page = 0) {
        $count = Job::count();
        $jobsPerPage = 15;
        $totalPages = 0;

        if($count > $jobsPerPage) {
            $jobs = Job::where('status_id', $status->id)->skip($page - 1)->take($jobsPerPage)->get();
        }
        else
            $jobs = Job::where('status_id', $status->id)->get();
        $statuses = Status::all();

        return view('notes.status',
               compact('jobsPerPage', 'totalPages', 'page', 'jobs', 'status', 'statuses'));
    }

    public function jobsByPage($page) {
        $jobsPerPage = 15;
        $jobs = Job::skip((($page - 1) * $jobsPerPage))->take($jobsPerPage)->get();
        $statuses = Status::all();

        $count = Job::count();
        $totalPages = ceil(($count / $jobsPerPage));

        return view('notes.index', compact('jobs', 'page', 'totalPages', 'statuses'));
    }

    public function search(Request $request) {
		$query = $request->input('query');
		$options = [];
		
		/*if(preg_match("(wo:([0-9]+))", $query, $match)) {
			if(count($match) >= 2)
				$options['workorder'] = $match[1];
			$query = str_replace($match[0], "", $query);
		}
		if(preg_match("(after:([\\/0-9]+))", $query, $match)) {
			try {
				if(count($match) >= 2) {
					$date = strtotime($match[1]);
					$formattedDate = date("Y-d-m-H:i:s", $date);
					$options['after'] = $formattedDate;
				}
			}
			catch(Exception $ex) {
				
			}
			$query = str_replace($match[0], "", $query);
		}*/
		
		$jobs = null;
		
		if(strlen($query) > 2) {
            $jobs = Job::where('customer', 'like', '%' . $query . '%')
                    ->orWhere('customer', 'lile', '%' . strtolower($query) . '%')
                    ->orWhere('notes', 'like', '%' . $query . '%')
                    ->orWhere('notes', 'like', '%' . strtolower($query) . '%');
		}
		
		/*if(count($options) > 0) {
			foreach($options as $key => $value) {
				if($key == 'after')
					$jobs->andWhere('created_at', '>', $value);
				else if($key == 'wo')
					$jobs->andWhere('workorder', '=', $value);
			}
		}*/
		
		$jobs = $jobs->get();
				
        return view('search.index', compact('jobs'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'workorder' => 'required',
            'customer' => 'required',
            'notes' => 'required'
        ]);

        $job = new Job;
        $job->status_id = $request->status;
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

        return redirect('/');
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
        $job->status_id = $request->status;
        $job->device = $request->device;
        $job->password = $request->password;
        $job->has_power_adapter = ($request->power_adapter == 'on') ? 1 : 0;
        $job->has_carrying_case = ($request->carrying_case == 'on') ? 1 : 0;
        $job->notes = $request->notes;
        $job->save();

        return back();
    }

    public function purge(Request $request, Job $job) {
        if($request->reallydelete == 'yes') {
            $job->delete();
        }
    }
	
	public function jobsByCustomer($name) {
		$customer = str_replace('_', ' ', $name);
		$jobs = Job::getJobsByCustomer($customer);
		
		return view('notes.customer', compact('jobs', 'customer'));
	}

    /*API functions for jobs*/

    public function getJobStatus(Request $request, Job $job) {
        $status = Job::getStatusName($job->status_id);
        return $status;
    }

    public function getStatusList(Request $request) {
        $list = Status::all();
        return json_encode($list);
    }

    public function setJobStatus(Request $request, Job $job) {
        $val = $request->value;

        if(is_numeric($val)) {
            $job->status_id = $val;
            $job->save();
        }
    }

    public function apiGetStatus(Request $request, Job $job) {
        $status = $this->getJobStatus($request, $job);
        echo $status;
    }

    public function closeJob(Request $request, Job $job) {
        $job->status_id = 1;
        $job->save();
    }
}
