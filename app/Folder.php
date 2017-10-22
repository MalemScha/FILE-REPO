<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //
    protected $guarded = [];

    /**
     * @param $id
     * @return mixed
     */
    public function parent_folder($id)
    {
//        return $this->belongsTo(Folder::class,'folder_id');
        $location = [];
//        $i = 0;
        while ($id != 0){
            $folder = Folder::all()->where('id',$id)->first();
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
