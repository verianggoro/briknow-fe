@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
  <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/plugin/load/sklt-load.css')}}">
  <link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
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

@section('breadcumb', 'Direktorat')
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
            <div class="mt-4 mb-2 d-flex mx-auto flex-wrap">
                <a onclick="getDataComsupDiv()" id="cominit-div" role="button"
                   class="btn-com mt-2 mr-3 active ">Communication Initiative</a>
                <a onclick="getDataStraDiv()"  id="strategic-div" role="button"
                   class="btn-com mt-2 mr-3 ">Strategic Initiative</a>
                <a onclick="getDataImpl()"  id="implement-div" role="button"
                   class="btn-com mt-2 mr-3 ">Implementation</a>
            </div>
        </div>
        <div>
            <div class="input-group mb-2 h-100">
                <input type="text" style="width:20rem; border-radius: 8px 0 0 8px; border-color: #f0f0f0; border-style: solid;padding-left: 12px;border-right: none"
                       id="searchCominit" placeholder="Cari...">
                <div class="input-group-prepend">
                    <div onclick="" class="d-flex align-items-center justify-content-center" style="cursor:pointer;width:2rem; background: #f0f0f0; border-radius: 0 8px 8px 0;">
                        <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
        <div id="container-cominit-div">
            @if($from === 'cominit')
                <h6>Artikel</h6>
            @elseif($from === 'strategic')
                <h6>Strategic Initiative</h6>
            @elseif($from === 'implementation')
                <h6>Implementation</h6>
            @endif
            <div class="row" id="row-cominit-div"></div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/page/direktorat-comsup.js')}}"></script>
@endpush
