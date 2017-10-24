<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;


Route::get('/', function () {
    if (Auth('admin')->check()) {

        return redirect('/admin/home') ;
    }
    elseif (Auth::check()) {
        return redirect('/mydrive') ;
    }
    else{
        return view('auth.login');
    }
});

Auth::routes();

Route::get('mydrive', 'FileSystemController@index');

//ADMIN Routes
Route::get('/admin/home', 'AdminController@index');

Route::get('/{department}', 'DepartmentController@index');

Route::patch('/departments/{department}', 'DepartmentController@update');

Route::get('admin/login', 'Admin\LoginController@showLoginForm')->name('admin.login');

Route::post('admin/login', 'Admin\LoginController@login');

Route::get('/department/create', 'DepartmentController@create');

Route::post('/department', 'DepartmentController@store');

//Route::post('/department/{id}/edit', 'DepartmentController@update');

Route::post('/departmentHead', 'DepartmentController@set');

Route::post('/admin', 'AdminController@set');




//User Routes

Route::post('/editUser', 'UserController@update');

Route::post('/editMyProfile', 'UserController@userEdit');

Route::post('/resetPassword', 'UserController@reset');

Route::get('myDrive/search', 'FileSystemController@search');


Route::get('Drive/search', 'FileSystemController@search');

Route::get('departmentDrive/search', 'FileSystemController@searchDepartment');

Route::get('departmentsDrive/search', 'FileSystemController@searchDepartment');

Route::post('/reset', 'UserController@destroy');

Route::get('/user/profile', 'UserController@edit');


Route::post('/newfolder', 'FolderController@store');

Route::post('/rename', 'FolderController@update');

Route::post('/rename/folder', 'DepartmentFolderController@update');

Route::post('/newdepartmentfolder', 'DepartmentFolderController@store');

Route::get('/mydrive/{folder}', 'FolderController@index');

Route::get('/drive/{department}', 'DepartmentFolderController@index');

Route::get('/departmentdrive/{departmentFolder}', 'DepartmentFolderController@show');

Route::post('/upload', 'FileSystemController@store');

Route::post('/editFile', 'FileSystemController@editFile');

Route::post('/approved', 'FileSystemController@approved');

Route::post('/unapproved', 'FileSystemController@unapproved');

Route::delete('/files/{id}', 'FileSystemController@destroy');

Route::delete('/folder/{id}', 'DepartmentFolderController@destroy');

Route::post('/file/delete', 'FileSystemController@deleteShare');

Route::post('/moveFile', 'FileSystemController@moveToDepartment');

Route::post('/sharefiletodepartment', 'FileSystemController@shareToDepartment');

Route::post('/sharefiletouser', 'FileSystemController@shareToUser');

Route::get('/Drive/shared', 'FileSystemController@share');

Route::get('/download/{filename}', 'FileSystemController@download');

Route::get('/downloads/{filename}', 'FileSystemController@downloads');

Route::get('{filename}/download', 'FileSystemController@downloadShare');





