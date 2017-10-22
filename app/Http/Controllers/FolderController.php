<?php

namespace App\Http\Controllers;

use App\Folder;
use App\User;
use Illuminate\Http\Request;
use App\FileSystem;
use Auth;
use App\DepartmentFolder;

/**
 * Class FolderController
 * @package App\Http\Controllers
 */
class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('auth:ad');
    }
    /**
     * Display a listing of the resource.
     *
     * @param Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function index(Folder $folder)
    {

        $users = User::all()
            ->where('id','<>' , auth()->id());


        $folders = Folder::all()
            ->where('user_id' , auth()->id())
            ->where('parent_folder_id',$folder->id);

        $departmentFolders = DepartmentFolder::all()
            ->where('department_id' , Auth::user()->department->id);

        $files = FileSystem::all()
            ->where('user_id' , auth()->id())
            ->where('folder_id',$folder->id)
            ->where('isDepartmentFile',0);


        return view('FileSystem.index', [
            'folders' => $folders,
            'parent_id' => $folder->id,
            'parent' => $folder,
            'departmentFolders' => $departmentFolders,
            'users' => $users,
            'files' => $files
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $this->validate($request,[
        'name' => 'required'
    ]);
    Folder::create([
        'name' => request('name'),
        'user_id' => auth()->id(),
        'parent_folder_id' => request('parent_folder_id')
    ]);
    return back()->with('flash',"New-Folder-Added");

}



    /**
     * Display the specified resource.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {

        $this->validate($request,[
            'name' => 'required'
        ]);

        \DB::table('folders')
            ->where('id', request('folder_id'))
            ->update([
                'name' => request('name'),
        ]);
        return back()->with('flash',"Folder-Renamed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        //
    }
}
