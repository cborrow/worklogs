<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function jobs() {
        $this->hasMany(Job::class);
    }

    public static function openJobCount($id) {
        $count = Job::where('status_id', $id)->count();
        return $count;
    }

    public static function getColor($id) {
        $status = Status::find($id);

        if($status != null)
            return $status->color;
        return "#fff";
    }

    public static function getName($id) {
        $status = Status::find($id);

        if($status != null)
            return $status->name;
        return "Unknown status";
    }

    public static function getHtmlClass($id) {
        $status = Status::find($id);

        if($status != null) {
            $name = $status->name;
            $name = strtolower($name);
            $name = str_replace(' ', '-', $name);
            $name = str_replace(array(',', '.', '"', '\''), '', $name);
            return $name;
        }
        return "normal-status";
    }
}
