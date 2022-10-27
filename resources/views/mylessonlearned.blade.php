@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/my_project.css')}}">

@endpush

@section('breadcumb', 'My Lesson Learned')
@section('back', route('home'))

@section('content')
    <div class="row">
        <div class="col-md-12" id="konten">
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                    <h3>Manage Lesson Learned</h3>
                </div>
                <div class="p-2 bd-highlight">
                    <button id="btn-sort-lesson" data-toggle="dropdown"
                            class="btn btn-outline-secondary bg-white dropdown-toggle">
                        Tahap Proyek
                    </button>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <li onclick="sortByTahap('sortInitLesson')" id="sortInitLesson" data-value="init"
                            class="dropdown-item">Tahap Proyek
                        </li>
                        <li onclick="sortByTahap('planSort')" id="planSort" data-value="plan" class="dropdown-item">
                            Plan
                        </li>
                        <li onclick="sortByTahap('procurementSort')" id="procurementSort" data-value="procurement"
                            class="dropdown-item">Procurement
                        </li>
                        <li onclick="sortByTahap('devSort')" id="devSort" data-value="development"
                            class="dropdown-item">Development
                        </li>
                        <li onclick="sortByTahap('pilotSort')" id="pilotSort" data-value="pilot" class="dropdown-item">
                            Pilot Run
                        </li>
                        <li onclick="sortByTahap('implSort')" id="implSort" data-value="implementation"
                            class="dropdown-item">Implementation
                        </li>
                    </ul>
                </div>
                <div class="p-2 bd-highlight bd-highlight" style="width: 15%">
                    <div class="d-flex justify-content-end">
                        <select name="direktorat" id="direktorat-lesson-init" class="form-control text-black select2" data-live-search="true"
                                style="height: 44px" value="{{old('direktorat')}}">
                            <option value="" disabled selected>Pilih Direktorat</option>
                            @if(empty($direktorat))
                                <option value="finance" data-value="finance">{{$dataList ?? 'NOT FOUND'}}</option>
                            @else
                                @foreach($direktorat as $dirContent)
                                    <option value="{{$dirContent->direktorat }}" data-value="{{ $dirContent->direktorat }}">{{$dirContent->direktorat}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="p-2 bd-highlight bd-highlight" style="width: 15%">
                    <div class="d-flex justify-content-end">
                        <select id="divisi-lesson-init" class="mr-auto p-2 form-control select2" value="{{old('divisi')}}" name="divisi[]"></select>
                    </div>
                </div>
            </div>
            <!-- NAVIGASI -->
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                    <h4 id="main-title-lesson">All</h4>
                </div>

                <div class="p-2 bd-highlight" id="search">
                    <div class="input-group w-100">
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control"
                               id="searchLessoninit" placeholder="Cari...">
                        <div class="input-group-prepend">
                            <div onclick="searchLesson()" class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;">
                                <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <div id="container-review">
                    @forelse($data as $value)
                        <div class="card card-body w-100 d-flex mb-1" style="border-radius: 10px">
                            <div class="row">
                                <div class="col-2">
                                    <a href="/katalog" class="text-primary">{{$value->divisi->direktorat}}</a>
                                </div>
                                <div class="col-3">
                                    <a href="/katalog" class="text-primary">{{$value->divisi->divisi}}</a>
                                </div>
                                <div class="col-3">
                                    <p>{{$value->nama}}</p>
                                </div>
                                @forelse($value->consultant as $consultValue)
                                    <div class="col-2">
                                        <p class="text-primary">{{$consultValue->nama}}</p>
                                    </div>
                                @empty
                                    <div class="col-2">
                                        <p class="text-primary">-</p>
                                    </div>
                                @endforelse
                                <div class="col-2">
                                    <a href="{{route('kontribusi.edit', $value->slug)}}" class="btn btn-outline-secondary fas fa-pen"></a>
                                    <button class="btn btn-outline-secondary fas fa-trash"></button>
                                    @if(!empty($value->lesson_learned))
                                        <button class="btn btn-outline-secondary fas fa-caret-down" data-toggle="collapse" href="#{{trim($value->nama)}}" aria-expanded="false" aria-controls="{{trim($value->nama)}}"></button>
                                    @endif
                                </div>
                            </div>
                            <div class="collapse" id="{{trim($value->nama)}}">
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
                                    @forelse($value->lesson_learned as $lessonLearned)
                                        <div class="row">
                                            <div class="col-4">
                                                <p>{{$lessonLearned->lesson_learned}}</p>
                                            </div>
                                            <div class="col-8">
                                                <p>{{$lessonLearned->detail}}</p>
                                            </div>
                                        </div>
                                        <hr/>
                                    @empty
                                        EMPTY
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty
                        EMPTY
                    @endforelse
                </div>
                <div class="d-flex justify-content-sm-end content-pagination" id="pag">
                </div>
            </div>
            <!-- REVIEW -->
        </div>
    </div>

@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/review-lesson.js')}}"></script>
@endpush
