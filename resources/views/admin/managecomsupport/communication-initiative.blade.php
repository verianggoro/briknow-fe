@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
@endpush
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<!--<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table-locale-all.min.js"></script>-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css">

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Communication Support</h3>

        <div class="my-4 d-flex align-content-between">
            <div class="d-flex mr-auto ml-2 flex-wrap">
                <a class="btn-com mt-2 mr-3 active disabled" id="communication" role="button">Communication Initiative</a>
                <a class="btn-com mt-2 mr-3" id="strategic" role="button">Strategic Initiative</a>
                <a class="btn-com mt-2 mr-3" id="implementation" role="button">Implementation</a>
            </div>
            <div class="mr-2" style="margin-top: auto">
                <button type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success"><i class="fa fa-plus mr-3"></i>Upload</button>
            </div>
        </div>

        <hr/>

        <div class="mt-4 mb-2 d-flex mx-auto flex-wrap">
            @forelse($type_list as $item)
            @php ($id = request()->path() == $item['path'] ? $item['id'] : 'artikel')
            <a href="{{route('manage_com.type', ['type'=>$item['id']])}}"  id="{{$item['id']}}" role="button"
               class="btn-com mt-2 mr-3 {{request()->path() == $item['path']  ? ' active disabled' : ''}}">{{$item['name']}}</a>
            @empty
            @endforelse
        </div>

        @php ($url = config('app.url')."communicationinitiative/".$id)
        <!-- NAVIGASI -->
        <div class="d-flex bd-highlight">
            <div class="mr-auto p-2 bd-highlight">
<!--                <h3>{{config('app.url')."communicationinitiative/".$id}}</h3>-->
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
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control" id="inlineFormInputGroup" placeholder="Cari artikel">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;"><i class="fa fa-search fa-sm" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
                <!--<div class="d-flex px-4">
                    <div style="font-size: 12px">
                        Sync Elastic :
                        @if($sync_es == 0)
                        <span class="text-success">Done</span>
                        @else
                        <span class="text-warning">
                    <i class="fa fa-sync fa-spin mr-1" aria-hidden="true" style="font-size:12px"></i>
                    {{-- {{ $sync_es }} Project Remaining --}}
                    Processing . .
                  </span>
                        @endif
                    </div>
                </div>-->
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
</div>
<input type="hidden" value="{{session('personal_number')}}" id="userNumber">
@endsection
<!--@section('popup')
{{-- preview --}}
<div class="modal fade bd-example-modal-lg modal-preview" id="modalpreview" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100 content-preview">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection-->
@push('page-script')
<script>
    localStorage.clear();
</script>\
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset_app('assets/js/page/comsupport.js')}}"></script>

@endpush
