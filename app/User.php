<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
    public function head()
    {
        return $this->belongsTo(Head::class,'user_id');
    }

    public function filesystems()
    {

        return $this->belongsToMany(FileSystem::class);
    }

//    public function work_for()
//    {
//        return $this->belongsTo(User::class,'user_id');
//    }
}
