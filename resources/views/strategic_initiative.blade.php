@extends('layouts.communication_support_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('katalog.index'))

@section('content')

    <div class="row mx-0">
        <div class="col-md-12" id="konten">
            <h3 class="pl-2 pt-5">Strategic Initiative</h3>
            <div class="d-flex justify-content-between mt-3">
                <div class="mr-auto p-2">
                    <div class="dropdown">
                        <button data-toggle="dropdown" class="btn btn-outline-secondary bg-white dropdown-toggle">
                            Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-left">
                            <a class="dropdown-item" href="#">Judul</a>
                            <a class="dropdown-item" href="#">Tanggal</a>
                            <a class="dropdown-item" href="#">Terbanyak</a>
                        </ul>
                    </div>
                </div>
                <div class="p-2">
                    <div class="dropdown">
                        <button data-toggle="dropdown" class="btn btn-outline-secondary bg-white dropdown-toggle">
                            Implementation
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Rollout</a>
                            <a class="dropdown-item" href="#">Piloting</a>
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
            <br/>
            <div class="row">
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="card" style="border-radius: 16px; width: 30rem">
                        <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title text-center">Teman Simpedes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="card" style="border-radius: 16px; width: 30rem">
                        <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title text-center">BRIBOX</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="card" style="border-radius: 16px; width: 30rem">
                        <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title text-center">Agen BRI Digital</h5>
                        </div>
                    </div>
                </div>
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
