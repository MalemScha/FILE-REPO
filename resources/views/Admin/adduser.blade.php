{{--ADD USER MODAL--}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add User</h4>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">User Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
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
                            <input id="full_name" type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required autofocus>
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
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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
                            <input id="designation" type="text" class="form-control" name="designation" value="{{ old('designation') }}" required>

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
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : ''}}>{{ $department->name }}</option>
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
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : ''}}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : ''}}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : ''}}>Other</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

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
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>

    </div>
</div>
{{--ADD USER MODAL END--}}