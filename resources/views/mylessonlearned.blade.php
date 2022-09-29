@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/my_project.css')}}">

@endpush

@push('page-script')
    <script src="{{asset_app('assets/js/page/mproject.js')}}"></script>
@endpush

@section('breadcumb', 'My Lesson Learned')
@section('back', route('home'))

@section('content')
    <div class="row">
        <div class="col-md-12" id="konten">
            <h3 class="pl-2 pt-5">Manage Lesson Learned</h3>
            <div class="d-flex justify-content-start mb-3 px-3">
                <div class="p-2 bd-highlight" id="drop-nama-proyek">
                    <div class="dropdown show">
                        <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="modal" data-target="#modal-sort-nama" aria-haspopup="true" aria-expanded="false">
                            Tahap Project
                        </a>
                    </div>
                </div>
            </div>
            <!-- NAVIGASI -->
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                    <h4>Development</h4>
                </div>
                <!-- Dropdowns TEMP -->

                <!-- Dropdowns TEMP -->

                <!-- Dropdowns -->
                <div class="p-2 bd-highlight" id="drop-nama-proyek">
                    <div class="dropdown show">
                        <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="modal" data-target="#modal-sort-nama" aria-haspopup="true" aria-expanded="false">
                            Direktorat
                        </a>
                    </div>
                </div>
                <div class="p-2 bd-highlight" id="drop-pemilik">
                    <div class="dropdown show">
                        <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="modal" data-target="#modal-sort-pemilik" aria-haspopup="true" aria-expanded="false">
                            Unit Kerja
                        </a>
                    </div>
                </div>
                <!-- Dropdowns -->

                <!-- Search -->
                <div class="p-2 bd-highlight" id="search">
                    <form action="#" class="w-100" id="search">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text" id="search">
                                        <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                                    </span>
                            </div>
                            <input type="text" class="form-control form-control-sm" placeholder="Search Lesson..." aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </form>
                </div>
                <!-- Search -->
            </div>
{{--            <div class="d-flex justify-content-end mb-3 px-3">--}}
{{--                <div>--}}
{{--                    Sync Elastic :--}}
{{--                    @if($sync_es == 0)--}}
{{--                        <span class="text-success">Done</span>--}}
{{--                    @else--}}
{{--                        <span class="text-warning">--}}
{{--                    <i class="fa fa-sync fa-spin mr-1" aria-hidden="true" style="font-size:12px"></i>--}}
{{--                    --}}{{-- {{ $sync_es }} Project Remaining --}}
{{--                    Processing . .--}}
{{--                  </span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- NAVIGASI -->

            @include('layouts.alert')

            <!-- REVIEW -->
            <div class="table-responsive" id="review">
                <div class="card card-body w-100 d-flex mb-4" style="border-radius: 10px">
                    <div class="row">
                        <div class="col-2">
                            <h6>Direktorat</h6>
                        </div>
                        <div class="col-3">
                            <h6>Uker</h6>
                        </div>
                        <div class="col-3">
                            <h6>Nama Project</h6>
                        </div>
                        <div class="col-2">
                            <h6>Konsultan</h6>
                        </div>
                        <div class="col-2">
                            <h6>Action</h6>
                        </div>
                    </div>
                </div>
                {{--                for each--}}
                <div class="card card-body w-100 d-flex mb-1" style="border-radius: 10px">
                    <div class="row">
                        <div class="col-2">
                            <p class="text-primary">Satuan Kerja Audit Intern</p>
                        </div>
                        <div class="col-3">
                            <p class="text-primary">Micro Business Development Division</p>
                        </div>
                        <div class="col-3">
                            <p>Fraud Risk Indicator Framework</p>
                        </div>
                        <div class="col-2">
                            <p class="text-primary">Deloitte</p>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-outline-secondary fas fa-share"></button>
                            <button class="btn btn-outline-secondary fas fa-arrow-down" data-toggle="collapse" data-target="#collapsData" aria-expanded="false" aria-controls="collapsData"></button>
                        </div>
                    </div>
                    <div class="collapse" id="collapsData">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h6>Lesson Learned</h6>
                                </div>
                                <div class="col-8">
                                    <h6>Keterangan</h6>
                                </div>
                            </div>
                            <hr/>
                            {{--                            for each--}}
                            <div class="row">
                                <div class="col-4">
                                    <p>Pemulihan Data</p>
                                </div>
                                <div class="col-8">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-sm-end content-pagination" id="pag">
                </div>
            </div>
            <!-- REVIEW -->
        </div>
    </div>

@endsection

@push('page-script')
    <script>
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    </script>
@endpush
