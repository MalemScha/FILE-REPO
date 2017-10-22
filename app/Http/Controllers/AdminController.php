<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\User;
use App\Head;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $departments = Department::all();
        $heads = Head::all()
            ->where('active',1);
        $admins = $users->where('isAdmin',1);

        return view('Admin.home', [
            'users' => $users,
            'departments' => $departments,
            'heads' => $heads,
            'admins' => $admins
        ]) ;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required'
        ]);

        $admins = User::all()
            ->where('department_id', request('department_id'))
            ->where('isAdmin', 1);

        if (count($admins) > 0) {
            \DB::table('users')
                ->where('department_id', request('department_id'))
                ->where('isAdmin', 1)
                ->update(['isAdmin' => 0]);
        }

        $admin = User::all()
            ->where('department_id', request('department_id'))
            ->where('id', request('user_id'))
            ->where('isAdmin', 0);
        if (count($admin) > 0) {
            \DB::table('users')
                ->where('department_id', request('department_id'))
                ->where('id', request('user_id'))
                ->where('isAdmin', 0)
                ->update(['isAdmin' => 1]);
        }
        return back()->with('flash', "Department-Admin-Set");
    }
}
