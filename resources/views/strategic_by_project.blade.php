<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8 encoded">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="pages" content="{{ url('') }}">
    <meta name="BE" content="{{ config('app.url_be') }}">
    <meta name="csrf" content="@yield('csrf',csrf_token())">
    <meta name="kunci" content="@yield('kunci','*')">
    <title>@yield('title',config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{asset_app('assets/img/logo/Logo BRI.png')}}"/>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset_app('css/app.css')}}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset_app('assets/css/temp/style.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/temp/components.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/adm.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa.css') }}"/>

    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
    @isset($congrats->achievements_id)
        {{-- congrats --}}
        <link rel="stylesheet" href="{{asset_app('assets/css/congrats.css')}}">
    @endisset
    @stack('style')
</head>
<body>
<div class="senddataloader">
    <div class="loading">
        <img src="{{asset_app('assets/img/senddataloader.gif')}}" style="width:50px;height:50px">
    </div>
</div>
<div id="app">
    <div class="main-wrapper">
        <nav class="navbar navbar-expand-lg main-navbar bg-primary">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav">
                    <li>
                        <a href="{{route('home')}}">
                            <img src="{{asset_app('assets/img/logo/bri know white.png')}}" width="75%">
                        </a>
                    </li>
                    <li><a href="#" data-toggle="sidebar" class="pl-0 pr-0 nav-link nav-link-lg" id="trigger-sidebar"><i
                                    class="fas fa-bars"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right align-items-center">
                <li class="dropdown">
                    <a href="{{route('kontribusi')}}" class="btn bg-white addin btn-sm" role="button"
                       aria-pressed="true"><i class="fas fa-upload mr-1"></i>Upload Dokumen</a>
                </li>
                @include('layouts.notifikasi')
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image"
                             src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}"
                             draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @php
                            if (session('role') == 3) {
                                $role = 'Admin';
                            } else {
                                $role = 'User';
                            }
                        @endphp
                        <div class="dropdown-item">
                            <a href="{{route('home.profile')}}"
                               class="d-flex justify-content-left align-items-center w-100 text-decoration-none">
                                <div class="d-flex align-items-center mr-2">
                                    <img alt="image"
                                         src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}"
                                         draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                                </div>
                                <div>
                                    <div>
                                        <small class="d-block lh-10 text-dark">{{\Str::limit(session('username'),15)}}</small>
                                    </div>
                                    <div class="lh-20 d-flex align-items-center mt-1">
                                        <span class="badge badge-info px-1 py-0"><small>{{$role}}</small></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-divider my-1"></div>
                        <a href="{{ route('home') }}" class="dropdown-item">Home</a>
                        <a href="#" data-toggle='modal' data-target='#editprofil' class="dropdown-item">Edit Profile</a>
                        <a href="{{ route('myproject') }}" class="dropdown-item">My Project</a>
                        <a href="{{ route('myfavorite') }}" class="dropdown-item">My Favorite</a>
                        <a href="{{ route('mylesson') }}" class="dropdown-item">My Lesson Learned</a>
                        <a href="{{ route('forum.index') }}" class="dropdown-item">Forum</a>
                        @if(session('role') == 3)
                            <a href="{{ route('dashboard.performance') }}" class="dropdown-item">Dashboard Admin</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar">
            <aside id="sidebar-wrapper">
                <div class="hide-sidebar-mini">
                    <div class="w-100 d-flex justify-content-center mb-2">
                        <img alt="avatar"
                             src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}"
                             draggable="false" class="rounded-circle mt-4"
                             style="height:60px; width:60px;overflow:hidden;object-fit:cover;">
                    </div>
                    <ul class="sidebar-menu text-center">
                        <li class="nav-item dropdown py-2 mb-2">
                            <a href="#"
                               class="h-20 text-decoration-none text-left menu-kiri d-flex justify-content-center">
                                <span class="nav-link p-0 font-weight-bold f-20 text-center">{{session('name')}}</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="mailto:{{session('email')}}"
                               class="h-20 text-left menu-kiri d-flex justify-content-center">
                                <span class="nav-link p-0 text-center">{{session('email')}}</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#"
                               class="text-decoration-none h-20 text-left menu-kiri d-flex justify-content-center">
                                <span class="nav-link p-0 text-center">PN : {{session('personal_number')}}</span>
                            </a>
                        </li>
                        <hr>
                    </ul>
                </div>
                <ul class="sidebar-menu text-center">
                    <li class="nav-item dropdown pb-2">
                        <a href="{{route('mycomsupport.initiative')}}"
                           class="btn btn-block text-left menu-kiri d-flex justify-content-center btn-menu-com {{str_contains(request()->path(),'initiative') ? ' active' : ''}}"
                           tabindex="-1" role="button">
                            <i class="fas fa-comment" id="biru" style="font-size: 25px;"></i>
                            <span class="px-2 f-20">
                    Communication Initiative
                  </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown pb-2">
                        <a href="{{route('mycomsupport.strategic')}}"
                           class="btn btn-block text-left menu-kiri d-flex justify-content-center btn-menu-com {{str_contains(request()->path(),'strategic')  ? ' active' : ''}}"
                           tabindex="-1" role="button">
                            <i class="fas fa-building" id="cyan" style="font-size: 25px;"></i>
                            <span class="px-2 f-20">
                    Strategic Initiative
                  </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown pb-2">
                        <a href="{{route('mycomsupport.implementation')}}"
                           class="btn btn-block text-left menu-kiri d-flex justify-content-center btn-menu-com {{str_contains(request()->path(),'implementation') ? ' active' : ''}}"
                           tabindex="-1" role="button">
                            <i class="fas fa-chart-pie" id="biru" style="font-size: 25px;"></i>
                            <span class="px-2 f-20">
                    Implementation
                  </span>
                        </a>
                    </li>
                </ul>
                <div class="card g-6sa6ss sh-a22l m-2" style="border-radius: 10px">
                    <div class="bg-bri text-white p-2" style="border-radius: 10px 10px 0px 0px">
                        <h4>General</h4>
                    </div>
                    <div class="text-dark p-2">
                        <h5 data-toggle="collapse" data-target="#collapsedirectorat" aria-expanded="false"
                            aria-controls="collapsedirectorat" class="dropdown-toggle">Direktorat</h5>
                        <ul class="collapse" id="collapsedirectorat">
                            <div class="row d-flex spacing-filter">
                                <select name="direktorat" id="direktorat-lay" class="form-control text-black select2" data-live-search="true"
                                        style="height: 44px" value="{{old('direktorat')}}">
                                    <option value="" disabled selected>Pilih Direktorat</option>
                                    @if(empty($direktorat))
                                        <option value="finance" data-value="finance">{{$dataList ?? 'NOT FOUND'}}</option>
                                    @else
                                        @foreach($direktorat as $dirContent)
                                            <option value="{{$dirContent->direktorat }}" data-value="{{ $dirContent->direktorat }}">{{$dirContent->direktorat}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="row d-flex spacing-filter">
                                <select name="direktorat" id="direktorat" class="form-control text-black select2 mt-2" data-live-search="true"
                                        style="height: 44px" value="{{old('direktorat')}}">
                                    <option value="" disabled selected>Pilih Divisi</option>
                                    @if(empty($divisiRes))
                                        <option value="null" data-value="null">{{$divisi ?? 'NOT FOUND'}}</option>
                                    @else
                                        @foreach($divisiRes as $divContent)
                                            <option value="{{$divContent->divisi }}" data-value="{{ $divContent->divisi }}">{{$divContent->divisi}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </ul>
                    </div>
                    <div class="text-dark p-2">
                        <h5 data-toggle="collapse" data-target="#collapsedate" aria-expanded="false"
                            aria-controls="collapsedate" class="dropdown-toggle">Tahun</h5>
                        <ul class="collapse" id="collapsedate">
                            {{--                            foreach date--}}
                            <div class="row spacing-filter">
                                <a role="button" class="btn-filter col-sm-3 m-1 ">2019</a>
                                <a role="button" class="btn-filter col-sm-3 m-1 active">2020</a>
                                <a role="button" class="btn-filter col-sm-3 m-1 ">2021</a>
                                <a role="button" class="btn-filter col-sm-3 m-1 active">2022</a>
                            </div>
                            <div id="year-list" class="row spacing-filter">
                                <p>Bulan</p>
                            </div>
                            <div class="row d-flex spacing-filter align-self-center">
                                <a role="button" class="btn-filter col-sm-2 m-1">Jan</a>
                                <a role="button" class="btn-filter col-sm-2 m-1">Feb</a>
                                <a role="button" class="btn-filter col-sm-2 m-1">Mar</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 active">Apr</a>
                                <a role="button" class="btn-filter col-sm-2 m-1">Mei</a>
                                <a role="button" class="btn-filter col-sm-2 m-1">Jun</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 active">Jul</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 ">Agu</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 ">Sep</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 ">Okt</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 ">Nov</a>
                                <a role="button" class="btn-filter col-sm-2 m-1 ">Des</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>

        @section('breadcumb', 'Admin')
        @section('back', route('katalog.index'))
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row mx-0">
                        <div class="col-md-12" id="konten">
                            <h3 class="pl-2 pt-5">{{!empty($data->nama)?$data->nama:"-"}}</h3>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="mr-auto p-2">
                                    <div class="dropdown">
                                        <button data-toggle="dropdown" class="btn btn-outline-secondary bg-white dropdown-toggle">
                                            Sort By
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <a class="dropdown-item" href="#">Judul</a>
                                            <a class="dropdown-item" href="#">Tanggal</a>
                                            <a class="dropdown-item" href="#">View</a>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <label class="sr-only" for="inlineFormInputGroup">Title</label>
                                    <div class="input-group mb-2">
                                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control"
                                               id="inlineFormInputGroup" placeholder="Cari...">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;"><i
                                                        class="fa fa-search fa-sm" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <br/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Articles</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'article')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="{{route('mycomsupport.strategic.type.content', [$data->slug, 'article'])}}">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Video Content</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'video')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="#">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse

                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Podcast</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'podcast')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="#">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Instagram</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'instagram')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="#">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Transformation</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'transformation')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="{{route('mycomsupport.strategic.type.content', [$data->slug, 'article'])}}">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Logo</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'logo')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="#">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse
                                </div>
                            </div>
                            <hr/>
                            <div class="d-flex">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Infographics</h4>
                                    </div>
                                    @forelse($content as $values)
                                        @if($values->id === 'infographics')
                                            <div class="col-12">
                                                <p>{{$values->total_data}}</p>
                                            </div>
                                            @if(!empty($values->data))
                                                @foreach($values->data as $contentData)
                                                    <div class="col-2 justify-content-center">
                                                        <a href="#">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <div class="col-2 justify-content-center">
                                                    <a href="#">
                                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                                            </div>
                                                            <span>Lihat Semua</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @empty
                                        Empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="w-100" id="popupin">
                @yield('popup')
            </div>
        </div>
    </div>
    @include('layouts.edit_profile')
