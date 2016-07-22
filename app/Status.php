<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function jobs() {
        $this->hasMany(Job::class);
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
}
