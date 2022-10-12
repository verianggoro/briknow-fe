@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <style>
        #waow{
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
                <a href="{{route('dashboard.performance')}}" class="btn btn-outline-primary mt-2 mr-3" id="performance" role="button">Performance</a>
                <a href="{{route('dashboard.alldata')}}" class="btn btn-outline-primary mt-2 mr-3" id="alldata" role="button">All Data</a>
                <a href="{{route('dashboard.comsuport')}}" class="btn btn-outline-primary mt-2 mr-3 active" id="comsuport" role="button">Communication Suppport</a>
            </div>

            <div class="row">
                <div class="container-fluid">
                    <div class="card d-flex w-100 p-3">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <h4>Communication Initiative Analytics</h4>
                            </div>
                            <div class="col-2">
                                <div class="btn btn-outline-secondary">
                                    <div class="fa fa-download"></div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Article</p>
                            </div>
                            <div class="col-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsArticle">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p>View Terbanyak</p>
                                </div>
                                <div class="col-6">
                                    <p>Download Terbanyak</p>
                                </div>
                            </div>
{{--                            foreach--}}
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <div class="row p-3 align-items-center">
                                        <img class="card-img mr-3" style="height: auto; width: 4rem" src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}" alt="Card image cap">
                                        <p class="mr-5 ">CONTENT IG</p>
                                        <div class="fa fa-eye">
                                            <span>1</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row p-3 align-items-center">
                                        <img class="card-img mr-3" style="height: auto; width: 4rem" src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}" alt="Card image cap">
                                        <p class="mr-5 ">TEST</p>
                                        <div class="fa fa-download">
                                            <span>1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                        ----------------}}
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Video Content</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Instagram Content</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Podcast</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Poster</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Infographic</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Transformation</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Logo</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsArticle" aria-expanded="false" aria-controls="collapsArticle"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="container-fluid">
                    <div class="card d-flex w-100 p-3">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <h4>Strategic Initiative Analytics</h4>
                            </div>
                            <div class="col-2">
                                <div class="btn btn-outline-secondary">
                                    <div class="fa fa-download"></div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Test</p>
                            </div>
                            <div class="col-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsStrategic" aria-expanded="false" aria-controls="collapsStrategic"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsStrategic">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <p>View Terbanyak</p>
                                </div>
                                <div class="col-6">
                                    <p>Download Terbanyak</p>
                                </div>
                            </div>
                            {{--                            foreach--}}
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <div class="row p-3 align-items-center">
                                        <img class="card-img mr-3" style="height: auto; width: 4rem" src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}" alt="Card image cap">
                                        <p class="mr-5 ">CONTENT IG</p>
                                        <div class="fa fa-eye">
                                            <span>1</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row p-3 align-items-center">
                                        <img class="card-img mr-3" style="height: auto; width: 4rem" src="{{asset('storage/document/thumbnail/633547ec7b6a7-1664436204/tesst_bri.png')}}" alt="Card image cap">
                                        <p class="mr-5 ">TEST</p>
                                        <div class="fa fa-download">
                                            <span>1</span>
                                        </div>
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
                            <div class="col-6">
                                <h4>Implementation Analytics</h4>
                            </div>
                            <div class="col-2">
                                <div class="btn btn-outline-secondary">
                                    <div class="fa fa-download"></div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Roll Out</p>
                            </div>
                            <div class="col-2">
                                <p>3 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsImplementRoll" aria-expanded="false" aria-controls="collapsImplementRoll"></button>
                            </div>
                        </div>
                        <div class="collapse" id="collapsImplementRoll">
                            {{--                            foreach--}}
                            <div class="row ml-2 justify-content-start">
                                <div class="w-100">
                                    <div class="row p-3 align-items-center">
                                        <p class="col-6 mr-5 ">test</p>
                                        <p> 3 Pencarian</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Piloting</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsStrategic" aria-expanded="false" aria-controls="collapsStrategic"></button>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <p class="font-weight-bold">Sosialisasi</p>
                            </div>
                            <div class="col-2">
                                <p>0 Pencarian</p>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsStrategic" aria-expanded="false" aria-controls="collapsStrategic"></button>
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
    <script src="{{asset_app('assets/js/core.js')}}" ></script>
    <script src="{{asset_app('assets/js/charts.js')}}" ></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}" ></script>
    <script src="{{asset_app('assets/js/script/index.js')}}"></script>
@endpush
