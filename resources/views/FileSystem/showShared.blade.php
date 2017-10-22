@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div style="-webkit-box-shadow: 0 10px 6px -6px #777;
	   -moz-box-shadow: 0 10px 6px -6px #777;
	        box-shadow: 0 10px 6px -6px #777;
    background-color: rgba(0,0,0,.1);" class="panel-heading">

                <center><a href="{{url("Drive/shared")}}"><h4>Shared With Me</h4></a></center>


        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 primary">

                @if(count($sharedFiles))
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
                    @foreach( $sharedFiles as $file )
                        <tr>
                            <td> <a href="#">
                                    <i class="fa fa-file fa-lg mr-1" aria-hidden="true">
                                    </i>{{ $file->name }}
                                </a></td>
                            <td>{{  $file->created_at->toDayDateTimeString() }}</td>
                            <td>{{  $file->size }}</td>
                            <td>
                                <p style="display: inline">Shared By: <strong>{{ $file->uploader->full_name }}</strong></p>
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

                                                    <form class="form-horizontal" role="form" method="POST" action="{{url("/file/delete")}}">
                                                        {{ csrf_field() }}
                                                       
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

                    @endforeach
                        </tr>
                    </tbody>
                </table>

                @else
                    <div>
                    <hr>
                        <center><p style="font-size: 40px;"><strong>No Shared Files</strong></p></center>
                    <hr>
                    </div>
                @endif

            </div>

            @include('layouts.sidebar')
        </div>
    </div>
@endsection