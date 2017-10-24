<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\User;
use App\Head;

/**
 * Class DepartmentController
 * @package App\Http\Controllers
 */
class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Department $department
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        $users= User::all();
        $users = $users->where('department_id' , $department->id);
        $departments = Department::all();


        return view('Department.index', [
            'users' => $users,
            'dept_name' => $department->name,
            'departments' => $departments

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
        return view('Department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name' => 'required|unique:departments'
        ]);
        Department::create([
            'name' => request('name'),
            'slug' =>str_slug(request('name'),'-')
        ]);
        return redirect('admin/home')->with('flash',"New-Department-Added");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set(Request $request)
    {

        $this->validate($request,[
            'user_id' => 'required'
        ]);

        $department = Head::all()
            ->where('department_id',request('department_id'))
            ->where('active',1);

        if(count($department)>0) {
            \DB::table('heads')
                ->where('department_id',request('department_id'))
                ->where('active',1)
                ->update(['active' => 0]);
        }

        $head = Head::all()
            ->where('department_id',request('department_id'))
            ->where('user_id',request('user_id'))
            ->where('active',0);
        if(count($head)>0){
            \DB::table('heads')
                ->where('department_id',request('department_id'))
                ->where('user_id',request('user_id'))
                ->where('active',0)
                ->update(['active' => 1]);

        }
        else {
            Head::create([
                'department_id' => request('department_id'),
                'user_id' => request('user_id'),
                'active' => 1,
            ]);
        }



        return back()->with('flash',"Department-Head-Set");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //validate it
        $this->validate($request,[
            'name' => 'required|unique:departments'
        ]);

        //update the department
dd($department);

        $department->update([
            'name' => request('name'),
            'slug' =>str_slug(request('name'),'-')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
