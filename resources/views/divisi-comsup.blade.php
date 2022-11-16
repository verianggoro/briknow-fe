@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
  <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/plugin/load/sklt-load.css')}}">
      <style>
        .kaki{
            bottom: 0px;
            position: fixed;
            display: block;
            width: 100%;
        }
        table{
            border-collapse:separate !important;
            border : solid rgba(0, 0, 0, 0.2) 1px;
            border-radius : 6px;
            -moz-border-radius : 6px;
            width:100%;
        }

        th{
            padding:0px;
            border-color: inherit;
            border-style: none !important;
            border-width: 0;
            border-bottom-width: 1px !important;
            font-weight : 500 !important;
        }
        td{
            padding:0px;
            border-bottom-width: 0px !important;
            border-top-width: 1px !important;
            color : #2F80ED;
            font-size : 13px;
            border: rgba(0, 0, 0, 0.2) solid 1px !important;
            border-right: none !important;
            border-left: none !important;
            border-bottom: none !important;
        }
    </style>
@endpush

@section('breadcumb', 'Divisi')
@section('back', route('katalog.index'))
@section('id_consultant', $data->id)
@section('content')
<div class="row judul">
  <div class="col-md-12 px-0 header-detail">
    <div class="row">
      <div class="col-md-12 mb-2">
          <h2 class="d-block">{{$data->divisi}}</h2>
        <div class="row">
          <div class="col-md-12">
              <span class="d-block">
                <strong>Direktorat : </strong>
                {{$data->direktorat == NULL ? 'Lainnya' : $data->direktorat}}
              </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row judul">
  <hr width="100%">
</div>
<div class="row judul">
    <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify">
        <div>
            <h6>Communication Initiative</h6>
            <div class="row">
                @forelse($dataComInit as $itemComInit)
                    <div class="col-md-6 col-sm-12 rowdoc">
                        <a href="{{route('mycomsupport.initiative.type', ['type'=> $itemComInit->type_file, 'slug'=>$itemComInit->slug])}}" style="text-decoration: none">
                            <div class="card border control list-project mb-2">
                                <div class="row px-3">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                        <div class="row d-flex justify-content-center">
                                            <img src="{{asset('storage/'.$itemComInit->thumbnail)}}" width="120%" class="thumb card-img-left border-0">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                        <div class="card-body content-project">
                                            <span class="d-block text-dark header-list-project mb-1">{{$itemComInit->title}}</span>
                                            <small>
                                                {{$itemComInit->type_file}}
                                            </small>
                                            <small class="d-block">{{$itemComInit->tanggal_upload}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-md-12 col-sm-12 rowdoc d-flex justify-content-center">
                        Tidak Ditemukan Communication Initiative
                    </div>
                @endforelse
            </div>
        </div>
        <div>
            <h6>Strategic Initiative</h6>
            <div class="row">
                @forelse($dataStra as $itemStra)
                    <div class="col-md-6 col-sm-12 rowdoc">
                        <a href="{{route('mycomsupport.strategic.type', ['slug'=>$itemStra->slug])}}" style="text-decoration: none">
                            <div class="card border control list-project mb-2">
                                <div class="row px-3">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                        <div class="row d-flex justify-content-center">
                                            <img src="{{asset('storage/'.$itemStra->thumbnail)}}" width="120%" class="thumb card-img-left border-0">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                        <div class="card-body content-project">
                                            <span class="d-block text-dark header-list-project mb-1">{{$itemStra->nama}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-md-12 col-sm-12 rowdoc d-flex justify-content-center">
                        Tidak Ditemukan Strategic Initiative
                    </div>
                @endforelse
            </div>
        </div>
        <div>
            <h6>Implementation</h6>
            <div class="row">
                @forelse($dataImpl as $itemImpl)
                    <div class="col-md-6 col-sm-12 rowdoc">
                        <a href="{{route('view.implement', ['slug'=>$itemImpl->slug])}}" style="text-decoration: none">
                            <div class="card border control list-project mb-2">
                                <div class="row px-3">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                        <div class="row d-flex justify-content-center">
                                            <img src="{{asset('storage/'.$itemImpl->thumbnail)}}" width="120%" class="thumb card-img-left border-0">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                        <div class="card-body content-project">
                                            <span class="d-block text-dark header-list-project mb-1">{{$itemImpl->title}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-md-12 col-sm-12 rowdoc d-flex justify-content-center">
                        Tidak Ditemukan Implementation
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
{{--  <script src="{{asset_app('assets/js/page/divisi.js')}}"></script>--}}
@endpush
