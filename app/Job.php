<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public static function getOpenJobs() {
        $jobs = Job::where('status_id', '>', '1')->get();
        return $jobs;
    }
    
    public static function getStatusName($status_id) {
        $status = Status::find($status_id);

        if($status != null)
            return $status->name;
        return 'Status not found';
    }

    public static function getStatusClass($status_id) {
        $name = self::getStatusName($status_id);
        $class = strtolower($name);
        $class = str_replace(' ', '-', $class);
        return $class;
    }

    public static function getStatusColor($status_id) {
        $status = Status::find($status_id);

        if($status != null)
            return $status->color;
        return "#fff";
    }

    public static function recentlyUpdated($count) {
        return Job::orderBy('updated_at')->take($count)->get();
    }

    public static function getTimeOpen($id) {
        $job = Job::find($id);
        $now = date_create();
        $created = date_create($job->created_at);
        $diff = date_diff($now, $created);

        return $diff->d . " days " . $diff->h . " hours " . $diff->i . " minutes";
    }

    public static function openJobCount() {
        $count = Job::where('status_id', '>', '1')->count();
        return $count;
    }
}
