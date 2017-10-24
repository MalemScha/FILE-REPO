@extends('layouts.app')


@section('search')

        <div style="margin-top: 10px;" class="col-md-8 col-md-offset-1">
            <form method="get" action={{url("Drive/search")}}>
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for...">
                     @if ($errors->has('search'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('search') }}</strong>
                                    </span>
                     @endif
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                   </span>
                </div>
            </form>
        </div>

@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading" style="-webkit-box-shadow: 0 10px 6px -6px #777;
	   -moz-box-shadow: 0 10px 6px -6px #777;
	        box-shadow: 0 10px 6px -6px #777;
    background-color: rgba(0,0,0,.1);">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#Modal">
                <i style="margin-right: 5px;" class="fa fa-plus-circle" aria-hidden="true"></i> New Folder</button>



            <button  class="btn btn-sm btn-success mr-1" data-toggle="modal" data-target="#uploadModal">
                <i style="margin-right: 5px;" class="fa fa-upload" aria-hidden="true"></i> Upload File</button>


            <strong><a href="{{ url("/mydrive") }}">MyDrive</a>

                @if($parent_id != 0)
                    @foreach( ($parent->parent_folder($parent_id)) as $item )
                        &nbsp;<i style="margin-right: 5px;" class="fa fa-chevron-right" aria-hidden="true"></i><a href="{{ url("mydrive/".$item['id']) }}">{{  $item['name'] }}</a>
                    @endforeach
                @endif

            </strong>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create New Folder</h4>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action={{ url("/newfolder") }}>
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                                    <input style="display: none" id="parent_folder_id" type="text" class="form-control" name="parent_folder_id" value={{ $parent_id }} required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Upload File</h4>
                    </div>


                    <tag :parent_id={{ $parent_id }} :department_parent_id=0 :department_id=0></tag>



                </div>
            </div>
        </div>


    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 primary">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Size</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $folders as $folder )
                        <tr>

                            <td> <a href="{{url("mydrive/".$folder->id)}}">
                                    <i class="fa fa-folder fa-lg mr-1" aria-hidden="true">
                                    </i>{{ $folder->name }}
                                </a></td>
                            <td>{{  $folder->created_at->toDayDateTimeString() }}</td>
                            <td>-</td>
                            <td>


                                <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="btn btn-xs btn-info" @click="edit=true">
                                            <i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <div v-if="edit">
                                            <div class="modall is-active">
                                                <div class="modall-background"></div>
                                                <div class="modall-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Rename Folder</h4>
                                                    </div>

                                                    <form class="form-horizontal" role="form" method="POST" action="{{ url("/rename") }}">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">

                                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                <label for="name" class="col-md-4 control-label">Name</label>

                                                                <div class="col-md-6">
                                                                    <input id="name" type="text" class="form-control" name="name" value="{{ $folder->name }}" required autofocus>
                                                                    <input style="display: none" id="folder_id" type="text" class="form-control" name="folder_id" value={{ $folder->id }} required autofocus>
                                                                    @if ($errors->has('name'))
                                                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" @click="edit = false">Close</button>
                                                            <button type="submit" class="btn btn-primary">Rename</button>
                                                        </div>
                                                    </form>

                                                </div>
                                                <button class="modal-close is-large"></button>
                                            </div>
                                        </div>
                                    </div>
                                </department_head>



                            </td>
                        </tr>
                    @endforeach
                    @foreach( $files as $file )
                        <tr>
                            <td> <a href="{{ url("download/".$file->id) }}" >
                                    <i class="fa {{$file->icon}} fa-lg mr-1" aria-hidden="true">
                                    </i>{{ $file->name }}

                                </a></td>
                            <td>{{  $file->created_at->toDayDateTimeString() }}</td>
                            <td>{{ $file->size }}</td>
                            <td>



                                <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="btn btn-xs btn-success" @click="edit=true">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                        <div v-if="edit">
                                            <div class="modall is-active">
                                                <div class="modall-background"></div>
                                                <div class="modall-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                           File Details</h4>
                                                    </div>
                                                        <div class=" modal-body">
                                                            <p>File Name : <strong>{{ $file->name }}</strong></p>
                                                            <p>File Description : <strong>{{ $file->description }}</strong></p>
                                                            <p>Size : <strong>{{ $file->size }}</strong></p>
                                                            <p>Tags <i class="fa fa-tags" aria-hidden="true"></i></p>
                                                           @foreach($file->tags as $tag)
                                                                <span class="label label-danger"> {{ $tag->name }}</span>
                                                            @endforeach

                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                            <button type="submit" class="btn btn-primary">Share</button>
                                                        </div>


                                                </div>
                                                <button class="modal-close is-large"></button>
                                            </div>
                                        </div>
                                    </div>
                                </department_head>
                      

                                <edit :files="{{ $file }}" file_id={{ $file->id }} ta="{{ $file->tagToArray($file) }}"  ></edit>



                                @if($file->isBoth == 0)
                                    <department_head inline-template  v-cloak>
                                        <div style="display: inline;">
                                            <button class="btn btn-xs btn-primary" @click="edit=true" >
                                                <i class="fa fa-share-alt" aria-hidden="true"></i></button>
                                            <div v-if="edit">
                                                <div class="modall is-active">
                                                    <div class="modall-background"></div>
                                                    <div class="modall-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Share File in Department</h4>
                                                        </div>

                                                        <form class="form-horizontal" role="form" method="POST" action="{{url("/sharefiletodepartment")}}">
                                                            {{ csrf_field() }}
                                                            <div class="modal-body">
                                                                <div class="form-group{{ $errors->has('department_folder_id') ? ' has-error' : '' }}">
                                                                    <label for="department_folder_id" class="col-md-4 control-label">Pick a Folder:</label>
                                                                    <div class="col-md-6">
                                                                        <input style="display: none;" type="text" name="file_id" value="{{ $file->id }}">
                                                                        <select name="department_folder_id" id="department_folder_id" class="form-control"  data-show-icon="true" required>
                                                                            <option value="" selected>Choose....</option>
                                                                            <option value="0">Root</option>
                                                                            @foreach($departmentFolders as $item)
                                                                                <option value="{{ $item->id }}" {{ old('department_folder_id') == $item->id  ? 'selected' : ''}}> {{$item->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @if ($errors->has('department_folder_id'))
                                                                            <span class="help-block">
                                                                                <strong>{{ $errors->first('department_folder_id') }}</strong>
                                                                            </span>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                                <button type="submit" class="btn btn-primary">Share</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                    <button class="modal-close is-large"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </department_head>
                                @else

                                    <button class="btn btn-xs btn-default" title="Already Shared" disabled>
                                     <i class="fa fa-share-alt" aria-hidden="true"></i></button>

                                @endif



                                <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="btn btn-xs btn-warning"  @click="edit=true">
                                            <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                        <div v-if="edit">
                                            <div class="modall is-active">
                                                <div class="modall-background"></div>
                                                <div class="modall-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Share File</h4>
                                                    </div>
                                                    <form class="form-horizontal" role="form" method="POST" action="{{url("/sharefiletouser")}}">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            @if($file->shares->count() > 0)
                                                                <div  class="col-md-10 col-md-offset-1 panel panel-primary">
                                                                    <div style="padding:5px 10px;" class="panel-heading">
                                                                        <h3 class="panel-title">You Shared This File with</h3>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        @foreach($file->shares as $shared)
                                                                            <span class="label label-primary">{{ $shared->full_name }}</span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                                                <label for="user_id" class="col-md-4 control-label">Pick a User:</label>


                                                                <div class="col-md-6">
                                                                    <input style="display: none;" type="text" name="file_id" value="{{ $file->id }}">
                                                                    @if(($users->diff($file->shares))->count() == 0)
                                                                        <h5>File Shared with all Users</h5>
                                                                    @else
                                                                    <select name="user_id" id="user_id" class="form-control"  data-show-icon="true" required>


                                                                            <option value="" selected>Choose....</option>
                                                                            @foreach($users->diff($file->shares) as $item)
                                                                                <option value="{{ $item->id }}" {{ old('user_id') == $item->id  ? 'selected' : ''}}> {{$item->full_name}}</option>
                                                                            @endforeach
                                                                         @endif
                                                                    </select>
                                                                    @if ($errors->has('user_id'))
                                                                        <span class="help-block">
                                                                                <strong>{{ $errors->first('user_id') }}</strong>
                                                                            </span>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                            <button type="submit" class="btn btn-primary">Share</button>
                                                        </div>
                                                    </form>

                                                </div>
                                                <button class="modal-close is-large"></button>
                                            </div>
                                        </div>
                                    </div>
                                </department_head>




                                <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="btn btn-xs btn-danger"  @click="edit=true">
                                            <i class="fa fa-trash" aria-hidden="true"></i></button>
                                        <div v-if="edit">
                                            <div class="modall is-active">
                                                <div class="modall-background"></div>
                                                <div class="modall-content">
                                                    @if(($file->isDepartment($file->id)) or ($file->isShare($file->id)))
                                                        <div class=" modal-body">
                                                            <center><h3>You cannot delete this file......<br> The file is in sharing mode</h3></center>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                        </div>

                                                    @else
                                                        <form class="form-horizontal" role="form" method="POST" action="{{url("/files/".$file->id)}}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        <div class=" modal-body">


                                                                <input style="display: none;" type="text" name="file_id" value="{{ $file->id }}">


                                                        <center><h3>Are you sure you want to
                                                           delete this file?</h3></center>
                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-default"  @click="edit = false">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                        </form>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </department_head>

                            </td>
                        </tr>


                    @endforeach
                    </tbody>
                </table>

            </div>
            @include('layouts.sidebar')

        </div>
    </div>
@endsection
