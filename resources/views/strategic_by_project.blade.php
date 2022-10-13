@extends('layouts.communication_support_dashboard', ['direktorat' => $direktorat, 'divisiRes' => $divisiRes])
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
            <h3 class="pl-2 pt-5">{{!empty($data->nama)?$data->nama:"-"}}</h3>
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
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Articles</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'article')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                    <div class="col-2 justify-content-center">
                                        <a href="{{route('mycomsupport.strategic.type.content', [$data->slug, 'article'])}}">
                                            <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                                <div class="fa fa-arrow-alt-circle-right mt-5">
                                                </div>
                                                <span>Lihat Semua</span>
                                            </div>
                                        </a>
                                    </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse
                </div>
            </div>
            <hr/>
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Video Content</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'video')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="col-2 justify-content-center">
                                    <a href="#">
                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                            </div>
                                            <span>Lihat Semua</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse

                </div>
            </div>
            <hr/>
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Podcast</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'podcast')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="col-2 justify-content-center">
                                    <a href="#">
                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                            </div>
                                            <span>Lihat Semua</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse
                </div>
            </div>
            <hr/>
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Instagram</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'instagram')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="col-2 justify-content-center">
                                    <a href="#">
                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                            </div>
                                            <span>Lihat Semua</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse
                </div>
            </div>
            <hr/>
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Transformation</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'transformation')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="col-2 justify-content-center">
                                    <a href="{{route('mycomsupport.strategic.type.content', [$data->slug, 'article'])}}">
                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                            </div>
                                            <span>Lihat Semua</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse
                </div>
            </div>
            <hr/>
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Logo</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'logo')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="col-2 justify-content-center">
                                    <a href="#">
                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                            </div>
                                            <span>Lihat Semua</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse
                </div>
            </div>
            <hr/>
            <div class="d-flex">
                <div class="row">
                    <div class="col-12">
                        <h4>Infographics</h4>
                    </div>
                    @forelse($content as $values)
                        @if($values->id === 'infographics')
                            <div class="col-12">
                                <p>{{$values->total_data}}</p>
                            </div>
                            @if(!empty($values->data))
                                @foreach($values->data as $contentData)
                                    <div class="col-2 justify-content-center">
                                        <a href="#">
                                            <div class="card h-100" style="border-radius: 16px">
                                                <img class="img-fluid" src="{{asset('storage/'.$contentData->thumbnail)}}"
                                                     alt="Card image cap">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="col-2 justify-content-center">
                                    <a href="#">
                                        <div class="card align-items-center h-100 d-flex justify-content-center" style="border-radius: 16px">
                                            <div class="fa fa-arrow-alt-circle-right mt-5">
                                            </div>
                                            <span>Lihat Semua</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @empty
                        Empty
                    @endforelse
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
