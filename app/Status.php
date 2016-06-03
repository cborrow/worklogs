<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function jobs() {
        $this->hasMany(Job::class);
    }
}
