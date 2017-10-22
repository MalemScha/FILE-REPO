<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentFolder extends Model
{
    protected $guarded = [];
    public function parent_folder($id)
    {
//        return $this->belongsTo(Folder::class,'folder_id');
        $location = [];
//        $i = 0;
        while ($id != 0){
            $folder = DepartmentFolder::all()->where('id',$id)->first();
            $id = $folder->parent_folder_id;
            $array = array();
            $array['id'] = $folder->id;
            $array['name'] = $folder->name;
            array_push($location,$array);
        }
        $location = array_reverse($location);

        return $location;
    }
}
