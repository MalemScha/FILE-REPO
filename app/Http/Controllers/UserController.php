<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('Profile.Edit',[
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user = User::all()->where('id',request('id'))->first();
        if ($user->name != request('name') and $user->email != request('email') )
        {

        $this->validate(request(),[
            
        'name' => 'required|max:255|unique:users',
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'designation' => 'required|max:255',
            'department_id' => 'required|exists:departments,id',
            'gender' => 'required',

        ]);

        \DB::table('users')
        ->where('id',request('id'))
        ->update([
                'name' => request('name'),
            'full_name' => request('full_name'),
            'email' => request('email'),
            'designation' => request('designation'),
            'department_id' => request('department_id'),
            'gender' => request('gender')
        ]);
        }
        else if ($user->name === request('name') and $user->email != request('email') )
        {
             $this->validate(request(),[
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'designation' => 'required|max:255',
            'department_id' => 'required|exists:departments,id',
            'gender' => 'required',
        ]);

        \DB::table('users')
        ->where('id',request('id'))
        ->update([
            'full_name' => request('full_name'),
            'email' => request('email'),
            'designation' => request('designation'),
            'department_id' => request('department_id'),
            'gender' => request('gender')
        ]);
        }
        else if (($user->name != request('name')) and ($user->email === request('email') ))
        {
            $this->validate(request(),[
                'full_name' => 'required|max:255',
                'name' => 'required|max:255|unique:users',
                'department_id' => 'required|exists:departments,id',
                'designation' => 'required|max:255',
                'gender' => 'required',

            ]);

            \DB::table('users')
                ->where('id',request('id'))
                ->update([
                    'full_name' => request('full_name'),
                    'name' => request('name'),
                    'designation' => request('designation'),
                    'department_id' => request('department_id'),
                    'gender' => request('gender')
                ]);
        }
        else{
              $this->validate(request(),[
            'full_name' => 'required|max:255',
            'designation' => 'required|max:255',
            'department_id' => 'required|exists:departments,id',
            'gender' => 'required',

        ]);

        \DB::table('users')
        ->where('id',request('id'))
        ->update([
            'full_name' => request('full_name'),        
            'designation' => request('designation'),
            'department_id' => request('department_id'),
            'gender' => request('gender')
        ]);

        }
 
    
    
    return back()->with('flash', "User-Edited");


    }

    public function userEdit(Request $request)
    {
        $user = User::all()->where('id',request('id'))->first();
        if ($user->name != request('name') and $user->email != request('email') )
        {

            $this->validate(request(),[

                'name' => 'required|max:255|unique:users',
                'full_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'designation' => 'required|max:255',
                'gender' => 'required',

            ]);

            \DB::table('users')
                ->where('id',request('id'))
                ->update([
                    'name' => request('name'),
                    'full_name' => request('full_name'),
                    'email' => request('email'),
                    'designation' => request('designation'),
                    'gender' => request('gender')
                ]);
        }
        else if ($user->name === request('name') and $user->email != request('email') )
        {
            $this->validate(request(),[
                'full_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'designation' => 'required|max:255',
                'gender' => 'required',
            ]);

            \DB::table('users')
                ->where('id',request('id'))
                ->update([
                    'full_name' => request('full_name'),
                    'email' => request('email'),
                    'designation' => request('designation'),
                    'gender' => request('gender')
                ]);
        }
        else if (($user->name != request('name')) and ($user->email === request('email') ))
        {
            $this->validate(request(),[
                'full_name' => 'required|max:255',
                'name' => 'required|max:255|unique:users',
                'designation' => 'required|max:255',
                'gender' => 'required',

            ]);

            \DB::table('users')
                ->where('id',request('id'))
                ->update([
                    'full_name' => request('full_name'),
                    'name' => request('name'),
                    'designation' => request('designation'),
                    'gender' => request('gender')
                ]);
        }
        else{
            $this->validate(request(),[
                'full_name' => 'required|max:255',
                'designation' => 'required|max:255',
                'gender' => 'required',

            ]);

            \DB::table('users')
                ->where('id',request('id'))
                ->update([
                    'full_name' => request('full_name'),
                    'designation' => request('designation'),
                    'gender' => request('gender')
                ]);

        }
        return back()->with('flash', "User-Edited");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request)
    {
        
        \DB::table('users')
        ->where('id',request('id'))
        ->update([
                'password' => bcrypt('password'),
        ]);
        
        return back()->with('flash', "Password-Reset");

        
    }

    public function reset(Request $request)
    {

        $this->validate(request(),[
            'old_password' => 'required|match',
            'password' => 'required|max:255|confirmed',
            ]);

        \DB::table('users')
            ->where('id',Auth::user()->id)
            ->update([
                'password' => bcrypt(request('password')),
            ]);

        return back()->with('flash', "Password-Reset");
    }
}
