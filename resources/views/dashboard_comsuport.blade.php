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
                            <div class="p-2">
                                <p>3 Pencarian</p>
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
                                    <div class="row d-flex justify-content-between ml-3">
                                        <img class="card-img p-2" style="height: auto; width: 4rem"
                                             src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}"
                                             alt="Card image cap">
                                        <p class="p-2 align-items-center">TEST</p>
                                        <div class="ml-auto p-2 align-items-center">
                                            <div class="fa fas fa-eye">
                                                <span>1</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                    <div class="row d-flex justify-content-between mr-3">
                                        <img class="card-img p-2" style="height: auto; width: 4rem"
                                             src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}"
                                             alt="Card image cap">
                                        <p class="p-2 align-items-center">TEST</p>
                                        <div class="ml-auto p-2 align-items-center">
                                            <div class="fa fas fa-eye">
                                                <span>1</span>
                                            </div>
                                        </div>
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
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">3</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Instagram Content</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">4</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Podcast</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">5</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">E-Poster</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">6</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Infographics</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">8</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Transformation Jurney</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">10</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Icon, Logo, Mascot</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>
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
                            <div class="row d-flex justify-content-between">
                                <div class="p-2">
                                    <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">1</p>
                                </div>
                                <div class="mr-auto p-2">
                                    <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">TEST PROJECT</p>
                                </div>
                                <div class="p-2">
                                    <p>3 Pencarian</p>
                                </div>
                                <div class="p-2">
                                    <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                            data-target="#collapsStrategic" aria-expanded="false"
                                            aria-controls="collapsStrategic"></button>
                                </div>
                            </div>
                            <div class="collapse p-3" id="collapsStrategic">
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">1</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Article</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
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
                                            <div class="row d-flex justify-content-between ml-3">
                                                <img class="card-img p-2" style="height: auto; width: 4rem"
                                                     src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}"
                                                     alt="Card image cap">
                                                <p class="p-2 align-items-center">TEST</p>
                                                <div class="ml-auto p-2 align-items-center">
                                                    <div class="fa fas fa-eye">
                                                        <span>1</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                            <div class="row d-flex justify-content-between mr-3">
                                                <img class="card-img p-2" style="height: auto; width: 4rem"
                                                     src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}"
                                                     alt="Card image cap">
                                                <p class="p-2 align-items-center">TEST</p>
                                                <div class="ml-auto p-2 align-items-center">
                                                    <div class="fa fas fa-eye">
                                                        <span>1</span>
                                                    </div>
                                                </div>
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
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">3</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Instagram Content</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">4</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Podcast</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">5</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">E-Poster</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">6</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Infographics</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">8</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Transformation Jurney</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between">
                                    <div class="p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">10</p>
                                    </div>
                                    <div class="mr-auto p-2">
                                        <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Icon, Logo, Mascot</p>
                                    </div>
                                    <div class="p-2">
                                        <p>3 Pencarian</p>
                                    </div>
                                    <div class="p-2">
                                        <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                data-target="#collapsArticle" aria-expanded="false"
                                                aria-controls="collapsArticle"></button>
                                    </div>
                                </div>
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
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsImplementRoll" aria-expanded="false"
                                        aria-controls="collapsImplementRoll"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsImplementRoll">
                            <div class="row d-flex justify-content-between">
                                <div class="col-6">
                                    <p style="font-size: medium; color: #0b2e13">1. TEMEN SIMPEDES</p>
                                </div>
                                <div class="col-2 align-items-end">
                                    <p style="font-size: medium; color: #0b2e13">3 Pencarian</p>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">2</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Piloting</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsImplementRoll" aria-expanded="false"
                                        aria-controls="collapsImplementRoll"></button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">3</p>
                            </div>
                            <div class="mr-auto p-2">
                                <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">Sosialisasi</p>
                            </div>
                            <div class="p-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="p-2">
                                <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsImplementRoll" aria-expanded="false"
                                        aria-controls="collapsImplementRoll"></button>
                            </div>
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
    <script src="{{asset_app('assets/js/script/index.js')}}"></script>
@endpush
