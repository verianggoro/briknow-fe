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

@section('breadcumb', 'My Project')
@section('back', route('home'))

@section('content')
    <div class="row judul">
        <div class="col-md-12 px-0 header-detail">
            <div class="row px-2">
                <div class="col md-12">
                    @if (session('role') != 0)
                        <h3>Pending Request</h3>
                    @else
                        <h3>My Project</h3>
                        <div class="d-flex bd-highlight">
                            <div class="mr-auto p-2 bd-highlight">
                                <div class="p-2 bd-highlight" id="drop-nama-proyek">
                                    <div class="dropdown show">
                                        <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                           data-toggle="modal" data-target="#modal-sort-nama" aria-haspopup="true" aria-expanded="false">
                                            Tahap Project
                                        </a>
                                    </div>
                                </div>
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
                    @endif
                </div>
                @if (Session::has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible show fade pb-1">
                            <div class="alert-body mb-2">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                <small>
                                    {!!session()->get('success')!!}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible show fade pb-1">
                            <div class="alert-body mb-2">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                <small>
                                    {!!session()->get('error')!!}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($data))
                    <div class="table-responsive">
                        <table class="table table-main">
                            <thead class="thead-light">
                            <tr>
                                <th style="border-left: 1px solid rgb(245 245 245); border-top-left-radius: 12px;">Direktorat</th>
                                <th style="width: 200px;">Unit Kerja</th>
                                <th>Nama Project</th>
                                <th>Konsultan/Vendor</th>
                                <th>Lesson Learned</th>
                                <th>Keterangan</th>
                                <th style="border-right: 1px solid rgb(245 245 245); border-top-right-radius: 12px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = ($data->current_page * 10)-9;
                            @endphp
                            @forelse ($data->data as $item)
                                <tr class="py-2">
                                    <td class="corner-left">{{$item->direktorat}}</td>
                                    <td>{{$item->divisi}}</td>
                                    <td>{{$item->project_name}}</td>
                                    <td>{{$item->consultant_name}}</td>
                                    <td>{{$item->lesson_learned}}</td>
                                    <td>{{$item->detail}}</td>
                                    <td class="corner-right">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn dropdown-item">
                                                    <i class="fa fa-share-alt mr-2"></i>
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn dropdown-item">
                                                    <i class="fa fa-star mr-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="py-2">
                                    <td class="corner-left corner-right" colspan="9">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                @elseif(!Session::has('error'))
                    <div class="col-md-12 pt-2">
                        <span>Anda belum memiliki project.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
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
@endsection

@push('page-script')
    <script>
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    </script>
@endpush
