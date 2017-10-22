<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $guarded = [];
//
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function department_name()
    {
        return $this->belongsTo(Head::class,'department_id');
    }

}
