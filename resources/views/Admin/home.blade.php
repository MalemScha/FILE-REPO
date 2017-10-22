@extends('Admin.partial.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 primary">
                @forelse($departments as $department)
                    <department inline-template :department="{{ $department }}" v-cloak>

                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading">
                                <span v-if="editing">
                                    <span class="form-group">


				<span class="input input--hoshi mr-1">
					<input class="input__field input__field--hoshi" v-model="name" type="text" id="input-6" />
					<label class="input__label input__label--hoshi input__label--hoshi-color-3 " for="input-6">

					</label>
				</span>
                                 </span>
                                 <button class="btn btn-xs btn-toolbar" @click="cancel">Cancel</button>
                                 <button class="btn btn-xs btn-info" @click="update">Update</button>
                                </span>
                                <span v-else v-text="name">

                                </span>
                                <button class="btn btn-xs btn-success  pull-right" @click = " editing = true"> <i class="fa fa-pencil" aria-hidden="true" >
                                    </i></button>
                            </div>
                            <div class="panel-body">
                                <department_head inline-template  v-cloak>
                                    <div class="well">


                                        <div v-if="edit">
                                            <form class="form-horizontal" role="form" method="POST" action="{{url("/departmentHead")}}">
                                                {{ csrf_field() }}
                                                <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                                                    <label for="department_id" class="col-md-2 control-label">Pick User:</label>
                                                    <div class="col-md-6">
                                                        <input style="display: none;" type="text" name="department_id" value="{{ $department->id }}">
                                                        <select name="user_id" id="department_id" class="form-control" required>
                                                            <option value="">Choose....</option>
                                                            @foreach($users->where('department_id' , $department->id) as $item)
                                                                <option value="{{ $item->id }}" {{ old('department_id') == $item->id  ? 'selected' : ''}}>{{$item->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('department_id'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('department_id') }}</strong>
                                                            </span>
                                                        @endif
                                                        <div style="margin: 10px 0 0 6px; ">
                                                            <button class="btn btn-xs btn-toolbar" @click="edit = false">Cancel</button>
                                                            <button class="btn btn-xs btn-info" type="submit">Set</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <span v-else>
                                            <span class="mr-1">Department Head:</span>
                                            @foreach($heads->where('department_id' , $department->id) as $head)
                                                <strong style="font-size: 25px;"> {{ $head->user->full_name }}</strong> since {{ $head->updated_at->diffForHumans() }}
                                            @endforeach
                                           <button class="btn btn-xs btn-success  pull-right" @click = "edit = true"><i class="fa fa-pencil" aria-hidden="true" ></i></button>
                                    </span>


                                    </div>
                                </department_head>
                                <department_head inline-template  v-cloak>
                                    <div class="well">


                                        <div v-if="edit">
                                            <form class="form-horizontal" role="form" method="POST" action="{{url("/admin")}}">
                                                {{ csrf_field() }}
                                                <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                                                    <label for="department_id" class="col-md-2 control-label">Pick User:</label>
                                                    <div class="col-md-6">
                                                        <input style="display: none;" type="text" name="department_id" value="{{ $department->id }}">
                                                        <select name="user_id" id="department_id" class="form-control" required>
                                                            <option value="">Choose....</option>
                                                            @foreach($users->where('department_id' , $department->id) as $item)
                                                                <option value="{{ $item->id }}" {{ old('department_id') == $item->id  ? 'selected' : ''}}>{{$item->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('department_id'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('department_id') }}</strong>
                                                            </span>
                                                        @endif
                                                        <div style="margin: 10px 0 0 6px; ">
                                                            <button class="btn btn-xs btn-toolbar" @click="edit = false">Cancel</button>
                                                            <button class="btn btn-xs btn-info" type="submit">Set</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <span v-else>
                                            <span class="mr-1">Admin:</span>
                                            @foreach($admins->where('department_id' , $department->id) as $admin)
                                                <strong style="font-size: 25px;"> {{ $admin->full_name }}</strong> since {{ $admin->updated_at->diffForHumans() }}
                                            @endforeach
                                            <button class="btn btn-xs btn-success  pull-right" @click = "edit = true"><i class="fa fa-pencil" aria-hidden="true" ></i></button>
                                    </span>


                                    </div>
                                </department_head>

                            </div>
                        </div>
                    </department>
                    @empty
                        <h1> No Department</h1>

                @endforelse

            </div>
            @include('Admin.partial.sidebar')
            @include('Admin.addmodel')
        </div>
    </div>


@endsection









