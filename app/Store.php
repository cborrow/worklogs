<?php

namespace App;

use App\Job;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function jobs() {
        $this->hasMany(Job::class);
    }

    public static function getName($id) {
        $store = Store::find($id);

        if($store != null)
            return $store->name;
        return "Unknown store";
    }

    public function getOpenJobCount() {
        //$count = Job::where(['store_id' => $id])->select(['id'])->count();
        return Job::where(['store_id' => $this->id])->select(['id'])->count();
    }
}
