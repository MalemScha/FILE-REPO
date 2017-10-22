<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepartmentFolder;
use Illuminate\Http\Request;
use App\FileSystem;
use Auth;
Use Storage;


class DepartmentFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = DepartmentFolder::all()->where('department_id', Auth::user()->department->id)
            ->where('parent_folder_id', 0);

        $files = FileSystem::all()
            ->where('department_id', Auth::user()->department->id)
            ->where('isDepartmentFile', 1)
            ->where('department_folder_id', 0)
            ->where('isApproved', 1);

        $both = FileSystem::all()
            ->where('department_id', Auth::user()->department->id)
            ->where('isBoth', 1)
            ->where('department_folder_id', 0)
            ->where('isApproved', 1);

        $files = $files->merge($both);



        $unapprovedFiles = FileSystem::all()
            ->where('department_id', Auth::user()->department->id)
            ->where('isDepartmentFile', 1)
            ->where('isApproved', 0);

        $unapproved = FileSystem::all()
            ->where('department_id', Auth::user()->department->id)
            ->where('isBoth', 1)
            ->where('isApproved', 0);

        $unapprovedFiles =  $unapprovedFiles->merge( $unapproved);


        $myUnapprovedFiles = FileSystem::all()
            ->where('department_id' , Auth::user()->department->id)
            ->where('user_id' , Auth::user()->id)
            ->where('isDepartmentFile',1)
            ->where('isApproved',0);

        $myUnapproved = FileSystem::all()
            ->where('department_id' , Auth::user()->department->id)
            ->where('user_id' , Auth::user()->id)
            ->where('isBoth',1)
            ->where('isApproved',0);

        $myUnapprovedFiles = $myUnapprovedFiles->merge($myUnapproved);


        $departmentFolders = DepartmentFolder::all()
            ->where('department_id' , Auth::user()->department->id);

        return view('FileSystem.department_index',[
            'files' => $files,
            'folders' => $folders,
            'parent' => 0,
            'parent_id' => 0,
            'departmentFolders' => $departmentFolders,
            'unapprovedFiles' => $unapprovedFiles,
            'myUnapprovedFiles' => $myUnapprovedFiles
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
        DepartmentFolder::create([
            'department_id' => Auth::user()->department->id,
            'user_id' => auth()->id(),
            'parent_folder_id' => request('parent_folder_id'),
            'name' => request('name')
        ]);
        return back()->with('flash',"New-Folder-Added");


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DepartmentFolder  $departmentFolder
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentFolder $departmentFolder)
    {

        $folders = DepartmentFolder::all()->where('department_id' , Auth::user()->department->id)
            ->where('parent_folder_id',$departmentFolder->id);

        $files = FileSystem::all()
            ->where('department_id' , Auth::user()->department->id)
            ->where('isDepartmentFile',1)
            ->where('department_folder_id',$departmentFolder->id)
            ->where('isApproved',1);
        $both = FileSystem::all()
            ->where('department_id', Auth::user()->department->id)
            ->where('isBoth', 1)
            ->where('department_folder_id',$departmentFolder->id)
            ->where('isApproved', 1);

        $files = $files->merge($both);

        $unapprovedFiles = FileSystem::all()
            ->where('department_id' , Auth::user()->department->id)
            ->where('isDepartmentFile',1)
            ->where('isApproved',0);
        $unapproved = FileSystem::all()
            ->where('department_id', Auth::user()->department->id)
            ->where('isBoth', 1)
            ->where('isApproved', 0);

        $unapprovedFiles =  $unapprovedFiles->merge( $unapproved);


        $myUnapprovedFiles = FileSystem::all()
            ->where('department_id' , Auth::user()->department->id)
            ->where('user_id' , Auth::user()->id)
            ->where('isDepartmentFile',1)
            ->where('isApproved',0);
        $myUnapproved = FileSystem::all()
            ->where('department_id' , Auth::user()->department->id)
            ->where('user_id' , Auth::user()->id)
            ->where('isBoth',1)
            ->where('isApproved',0);

        $myUnapprovedFiles = $myUnapprovedFiles->merge($myUnapproved);


        $departmentFolders = DepartmentFolder::all()
            ->where('department_id' , Auth::user()->department->id);


        return view('FileSystem.department_index',[
            'files' => $files,
            'folders' => $folders,
            'unapprovedFiles' => $unapprovedFiles,
            'parent' => $departmentFolder,
            'departmentFolders' => $departmentFolders,
            'parent_id' => $departmentFolder->id,
            'myUnapprovedFiles' => $myUnapprovedFiles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DepartmentFolder  $departmentFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(DepartmentFolder $departmentFolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DepartmentFolder  $departmentFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentFolder $departmentFolder)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        \DB::table('department_folders')
            ->where('id', request('folder_id'))
            ->update([
                'name' => request('name'),
            ]);
        return back()->with('flash',"Folder-Renamed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DepartmentFolder  $departmentFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,DepartmentFolder $departmentFolder)
    {
    }
}
