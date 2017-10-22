<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class FileSystem extends Model
{
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function shares(){
        return $this->belongsToMany(User::class);
    }
    public function isDepartment($file_id)
    {
       $file = FileSystem::all()->where('id',$file_id);


        foreach ($file as $item) {
            if ($item->isBoth == 1) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function isShare($file_id)
    {
        $file = FileSystemUser::all()->where('file_system_id',$file_id);

        if (count($file)>0) {
            return 1;
        } else {
            return 0;
        }

    }

     public function tagToArray($file)
     {
         $a = [];

         foreach ($file->tags as $tag)
         {
             $a[] = $tag->name;
         }
//         return (object)$a;
         return implode(",",$a);
     }
}
