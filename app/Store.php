<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function jobs() {
        $this->hasMany(Job::class);
    }
}
