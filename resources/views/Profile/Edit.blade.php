@extends('layouts.app')

@section('content')
<hr>


 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action={{ url("/resetPassword") }}>
                        {{ csrf_field() }}
                        <div class="modal-body">

                         <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" required>

                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                         <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Reset</button>
                        </div>
                        </form>
                </div>
            </div>
    </div>

<div >

</div>

@if (count($errors))
    <ul class="alert alert-danger alert-dismissible fade in" role=alert>
        @foreach($errors->all() as $error)
            <li>
                <button type=button class=close data-dismiss=alert aria-label=Close>
                    <span aria-hidden=true>&times;</span></button>
                <strong>ERROR!!!</strong>  {{$error}}
            </li>
        @endforeach
    </ul>
@endif
<div class="container">
    <div style="margin-left: 0;" class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading"><h1 style="margin-left: 10px; ">EDIT PROFILE
                
                 <button style="border-color:#3097D1;" title="Reset Password"  class="pull-right btn btn-primary" data-toggle="modal" data-target="#editModal">
                <i  class="fa fa-2x fa-key" aria-hidden="true"></i></button></h1>
                
                </div>
                <div class="panel-body">
                         <form class="form-horizontal" role="form" method="POST" action="{{ url("/editMyProfile") }}">
                                                            {{ csrf_field() }}

                                                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                    <label for="name" class="col-md-4 control-label">User Name</label>

                                                                    <div class="col-md-6">
                                                                    <input style="display:none;" name="id" value={{ $user->id }} type="text">
                                                                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
                                                                        @if ($errors->has('name'))
                                                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                                                    <label for="full_name" class="col-md-4 control-label">Full Name</label>

                                                                    <div class="col-md-6">
                                                                        <input id="full_name" type="text" class="form-control" name="full_name" value="{{ $user->full_name }}" required autofocus>
                                                                        @if ($errors->has('full_name'))
                                                                            <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                                                    <div class="col-md-6">
                                                                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                                                        @if ($errors->has('email'))
                                                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                   </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group{{ $errors->has('designation') ? ' has-error' : '' }}">
                                                                    <label for="designation" class="col-md-4 control-label">Designation</label>

                                                                    <div class="col-md-6">
                                                                        <input id="designation" type="text" class="form-control" name="designation" value="{{ $user->designation }}" required>

                                                                        @if ($errors->has('designation'))
                                                                           <span class="help-block">
                                        <strong>{{ $errors->first('designation') }}</strong>
                                    </span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                                                    <label for="gender" class="col-md-4 control-label">Gender:</label>
                                                                    <div class="col-md-6">
                                                                        <select name="gender" id="gender" class="form-control" required>
                                                                            <option value="">Choose....</option>
                                                                           <option value="Male" {{ $user->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                                                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                                                            <option value="Other" {{ $user->gender == 'Other' ? 'selected' : ''}}>Other</option>
                                                                        </select>
                                                                        @if ($errors->has('gender'))
                                                                            <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                      
           





                                                                                                        
                                                                <div class="form-group">
                                                                    <div class="col-md-6 col-md-offset-4">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                         
                                                        </form>




                                                         



                </div>
            </div>
        </div>
    </div>
</div>


@endsection