</div>

<!-- General JS Scripts -->
<script src="{{asset_app('js/app.js')}}"></script>
<script src="{{asset_app('assets/js/plugin/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset_app('assets/js/core.js')}}"></script>
<script src="{{asset_app('assets/js/charts.js')}}"></script>
<script src="{{asset_app('assets/js/themes/animated.js')}}"></script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
@isset($congrats->achievements_id)
    {{-- congrats --}}
    <script src="{{asset_app('assets/js/plugin/TweenMax.min.js')}}"></script>
    <script type="text/javascript" src="{{asset_app('assets/js/plugin/lodash.min.js')}}"></script>
    <script src="{{asset_app('assets/js/congrats.js')}}"></script>
    <script>
        $('.btn-continue').click(function () {
            var token_congrats = "{{session('token')}}";
            var id_congrats = "{{$congrats->id}}";
            var be_congrats = "{{config('app.url')}}";
            // update
            var url = `${be_congrats}congrats`;
            $.ajax({
                url: url,
                type: "post",
                data: {id: id_congrats, token: token_congrats},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                    $('.layar-back').hide();
                },
                success: function (data) {
                    console.log(data.data.message);
                },
                error: function (e) {
                    console.log(e.responseJSON.message);
                }
            });
        });

    </script>
@endisset
@if (Session::has('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        var tampung = `{{ Session::get('error')}}`;
        Toast.fire({icon: 'error', title: tampung});
    </script>
@endif
@if (Session::has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        var tampung = `{{ Session::get('success')}}`;
        Toast.fire({icon: 'success', title: tampung});
    </script>
@endif
<!-- JS page -->
@stack('page-script')
<!-- Template JS File -->
<script src="{{asset_app('assets/js/temp/scripts.js')}}"></script>
<script src="{{asset_app('assets/js/temp/custom.js')}}"></script>
<script src="{{asset_app('assets/js/page/notification.js')}}"></script>

</body>
