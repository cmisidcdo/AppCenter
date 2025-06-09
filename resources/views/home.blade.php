@extends('layouts.app')

@section('content')
<style>
.app-card { height: 100%; }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Applications') }}</div>
                    <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal">ADD</button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row display-flex">
                        @foreach ($applications as $item)  
                        <!-- Team Member 2 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-0 shadow app-card">
                            <img src="{{$item->app_icon ? asset("uploads/$item->app_icon") :  asset("images/logo.png")}}" class="card-img-top" alt="..." height="100%">
                            <div class="card-body text-center">
                              <h5 class="card-title mb-0">{{$item->app_name}}</h5>
                              <div class="card-text text-black-50">{{$item->os_type}}</div>
                              <a href="{{route("application.show",$item->id)}}" class="btn btn-success btn-sm">OPEN</a>
                            </div>
                          </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD APPLICATION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('application.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="app_name" class="form-label">APP NAME</label>
                            <input type="text" class="form-control" name="app_name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="release_type" class="form-label">RELEASE TYPE</label>
                            <select name="release_type" id="release_type" class="form-select">
                                <option value="">---SELECT---</option>
                                <option value="BETA">BETA</option>
                                <option value="PRODUCTION">PRODUCTION</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="os_type" class="form-label">OS TYPE</label>
                            <select name="os_type" id="os_type" class="form-select">
                                <option value="">---SELECT---</option>
                                <option value="ANDROID">ANDROID</option>
                                <option value="IOS">IOS</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="app_icon" class="form-label">APP ICON</label>
                            <input type="file" class="form-control" name="app_icon" aria-describedby="emailHelp">
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
