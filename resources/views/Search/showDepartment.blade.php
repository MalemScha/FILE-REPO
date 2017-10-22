@extends('layouts.app')


@section('search')

    <div style="margin-top: 10px;" class="col-md-8 col-md-offset-1">
        <form method="post" action={{url("/searchDepartment")}}>
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" name="search" value={{ str_replace(' ','+',$search) }} class="form-control" placeholder="Search for...">
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
        <div class="panel-heading" style="-webkit-box-shadow: 0 10px 6px -6px #777;
	   -moz-box-shadow: 0 10px 6px -6px #777;
	        box-shadow: 0 10px 6px -6px #777;
    background-color: rgba(0,0,0,.1);">
           <center><h1>Search Result for "{{ $search }}"</h1></center>

        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 primary">
            @if(count($files)==0)
            <hr>
            <center><h1>No Search Result</h1></center>
            <hr>
            
            @else

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
                     @foreach( $files as $file )
                        <tr>
                            <td> <a href="#">
                                    <i class="fa fa-file fa-lg mr-1" aria-hidden="true">
                                    </i>{{ $file->name }}
                                 
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
