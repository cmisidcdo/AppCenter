<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __("CMISID APPS") }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .card-app{
            align-items: center;
            margin: 20%;
        }
        @media only screen and (max-width: 990px) {
            .card-app{
                margin: 10%;
            }
        }
        
        @media only screen and (max-width: 258px) {
            .card-app{
                margin: 1%;
                margin-bottom: 20px;
            }
        }
        
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('public_show', base64_encode($appilcation->id)) }}">
                    <img src="{{asset("images/ict.png")}}" alt="">
                    {{ __("CMISID APPS") }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-light text-muted border-bottom-0 bg-info">
                                 RELEASE {{$lastest->release_number}}
                            </div>
                            <div class="card-body pt-0 ">
                                <div class="row">
                                  
                                    <div class="col-md-6 mt-3">
                                        <h1 class="lead fs-2 fw-bold"><b>{{$appilcation->app_name}}</b></h1>
                                        <div class="text-success">for Android</div>
                                        <i class="fw-bold text-primary">By City Management Information Systems and Innovation Department</i>
                                        <p class="text-muted text-sm">{{$lastest->created_at}}</p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Version: {{$lastest->release_version}}</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Notes: <textarea class="form-control" readonly>{{$lastest->release_notes}}</textarea></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-body rounded shadow card-app">
                                            <img src="{{asset("uploads/".$appilcation->app_icon)}}" alt="user-avatar" class="img-circle img-fluid p-2 w-100" style="max-width: 50%;">
                                            <div class="card-footer border-0 bg-body text-center">
                                                <div><i class="bi bi-android2 text-success fs-5"></i> android app</div>
                                                <a href="{{route("public_download",  base64_encode($lastest->id))}}" class="btn btn-primary  btn-primary">
                                                     DOWNLOAD
                                                </a>
                                                <div class="small">{{$lastest->total_downloads}} download/s</div>
                                            </div>
                                        </div>
                                        <div class="visible-print text-center">
                                            {!! 
                                                QrCode::size(150)
                                                    ->errorCorrection('H')
                                                    ->generate(route("public_download",  base64_encode($lastest->id))); 
                                            !!}
                                            <p>Scan me to download app.</p>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12 mt-5 table-responsive">
                                        <span>Previous Release</span>
                                        <hr/>
                                        <table class="table">
                                            @foreach ($detail as $item)
                                            <tr>
                                                <td>{{ $item->release_number}}</td>
                                                <td>{{ $item->created_at}}</td>
                                                <td>{{ $item->release_version}}</td>
                                                <td>
                                                    <a href="{{route("public_download",  base64_encode($item->id))}}" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-android2"></i> DOWNLOAD
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </table>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
