@extends('layouts.communication_support_dashboard', ['direktorat' => $direktorat])
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
@endpush

@section('breadcumb', 'Strategic')
@section('back', route('katalog.index'))

@section('content')
    <div class="row mx-0">
        <div class="col-md-12" id="konten">
            <h3 class="pl-2 pt-5">{{$slug}}</h3>
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
            <div class="row">
                <div class="col-12">
                    <h4>{{$type}}</h4>
                </div>
                @forelse($data as $content)
                    <div class="col-lg-4 d-flex justify-content-center">
                        <a href="#" target="_blank" style="width: inherit">
                            <div class="card" style="border-radius: 16px;">
                                <img class="card-img-up"
                                     src="{{asset('storage/'.$content->thumbnail)}}"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{$content->title}}</h5>
                                    <div class="d-flex justify-content-between">
                                        <i class="mr-auto p-2 fas fa-eye">
                                            <span>{{$content->views}}</span>
                                        </i>
                                        <button class="btn fas fa-download p-2" style="font-size: 20px"></button>
                                        <button class="btn fas fa-share-square p-2"
                                                style="font-size: 20px"></button>
                                        <button class="btn fas fa-heart p-2" style="font-size: 20px"></button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    EMPTY
                @endforelse
            </div>
        </div>
    </div>
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/core.js')}}" ></script>
    <script src="{{asset_app('assets/js/charts.js')}}" ></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}" ></script>
    <script src="{{asset_app('assets/js/script/index.js')}}"></script>
@endpush
