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
{{--@section('id_consultant', $data->id)--}}
@section('content')
<div class="row judul">
  <div class="col-md-12 px-0 header-detail">
    <div class="row">
      <div class="col-md-12 mb-2">
          <h2 class="d-block">{{'Direktorat : '.$data[0]->direktorat}}</h2>
        <div class="row">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row judul">
  <hr width="100%">
</div>
<div class="row judul">
    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
        <div class="row">
            <h5 class="font-weight-bolder">Divisi</h5>
        </div>
        <div class="row">
            <div class="row col-md-12 mt-2">
                @foreach ($data as $itemDivisi)
                    <div class="col-md-10 col-sm-6">
                        <p>{{$itemDivisi->divisi}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify">
        <div>
            <h6>Communication Initiative</h6>
            <div class="row">
                @for($init = 0; $init < sizeof($dataComInit); $init++)
                    @if(!empty($dataComInit[$init]))
                        @for($initTwo=0; $initTwo < sizeof($dataComInit[$init]); $initTwo++)
                            <div class="col-md-6 col-sm-12 rowdoc">
                                <a href="{{route('mycomsupport.initiative.type', ['type'=> $dataComInit[$init][$initTwo]->type_file, 'slug'=>$dataComInit[$init][$initTwo]->slug])}}" style="text-decoration: none">
                                    <div class="card border control list-project mb-2">
                                        <div class="row px-3">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                                <div class="row d-flex justify-content-center">
                                                    <img src="{{asset('storage/'.$dataComInit[$init][$initTwo]->thumbnail)}}" width="120%" class="thumb card-img-left border-0">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                                <div class="card-body content-project">
                                                    <span class="d-block text-dark header-list-project mb-1">{{$dataComInit[$init][$initTwo]->title}}</span>
                                                    <small>
                                                        {{$dataComInit[$init][$initTwo]->type_file}}
                                                    </small>
                                                    <small class="d-block">{{$dataComInit[$init][$initTwo]->tanggal_upload}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endfor
                    @endif
                @endfor
            </div>
        </div>
        <div>
            <h6>Strategic Initiative</h6>
            <div class="row">
                @for($istra = 0; $istra < sizeof($dataStra); $istra++)
                    @if(!empty($dataStra[$istra]))
                        @for($straTwo=0; $straTwo < sizeof($dataStra[$istra]); $straTwo++)
                            <div class="col-md-6 col-sm-12 rowdoc">
                                <a href="{{route('mycomsupport.strategic.type', ['slug'=>$dataStra[$istra][$straTwo]->slug])}}" style="text-decoration: none">
                                    <div class="card border control list-project mb-2">
                                        <div class="row px-3">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                                <div class="row d-flex justify-content-center">
                                                    <img src="{{asset('storage/'.$dataStra[$istra][$straTwo]->thumbnail)}}" width="120%" class="thumb card-img-left border-0">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                                <div class="card-body content-project">
                                                    <span class="d-block text-dark header-list-project mb-1">{{$dataStra[$istra][$straTwo]->nama}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endfor
                    @endif
                @endfor
            </div>
        </div>
        <div>
            <h6>Implementation</h6>
            <div class="row">
                @for($iimpl = 0; $iimpl < sizeof($dataImpl); $iimpl++)
                    @if(!empty($dataImpl[$iimpl]))
                        @for($implTwo=0; $implTwo < sizeof($dataImpl[$iimpl]); $implTwo++)
                            <div class="col-md-6 col-sm-12 rowdoc">
                                <a href="{{route('view.implement', ['slug'=>$dataImpl[$iimpl][$implTwo]->slug])}}" style="text-decoration: none">
                                    <div class="card border control list-project mb-2">
                                        <div class="row px-3">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                                <div class="row d-flex justify-content-center">
                                                    <img src="{{asset('storage/'.$dataImpl[$iimpl][$implTwo]->thumbnail)}}" width="120%" class="thumb card-img-left border-0">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                                <div class="card-body content-project">
                                                    <span class="d-block text-dark header-list-project mb-1">{{$dataImpl[$iimpl][$implTwo]->title}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endfor
                    @endif
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
{{--  <script src="{{asset_app('assets/js/page/divisi.js')}}"></script>--}}
@endpush
