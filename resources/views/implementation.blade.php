@extends('layouts.communication_support_dashboard', ['direktorat' => $direktorat])
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
            <h3 class="pl-2 pt-5">Implementation</h3>
            <div class="mt-4 mb-2 d-flex mx-auto flex-wrap">
                <div class="mr-auto p-2">
                @forelse($type_list as $item)
                    @if(request()->path() == $item['path'])
                        @php ($type_name = $item['name'])
                    @endif
                    <a href="{{route('mycomsupport.implementation.type', ['type'=>$item['id']])}}"  id="{{$item['id']}}" role="button"
                       class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">{{$item['name']}}</a>
                @empty
                @endforelse
                </div>
                <div class="p-2" style="margin-top: auto">
                    <a href="{{route('kontribusi')}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success"><i class="fa fa-plus mr-3"></i>Upload</a>
                </div>
            </div>
            <hr/>
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
            <br/>
            <div class="row">
                @if(empty($data))
                    <div class="container-fluid">
                        <div class="p-2">
                            <p class="w-100 text-center font-weight-600 font-italic">Tidak Ada Data</p>
                        </div>
                    </div>
                @else
                    @foreach($data as $content)
                        <div class="container-fluid">
                            <a href="{{route('view.implement', $content->slug)}}">
                                <div class="card d-flex w-100 p-2" style="border-radius: 16px; width: 30rem">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <img class="card-img" style="height: auto; width: 15rem" src="{{asset('storage/'.$content->thumbnail)}}" alt="Card image cap">
                                        </div>
                                        <div class="col-lg-10">
                                            <h4>{{$content->title}}</h4>
                                            @if(str_contains(request()->path(), 'piloting'))
                                                <div style="background-color: #0a53be; border-radius: 10px;">
                                                    <p class="text-white m-2">PILOTING</p>
                                                </div>
                                                {!! \Illuminate\Support\Str::limit($content->desc_piloting, 200, '... Baca Selengkapnya') !!}
                                            @elseif(str_contains(request()->path(), 'roll-out'))
                                                <div style="background-color: #0a53be; border-radius: 10px;">
                                                    <p class="text-white m-2">ROLLOUT</p>
                                                </div>
                                                {!! \Illuminate\Support\Str::limit($content->desc_roll_out, 200, '... Baca Selengkapnya') !!}
                                            @elseif(str_contains(request()->path(), 'sosialisasi'))
                                                <div style="background-color: #0a53be; border-radius: 10px;">
                                                    <p class="text-white m-2">SOSIALISASI</p>
                                                </div>
                                                {!! \Illuminate\Support\Str::limit($content->desc_sosialisasi, 200, '... Baca Selengkapnya') !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex p-2 justify-content-end">
                                        <div class="row">
                                            <p class="pr-2 fas fa-eye" style="font-size: 23px; margin-bottom: 0px; margin-top: 0px">
                                                <span>{{$content->views}}</span>
                                            </p>
                                            <button class="btn fas fa-download pr-2" style="font-size: 20px"></button>
                                            <button class="btn fas fa-share-square pr-2"
                                                    style="font-size: 20px"></button>
                                            <button class="btn fas fa-heart" style="font-size: 20px"></button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
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
