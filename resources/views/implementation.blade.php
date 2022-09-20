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
                    <a href="{{route('com_init.upload', ['slug'=>'communicationinitiative'])}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success"><i class="fa fa-plus mr-3"></i>Upload</a>
                </div>
            </div>
            <hr/>
        </div>
    </div>

@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/core.js')}}" ></script>
    <script src="{{asset_app('assets/js/charts.js')}}" ></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}" ></script>
    <script src="{{asset_app('assets/js/script/index.js')}}"></script>
@endpush
