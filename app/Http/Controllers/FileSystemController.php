<?php

namespace App\Http\Controllers;

use App\FileSystem;
use App\Folder;
use App\User;
use App\DepartmentFolder;
use App\Tag;
use App\FileSystemUser;
use Illuminate\Http\Request;
use Auth;
use Storage;
use Illuminate\Support\Facades\Input;


class FileSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('auth:ad');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()
            ->where('id','<>' , auth()->id());

        $folders = Folder::all()
            ->where('user_id' , auth()->id())
            ->where('parent_folder_id',0);

        $departmentFolders = DepartmentFolder::all()
            ->where('department_id' , Auth::user()->department->id);

        $files = FileSystem::all()
            ->where('user_id' , auth()->id())
            ->where('folder_id',0)
            ->where('isDepartmentFile',0);





        return view('FileSystem.index', [
            'folders' => $folders,
            'departmentFolders' => $departmentFolders,
            'parent_id' => 0,
            'parent' => 0,
            'users' => $users,
            'files' => $files
        ]) ;
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
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {


       
        
        $this->validate(request(),[
            'description' => 'required',
            'tags' => 'required',
            'files' => 'required|max:10000|is_mime'

        ]);


        $tag = request('tags');
        $id = [];

        for  ($i = 0; $i < sizeof($tag); $i++) {
            $t = Tag::all()->where('name',$tag[''.$i.'']);
            if (count($t) > 0){
                foreach (Tag::all()->where('name',$tag[''.$i.'']) as $item)
                {
                    $id[] = $item->id;
                }
            }else {
                $id[] = Tag::create([
                    'name' => $tag['' . $i . '']
                ])->id;
            }
        }
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->getClientOriginalName();
                $fn = time().$filename;
                $size = $file->getClientSize();
                $path = $file->storeAs('public/upload/' . Auth::user()->name, $fn);

                if ($size >= 1073741824) {
                    $fileSize = round($size / 1024 / 1024 / 1024,1) . 'GB';
                } elseif ($size >= 1048576) {
                    $fileSize = round($size / 1024 / 1024,1) . 'MB';
                } elseif($size >= 1024) {
                    $fileSize = round($size / 1024,1) . 'KB';
                } else {
                    $fileSize = $size . ' bytes';
                }

                FileSystem::create([
                    'user_id' => auth()->id(),
                    'folder_id' => request('parent_folder_id'),
                    'department_folder_id' => request('department_parent_folder_id'),
                    'description' => request('description'),
                    'isDepartmentFile' => request('isDepartmentFile'),
                    'department_id' => Auth::user()->department->id,
                    'name' => $filename,
                    'size' => $fileSize,
                    'path' => $path
                ])->tags()->sync($id,false);
            }
        }

        return ['message' => 'File Uploaded'];


    }


    public function approved(Request $request)
    {
        \DB::table('file_systems')
            ->where('id', request('file_id'))
            ->update(['isApproved' => 1]);
        return back()->with('flash', "File-Approved");
    }

    public function unapproved(Request $request)
    {
        \DB::table('file_systems')
            ->where('id', request('file_id'))
            ->update(['isApproved' => 0]);
        return back()->with('flash', "File-Unapproved");
    }


    public function shareToDepartment(Request $request)
    {
        \DB::table('file_systems')
            ->where('id', request('file_id'))
            ->update([
                'isBoth' => 1,
                'department_folder_id' => request('department_folder_id'),
            ]);
        return back()->with('flash', "File-Shared");
    }

    public function shareToUser(Request $request)
    {

        $files = FileSystem::all()->where('id',request('file_id'));
        foreach ($files as $file) {
            $file->shares()->sync(request('user_id'), false);
        }

        FileSystemUser::create([
            'user_id' => request('user_id'),
            'file_system_id' => request('file_id')
        ]);

        return back()->with('flash', "File-Shared");
    }



    public function moveToDepartment(Request $request)
    {
        \DB::table('file_systems')
            ->where('id', request('file_id'))
            ->update([
                'department_folder_id' => request('department_folder_id'),
            ]);
        return back()->with('flash', "File-Moved");
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function share()
    {
        $files = FileSystemUser::all()->where('user_id',Auth::user()->id);
        $x = [];
        foreach ($files as $file){
            $x[] = $file->file_system_id;
        }

        if(count($files)){

        $shareFiles = FileSystem::all()->where('id', $x['0']);
        }
        else
            {
                $shareFiles = FileSystem::all()->where('id', 0);
            }

            for ($i = 1; $i < sizeof($x); $i++)
            {
                $shareFiles = $shareFiles->merge(FileSystem::all()->where('id', $x['' . $i . '']));
            }



        return view('FileSystem.showShared', [
            'sharedFiles' => $shareFiles
        ]) ;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\FileSystem $fileSystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,FileSystem $fileSystem)
    {
        $file = FileSystem::all()->where('id',request('file_id'));
        foreach ($file as $item)
        {
            if($item->isBoth == 1){
                \DB::table('file_systems')
                    ->where('id',request('file_id'))
                    ->update([
                        'isBoth' => 0,
                        'isApproved' => 0,
                    ]);
            }
            else {
                Storage::delete($item->path);

                \DB::table('file_system_tag')->where('file_system_id',request('file_id'))->delete();
                \DB::table('file_systems')->where('id',request('file_id'))->delete();
            }
        }



       return back()->with('flash', "File-Deleted");
    }

    public function deleteShare(Request $request)
    {

        \DB::table('file_system_user')
            ->where('file_system_id',request('file_id'))
            ->where('user_id',Auth::user()->id)
            ->delete();

       \DB::table('file_system_users')
           ->where('file_system_id',request('file_id'))
           ->where('user_id',Auth::user()->id)
           ->delete();

        return back()->with('flash', "File-Removed");
    }

    public function search(Request $request)
    {

          $this->validate(request(),[
            'search' => 'fill'

        ]);

    
         $q = Input::get ( 'search' );
         $files = FileSystem::where('user_id',Auth::User()->id)
         ->where('isDepartmentFile',0)
         ->where('name','like','%'.$q.'%')->get();
        
        $des = FileSystem::where('user_id',Auth::User()->id)
         ->where('isDepartmentFile',0)->where('description','LIKE','%'.$q.'%')->get();
       
        $files = $files->merge($des);
        
        $tag = Tag::where('name','like','%'.$q.'%')->get();

        // foreach($tag as $t)
        // {
        //     foreach($t->filesystems as $a){
        // print($a);
        //     }
        // }
        // dd($tag);
        
        if(count($tag)){
            foreach($tag as $t)
            {
                foreach($t->filesystems as $a){
        
                    if( ($a->user_id == Auth::user()->id) and ($a->isDepartmentFile == 0) )
                    {
                       $b[] = $a;
                        $files = $files->merge($b);
                    }     
                }
            }
        }
  
        $departmentFolders = DepartmentFolder::all()
            ->where('department_id' , Auth::user()->department->id);

        $users = User::all()
            ->where('id','<>' , auth()->id());


        return view('Search.show',[
            'files' => $files,
            'search' => $q,
            'departmentFolders' => $departmentFolders,
            'users' => $users
        ]);
    }

      public function searchDepartment(Request $request)
    {

          $this->validate(request(),[
            'search' => 'fill'

        ]);

    
         $q = Input::get ( 'search' );
         $files = FileSystem::where('department_id',Auth::User()->department->id)
         ->where('isDepartmentFile',1)
         ->where('isApproved', 1)
         ->where('name','like','%'.$q.'%')->get();

         $desp = FileSystem::where('department_id',Auth::User()->department->id)
         ->where('isDepartmentFile',1)
         ->where('isApproved', 1)
         ->where('description','LIKE','%'.$q.'%')->get();

        $files = $files->merge($desp);


         $shareFile = FileSystem::where('department_id',Auth::User()->department->id)
         ->where('isBoth',1)
         ->where('isApproved', 1)
         ->where('name','like','%'.$q.'%')->get();

          $files = $files->merge($shareFile);

           $despp = FileSystem::where('department_id',Auth::User()->department->id)
         ->where('isBoth',1)
         ->where('isApproved', 1)
         ->where('description','LIKE','%'.$q.'%')->get();

         $files = $files->merge($despp);
        
       
        
        $tag = Tag::where('name','like','%'.$q.'%')->get();
        if(count($tag)){
            foreach($tag as $t)
            {
                foreach($t->filesystems as $a){
        
                    if( (($a->department_id === Auth::user()->department->id) and ($a->isDepartmentFile === 1) and ($a->isApproved == 1)) or (($a->department_id === Auth::user()->department->id) and ($a->isBoth === 1) and ($a->isApproved == 1)) )
                    {
                       $b[] = $a;
                        $files = $files->merge($b);
                    }     
                }
            }
        }  
  
        $departmentFolders = DepartmentFolder::all()
            ->where('department_id' , Auth::user()->department->id);

        $users = User::all()
            ->where('id','<>' , auth()->id());


        return view('Search.showDepartment',[
            'files' => $files,
            'search' => $q,
            'departmentFolders' => $departmentFolders,
            'users' => $users
        ]);
    }
}
