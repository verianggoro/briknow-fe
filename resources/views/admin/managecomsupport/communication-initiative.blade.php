@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{ asset_app('assets/css/fa.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/select2-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/bootstrap-table.min.css') }}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Communication Support</h3>

        <div class="my-4 d-flex align-content-between">
            <div class="d-flex mr-auto ml-2 flex-wrap">
                <a class="btn-com mt-2 mr-3 active disabled" id="communication" role="button">Communication Initiative</a>
                <a href="{{route('manage_com.strategic')}}" class="btn-com mt-2 mr-3" id="strategic" role="button">Strategic Initiative</a>
                <a href="{{route('manage_com.implementation')}}" class="btn-com mt-2 mr-3" id="implementation" role="button">Implementation</a>
            </div>
            <div class="mr-2" style="margin-top: auto">
                <a href="{{route('manage_com.upload_form', ['type'=>'content'])}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success"><i class="fa fa-plus mr-3"></i>Upload</a>
            </div>
        </div>

        <hr/>

        <div class="mt-4 mb-2 d-flex mx-auto flex-wrap">
            @forelse($type_list as $item)
            @if(request()->path() == $item['path'])
                @php ($type_name = $item['name'])
            @endif
            <a href="{{route('com_init.type', ['type'=>$item['id']])}}"  id="{{$item['id']}}" role="button"
               class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">{{$item['name']}}</a>
            @empty
            @endforelse
        </div>

        <!-- NAVIGASI -->
        <div class="d-flex bd-highlight">
            <div class="mr-auto p-2 bd-highlight">
            </div>
        </div>
        <!-- NAVIGASI -->

        @include('layouts.alert')

        <!-- REVIEW -->
        <div class="table-responsive" style="border-radius: 12px; background: white; padding-bottom: 3rem" id="review">
            <div class="p-3">
                <div class="col-auto" style="width: 35%">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <div class="input-group mb-2">
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control" id="inlineFormInputGroup" placeholder="Cari {{$type_name}}">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;"><i class="fa fa-search fa-sm" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <table
                    id="table"
                    data-show-columns-toggle-all="true"
                    data-search="true"
                    data-search-selector="#inlineFormInputGroup"
                    data-click-to-select="true"
                    data-minimum-count-columns="2"
                    data-pagination="true"
                    data-id-field="id"
                    data-page-list="[10, 25, 50, 100, all]"
                    data-side-pagination="server"
                    data-ajax="ajaxRequest"
                    data-response-handler="responseHandler">
            </table>
        </div>
    </div>
        <!-- REVIEW -->
</div>
@endsection
@section('popup')
<div class="modal fade bd-example-modal-lg modal-preview" id="modal-preview-1" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100" id="content-preview-desc">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
<script>
    localStorage.clear();
</script>
<script src="{{ asset_app('assets/js/plugin/bootstrap-table.min.js') }}"></script>
<script src="{{ asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset_app('assets/js/page/cominitiative.js') }}"></script>

@endpush
