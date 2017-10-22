@extends('Admin.partial.app')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 primary">


                    <div class="panel-heading">
                        <center><h2>{{ $dept_name }}</h2></center>
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    {{ $user->full_name }}
                                </td>


                                <td>
                                    <department_head inline-template  v-cloak>
                                        <div style="display: inline;">
                                            <button class="pull-right btn btn-xs btn-success"  @click="edit=true" title="Edit User">
                                                <i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            <div v-if="edit">
                                                <div class="modall is-active">
                                                    <div class="modall-background"></div>
                                                    <div class="modall-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                                                        </div>

                                                        <form class="form-horizontal" role="form" method="POST" action="{{ url("/editUser") }}">
                                                            {{ csrf_field() }}
                                                            <div class=" modal-body">

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

                                                                <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                                                                    <label for="department_id" class="col-md-4 control-label">Department:</label>
                                                                    <div class="col-md-6">
                                                                        <select name="department_id" id="department_id" class="form-control" required>
                                                                            <option value="">Choose....</option>
                                                                            @foreach($departments as $department)
                                                                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : ''}}>{{ $department->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @if ($errors->has('department_id'))
                                                                            <span class="help-block">
                                        <strong>{{ $errors->first('department_id') }}</strong>
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





                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                                <button type="submit" class="btn btn-danger">Edit</button>
                                                            </div>
                                                        </form>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </department_head>


                                     <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="pull-right btn btn-xs btn-danger mr-1"  @click="edit=true">
                                            <i class="fa fa-key" aria-hidden="true"></i></button>
                                        <div v-if="edit">
                                            <div class="modall is-active">
                                                <div class="modall-background"></div>
                                                <div class="modall-content">
                                                   
                                                        <form class="form-horizontal" role="form" method="POST" action="{{ url("/reset") }}">
                                                            {{ csrf_field() }}
                                                        <div class=" modal-body">


                                                                <input style="display: none;" type="text" name="id" value="{{ $user->id }}">


                                                        <center><h3>Reset Password....</h3></center>
                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reset</button>
                                                        </div>
                                                        </form>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </department_head>


                                </td>

                            </tr>


                    @empty
                    <p>NO USER IN THIS DEPARTMENT</p>
                @endforelse

                        </tbody>
                    </table>


            </div>
            @include('Admin.partial.sidebar')
            @include('Admin.addmodel')
        </div>
    </div>


@endsection
