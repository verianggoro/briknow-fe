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
            <h3 class="pl-2 pt-5">Communication Initiative</h3>

            <div class="mt-4 mb-2 d-flex mx-auto flex-wrap">
                @forelse($type_list as $item)
                    @if(request()->path() == $item['path'])
                        @php ($type_name = $item['name'])
                    @endif
                    <a href="{{route('mycomsupport.initiative.type', ['type'=>$item['id']])}}"  id="{{$item['id']}}" role="button"
                       class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">{{$item['name']}}</a>
                @empty
                @endforelse
            </div>
            <hr/>
            <div class="d-flex justify-content-between">
                <div class="col-lg-4">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <div class="input-group mb-2">
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control"
                               id="inlineFormInputGroup" placeholder="Cari...">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;"><i
                                        class="fa fa-search fa-sm" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
                <div class="align-self-end">
                    <div class="dropdown">
                        <button data-toggle="dropdown" class="btn btn-outline-secondary bg-white dropdown-toggle">
                            Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Judul</a>
                            <a class="dropdown-item" href="#">Tanggal</a>
                            <a class="dropdown-item" href="#">Terbanyak</a>
                        </ul>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-lg-4 d-flex justify-content-center">
                    <a href="{{route('view.comsup')}}" target="_blank">
                        <div class="card" style="border-radius: 16px">
                            <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <div class="d-flex justify-content-between">
                                    <i class="mr-auto p-2 fas fa-eye">
                                        <span>1</span>
                                    </i>
                                    <button class="btn fas fa-download p-2" style="font-size: 20px"></button>
                                    <button class="btn fas fa-share-square p-2" style="font-size: 20px"></button>
                                    <button class="btn fas fa-heart p-2" style="font-size: 20px"></button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="card" style="border-radius: 16px">
                        <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <div class="d-flex justify-content-between">
                                <i class="mr-auto p-2 fas fa-eye">
                                    <span>1</span>
                                </i>
                                <button class="btn fas fa-download p-2" style="font-size: 20px"></button>
                                <button class="btn fas fa-share-square p-2" style="font-size: 20px"></button>
                                <button class="btn fas fa-heart p-2" style="font-size: 20px"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="card" style="border-radius: 16px">
                        <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <div class="d-flex justify-content-between">
                                <i class="mr-auto p-2 fas fa-eye">
                                    <span>1</span>
                                </i>
                                <button class="btn fas fa-download p-2" style="font-size: 20px"></button>
                                <button class="btn fas fa-share-square p-2" style="font-size: 20px"></button>
                                <button class="btn fas fa-heart p-2" style="font-size: 20px"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex justify-content-center">
                    <div class="card" style="border-radius: 16px">
                        <img class="card-img-up" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <div class="d-flex justify-content-between">
                                <i class="mr-auto p-2 fas fa-eye">
                                    <span>1</span>
                                </i>
                                <button class="btn fas fa-download p-2" style="font-size: 20px"></button>
                                <button class="btn fas fa-share-square p-2" style="font-size: 20px"></button>
                                <button class="btn fas fa-heart p-2" style="font-size: 20px"></button>
                            </div>
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
