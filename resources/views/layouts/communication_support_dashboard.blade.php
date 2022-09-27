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
    <link rel="icon" type="image/png" href="{{asset_app('assets/img/logo/Logo BRI.png')}}" />
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset_app('css/app.css')}}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset_app('assets/css/temp/style.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/temp/components.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/adm.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa.css') }}"/>
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
                           class="btn btn-block text-left menu-kiri d-flex justify-content-center btn-menu-com {{request()->is('mycomsupport/initiative') || request()->is('mycomsupport/initiative/article') ? ' active' : ''}}"
                           tabindex="-1" role="button">
                            <i class="fas fa-comment" id="biru" style="font-size: 25px;"></i>
                            <span class="px-2 f-20">
                    Communication Initiative
                  </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown pb-2">
                        <a href="{{route('mycomsupport.strategic')}}"
                           class="btn btn-block text-left menu-kiri d-flex justify-content-center btn-menu-com {{request()->is('mycomsupport/strategic')  ? ' active' : ''}}"
                           tabindex="-1" role="button">
                            <i class="fas fa-building" id="cyan" style="font-size: 25px;"></i>
                            <span class="px-2 f-20">
                    Strategic Initiative
                  </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown pb-2">
                        <a href="{{route('mycomsupport.implementation')}}"
                           class="btn btn-block text-left menu-kiri d-flex justify-content-center btn-menu-com {{request()->is('mycomsupport/implementation') ? ' active' : ''}}"
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
                        <h5 data-toggle="collapse" data-target="#collapsedirectorat" aria-expanded="false" aria-controls="collapsedirectorat" class="dropdown-toggle">Direktorat</h5>
                        <ul class="collapse" id="collapsedirectorat">
                            <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Finance Directorate</a>
                            <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Consumer Directorate</a>
                        </ul>
                    </div>
                    <div class="text-dark p-2">
                        <h5 data-toggle="collapse" data-target="#collapsedate" aria-expanded="false" aria-controls="collapsedate" class="dropdown-toggle">Tahun</h5>
                        <ul class="collapse" id="collapsedate">
{{--                            foreach date--}}
                            <div class="row">
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">2019</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">2020</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">2021</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">2022</a>
                            </div>
                            <div id="year-list" class="row">
                                <p>Bulan</p>
                                <hr/>
                            </div>
                            <div>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Jan</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Feb</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Mar</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Apr</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Mei</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Jun</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Jul</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Agu</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Sep</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Okt</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Nov</a>
                                <a role="button" class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">Des</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    @yield('content')
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
<script src="{{asset_app('assets/js/core.js')}}" ></script>
<script src="{{asset_app('assets/js/charts.js')}}" ></script>
<script src="{{asset_app('assets/js/themes/animated.js')}}" ></script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
@isset($congrats->achievements_id)
    {{-- congrats --}}
    <script src="{{asset_app('assets/js/plugin/TweenMax.min.js')}}" ></script>
    <script type="text/javascript" src="{{asset_app('assets/js/plugin/lodash.min.js')}}"></script>
    <script src="{{asset_app('assets/js/congrats.js')}}" ></script>
    <script>
        $('.btn-continue').click(function(){
            var token_congrats  = "{{session('token')}}";
            var id_congrats     = "{{$congrats->id}}";
            var be_congrats    = "{{config('app.url')}}";
            // update
            var url = `${be_congrats}congrats`;
            $.ajax({
                url: url,
                type: "post",
                data: {id:id_congrats, token:token_congrats},
                beforeSend: function(xhr)
                {
                    xhr.setRequestHeader("X-CSRF-TOKEN",csrf);
                    $('.layar-back').hide();
                },
                success: function(data){
                    console.log(data.data.message);
                },
                error : function(e){
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
        Toast.fire({icon: 'error',title: tampung});
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
        Toast.fire({icon: 'success',title: tampung});
    </script>
@endif
<!-- JS page -->
@stack('page-script')
<!-- Template JS File -->
<script src="{{asset_app('assets/js/temp/scripts.js')}}"></script>
<script src="{{asset_app('assets/js/temp/custom.js')}}"></script>
<script src="{{asset_app('assets/js/page/notification.js')}}"></script>
</body>
