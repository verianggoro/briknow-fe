@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <style>
        #waow {
            border: solid rgba(47, 128, 237, 1);
            max-width: 85px;
            margin: 0;
        }
    </style>
@endpush

@section('breadcumb', 'Admin')
@section('back', route('katalog.index'))

@section('content')

    <div class="senddataloader">
        <div class="loading">
            <img src="{{asset_app('assets/img/senddataloader.gif')}}" style="width:50px;height:50px">
        </div>
    </div>
    <div class="row mx-0">
        <div class="col-md-12" id="konten">
            <!-- BUTTONS -->
            <div class="my-3 d-flex mx-auto flex-wrap">
                <a href="{{route('dashboard.performance')}}" class="btn btn-outline-primary mt-2 mr-3" id="performance"
                   role="button">Performance</a>
                <a href="{{route('dashboard.alldata')}}" class="btn btn-outline-primary mt-2 mr-3" id="alldata"
                   role="button">All Data</a>
                <a href="{{route('dashboard.comsuport')}}" class="btn btn-outline-primary mt-2 mr-3 active"
                   id="comsuport" role="button">Communication Suppport</a>
                <div class="dropdown mt-2 mr-3 ml-auto">
                    <button data-toggle="dropdown" class="btn btn-outline-secondary bg-white dropdown-toggle"
                            id="btn-sort-download">
                        Download
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="m-1">XlSX</li>
                        <li class="m-1">PDF</li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="container-fluid">
                    <div class="card d-flex w-100 p-3">
                        <div class="row justify-content-between">
                            <div class="p-2">
                                <h4>Communication Initiative Analytics</h4>
                            </div>
                            <div class="ml-auto mr-3">
                                <div class="btn btn-outline-secondary">
                                    <div class="fa fa-download"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="p-2 ml-2">
                                <div style="width: 10rem; height: 3px; background-color: #0a53be"></div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">1</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Article</p>
                            </div>
                            <div id="container-article" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsArticle">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-article">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-article">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">2</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Video Content</p>
                            </div>
                            <div id="container-video" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsVideo" aria-expanded="false"
                                        aria-controls="collapsVideo"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsVideo">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-video">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-video">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">3</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Instagram Content</p>
                            </div>
                            <div id="container-ig" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsIg" aria-expanded="false"
                                        aria-controls="collapsIg"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsIg">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-ig">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-ig">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">4</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Podcast</p>
                            </div>
                            <div id="container-podcast" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsPodcast" aria-expanded="false"
                                        aria-controls="collapsPodcast"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsPodcast">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-podcast">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-podcast">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">5</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">E-Poster</p>
                            </div>
                            <div id="container-poster" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsPoster" aria-expanded="false"
                                        aria-controls="collapsPoster"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsPoster">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-poster">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-poster">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">6</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Infographics</p>
                            </div>
                            <div id="container-info" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsInfo" aria-expanded="false"
                                        aria-controls="collapsInfo"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsInfo">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-info">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-info">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">8</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Transformation Jurney</p>
                            </div>
                            <div id="container-trans" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsTrans" aria-expanded="false"
                                        aria-controls="collapsTrans"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsTrans">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-trans">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-trans">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">10</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Icon, Logo, Mascot</p>
                            </div>
                            <div id="container-logo" class="p-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsLogo" aria-expanded="false"
                                        aria-controls="collapsLogo"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsLogo">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                    <div id="most-view-logo">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div id="most-download-logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="container-fluid">
                    <div class="card d-flex w-100 p-3">
                        <div class="row justify-content-between">
                            <div class="p-2">
                                <h4>Strategic Initiative Analytics</h4>
                            </div>
                            <div class="ml-auto mr-3">
                                <div class="btn btn-outline-secondary">
                                    <div class="fa fa-download"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="p-2 ml-2">
                                <div style="width: 10rem; height: 3px; background-color: #0a53be"></div>
                            </div>
                        </div>
                        <hr/>
                        <div id="data-strategic-table">
                            <div id="container-name-strategic">
                            </div>
                            <div id="container-collapse">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="container-fluid">
                    <div class="card d-flex w-100 p-3">
                        <div class="row justify-content-between">
                            <div class="p-2">
                                <h4>Implementation Analytics</h4>
                            </div>
                            <div class="ml-auto mr-3">
                                <div class="btn btn-outline-secondary">
                                    <div class="fa fa-download"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="p-2 ml-2">
                                <div style="width: 10rem; height: 3px; background-color: #0a53be"></div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">1</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Roll-Out</p>
                            </div>
                            <div id="imp-search-roll" class="p-2">
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsImplementRoll" aria-expanded="false"
                                        aria-controls="collapsImplementRoll"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsImplementRoll">

                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">2</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Piloting</p>
                            </div>
                            <div id="imp-search-piloting" class="p-2">

                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsImplementPilot" aria-expanded="false"
                                        aria-controls="collapsImplementPilot"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsImplementPilot">

                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">3</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Sosialisasi</p>
                            </div>
                            <div id="imp-search-sosialisasi" class="p-2">
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsImplementSosialisasi" aria-expanded="false"
                                        aria-controls="collapsImplementSosialisasi"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsImplementSosialisasi">
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BUTTONS -->

        </div>
    </div>

@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/core.js')}}"></script>
    <script src="{{asset_app('assets/js/charts.js')}}"></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}"></script>
{{--    <script src="{{asset_app('assets/js/script/index.js')}}"></script>--}}
    <script src="{{asset_app('assets/js/page/dash_comsumport.js')}}"
@endpush
