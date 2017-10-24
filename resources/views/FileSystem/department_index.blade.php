@extends('layouts.app')


@section('search')

        <div style="margin-top: 10px;" class="col-md-8 col-md-offset-1">
            <form method="get" action={{url("departmentDrive/search")}}>
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
                        <i class="fa fa-search" aria-hidden="true"></i></button>
                   </span>
                </div>
            </form>
        </div>

@endsection

@section('content')
    <div class="panel panel-default">
        <div style="-webkit-box-shadow: 0 10px 6px -6px #777;
	   -moz-box-shadow: 0 10px 6px -6px #777;
	        box-shadow: 0 10px 6px -6px #777;
    background-color: rgba(0,0,0,.1);" class="panel-heading">

            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#Modal">
                <i style="margin-right: 5px;" class="fa fa-plus-circle" aria-hidden="true"></i> New Folder</button>



            <button  class="btn btn-sm btn-success mr-1" data-toggle="modal" data-target="#uploadModal">
                <i style="margin-right: 5px;" class="fa fa-upload" aria-hidden="true"></i> Upload File</button>
            <strong>
                <a href="{{url("drive/".Auth::user()->department->name)}}">DepartmentDrive</a>
                @if($parent_id != 0)
                    @foreach( ($parent->parent_folder($parent->id)) as $item )
                        &nbsp;<i style="margin-right: 5px;" class="fa fa-chevron-right" aria-hidden="true"></i><a href="{{ url("departmentdrive/".$item['id']) }}">{{  $item['name'] }}</a>
                    @endforeach
                @endif
            </strong>

        </div>

        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Folder</h4>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action={{ url("/newdepartmentfolder") }}>
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


                    <tag :parent_id=0 :department_parent_id={{ $parent_id }} :department_id=1></tag>



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

                            <td> <a href="{{url("departmentdrive/".$folder->id)}}">
                                    <i class="fa fa-folder fa-lg mr-1" aria-hidden="true">
                                    </i>{{ $folder->name }}
                                </a></td>
                            <td>{{  $folder->created_at->toDayDateTimeString() }}</td>
                            <td>-</td>
                            <td>

                                <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="btn btn-xs btn-info" @click="edit=true" title="Rename Folder">
                                            <i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <div v-if="edit">
                                            <div class="modall is-active">
                                                <div class="modall-background"></div>
                                                <div class="modall-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Rename Folder</h4>
                                                    </div>

                                                    <form class="form-horizontal" role="form" method="POST" action="{{ url("/rename/folder") }}">
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
                            <td> <a href="{{ url("downloads/".$file->id) }}">
                                    <i class="fa {{$file->icon}}  fa-lg mr-1" aria-hidden="true">
                                    </i>{{ $file->name }}
                                    {{--<!--@foreach($file->tags as $tag) --}}
                                    {{--{{ $tag->name }} --}}
                                    {{--@endforeach-->--}}
                                </a></td>
                            <td>{{  $file->created_at->toDayDateTimeString() }}</td>
                            <td>{{ $file->size }}</td>
                            <td>
                                <department_head inline-template  v-cloak>
                                    <div style="display: inline;">
                                        <button class="btn btn-xs btn-success" @click="edit=true" title="File Details">
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
                                                        <p>Uploaded By : <strong>{{ $file->uploader->full_name }}</strong></p>
                                                        <p>Tags <i class="fa fa-tags" aria-hidden="true"></i></p>
                                                        @foreach($file->tags as $tag)
                                                            <span class="label label-danger"> {{ $tag->name }}</span>
                                                        @endforeach

                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-default"  @click="edit = false">Close</button>

                                                    </div>


                                                </div>
                                                <button class="modal-close is-large"></button>
                                            </div>
                                        </div>
                                    </div>
                                </department_head>

                            @if( Auth::user()->isAdmin == 1)
                                    <form style="display: inline;" method="post" action="{{url("/unapproved")}}">
                                        {{ csrf_field() }}
                                        <input style="display: none;" name="file_id" value="{{ $file->id }}" type="text">
                                        <button class="btn btn-xs btn-primary mr-1" type="submit" title="Unapproved This File">
                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i></button>
                                    </form>

                                    <department_head inline-template  v-cloak>
                                        <div style="display: inline;">
                                            <button class="btn btn-xs btn-primary" @click="edit=true" title="Move File">
                                                <i class="fa fa-share" aria-hidden="true"></i></button>
                                            <div v-if="edit">
                                                <div class="modall is-active">
                                                    <div class="modall-background"></div>
                                                    <div class="modall-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Moved File</h4>
                                                        </div>

                                                        <form class="form-horizontal" role="form" method="POST" action="{{url("/moveFile")}}">
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
                                                                <button type="submit" class="btn btn-primary">Moved</button>
                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </department_head>


                                    <department_head inline-template  v-cloak>
                                        <div style="display: inline;">
                                            <button class="btn btn-xs btn-danger"  @click="edit=true" title="Delete File">
                                                <i class="fa fa-trash" aria-hidden="true"></i></button>
                                            <div v-if="edit">
                                                <div class="modall is-active">
                                                    <div class="modall-background"></div>
                                                    <div class="modall-content">

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


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </department_head>


                                @endif
                                @if(( Auth::user()->isAdmin == 1) or(Auth::user()->id == $file->user_id))
                                    <edit :files="{{ $file }}" file_id={{ $file->id }} ta="{{ $file->tagToArray($file) }}"  ></edit>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(count($unapprovedFiles))
                    @if( Auth::user()->isAdmin == 1)

                        <h1>Unapproved Files</h1>
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
                            @foreach( $unapprovedFiles as $file )
                                <tr>
                                    <td> <a href="{{url("downloads/".$file->id)}}">
                                            <i class="fa {{$file->icon}}  fa-lg mr-1" aria-hidden="true">
                                            </i>{{ $file->name }}
                                            {{--<!--@foreach($file->tags as $tag) --}}
                                            {{--{{ $tag->name }} --}}
                                            {{--@endforeach-->--}}
                                        </a></td>
                                    <td>{{  $file->created_at->toDayDateTimeString() }}</td>
                                    <td>{{  $file->size }}</td>
                                    <td>

                                        <department_head inline-template  v-cloak>
                                            <div style="display: inline;">
                                                <button class="btn btn-xs btn-danger" @click="edit=true">
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
                                                                <p>Uploaded By : <strong>{{ $file->uploader->full_name }}</strong></p>
                                                                <p>Tags <i class="fa fa-tags" aria-hidden="true"></i></p>
                                                                @foreach($file->tags as $tag)
                                                                    <span class="label label-danger"> {{ $tag->name }}</span>
                                                                @endforeach

                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-default"  @click="edit = false">Close</button>

                                                            </div>


                                                        </div>
                                                        <button class="modal-close is-large"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </department_head>

                                        <form style="display: inline;" method="post" action="{{url("/approved")}}">
                                            {{ csrf_field() }}
                                            <input style="display: none;" name="file_id" value="{{ $file->id }}" type="text">
                                            <button class="btn btn-xs btn-primary mr-1" type="submit" title="Approved This File">
                                                <i class="fa fa-thumbs-up " aria-hidden="true"></i>  </button>
                                        </form>

                                        <department_head inline-template  v-cloak>
                                            <div style="display: inline;">
                                                <button class="btn btn-xs btn-danger"  @click="edit=true">
                                                    <i class="fa fa-trash" aria-hidden="true"></i></button>
                                                <div v-if="edit">
                                                    <div class="modall is-active">
                                                        <div class="modall-background"></div>
                                                        <div class="modall-content">

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
                    @endif
                @endif


                @if(count($myUnapprovedFiles))
                    <h1>My Unapproved Files</h1>
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
                        @foreach( $myUnapprovedFiles as $file )
                            <tr>
                                <td> <a href="{{url("downloads/".$file->id)}}">
                                        <i class="fa {{$file->icon}}  fa-lg mr-1" aria-hidden="true">
                                        </i>{{ $file->name }}
                                        {{--<!--@foreach($file->tags as $tag) --}}
                                        {{--{{ $tag->name }} --}}
                                        {{--@endforeach-->--}}
                                    </a></td>
                                <td>{{  $file->created_at->toDayDateTimeString() }}</td>
                                <td>{{  $file->size }}</td>
                                <td>

                                    <department_head inline-template  v-cloak>
                                        <div style="display: inline;">
                                            <button class="btn btn-xs btn-danger" @click="edit=true">
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

                                                        </div>


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
                @endif
            </div>
            @include('layouts.sidebar')

        </div>
    </div>
@endsection