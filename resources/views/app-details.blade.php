@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Oppsss!</strong>  {{ implode('', $errors->all(':message')) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><img src="{{asset("uploads/$application->app_icon")}}" width="32" alt=""> {{ $application->app_name }}</div>
                    <div class="btn-group">
                        <a href="{{route("application.index")}}" class="btn btn-danger">BACK</a>
                        <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal">NEW RELEASE</button>
                        <a href="{{route('public_show', base64_encode($application->id))}}"  target="_blank" class="btn btn-success">PUBLIC URL</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <td></td>
                            <td>Release</td>
                            <td>Version</td>
                            <td>Destination</td>
                            <td>Date</td>
                            <td>Downloads</td>
                            <td>Actions</td>
                        </thead>
                        <tbody>
                            @foreach ($application_details as $item)  
                            <tr>
                                <td><img src="{{asset("images/package-box.png")}}" alt="..." width="20"></td>
                                <td>{{$item->release_number}}</td>
                                <td>{{$item->release_version}}</td>
                                <td>{{$item->is_public == 1 ? "PUBLIC" : "PRIVATE"}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->total_downloads}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('download',$item->id)}}" class="btn btn-sm btn-warning">DOWNLOAD</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">NEW RELEASE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('application_details.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_location" class="form-label">APPLICATION FILE</label>
                            <input type="file" class="form-control" name="file_location" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="release_version" class="form-label">RELEASE VERSION</label>
                            <input type="text" class="form-control" name="release_version" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="release_notes" class="form-label">RELEASE NOTES</label>
                            <input type="text" class="form-control" name="release_notes" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="is_public" class="form-label">DESTINATION</label>
                            <select name="is_public" id="is_public" class="form-select">
                                <option value="">---SELECT---</option>
                                <option value="1">PUBLIC</option>
                                <option value="0">PRIVATE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">IS ACTIVE</label>
                            <select name="is_active" id="is_active" class="form-select">
                                <option value="">---SELECT---</option>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
@endsection