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

@section('breadcumb', 'Implementation')
@section('back', route('home'))

@section('content')
    <div class="row judul mt-4">
        <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
            <img src="{{asset('storage/'.$data->thumbnail)}}" alt="" id="prev_thumbnail" class="img-detail">
        </div>
        <div class="col-md-10 col-sm-12 pr-0 header-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 mb-2">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-8 px-0  d-min">
                                <a class="font-weight-bold" href="{{route('project.view',$data->project->slug)}}">
                                    <h2>{{!empty($data->title)?$data->title:"-"}}</h2>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary fa fa-share"><span>Berbagi</span></button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary fa fa-star"><span>Simpan</span></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <span class="d-block font-weight-bold">Konsultan</span>
                            @php $last = end($data->consultant); @endphp
                            @forelse ($data->consultant as $consultant)
                                @if ($consultant == $last)
                                    <a href="{{route('consultant.index',$consultant->id)}}" class="fs-10"><span>{{$consultant->nama}}</span></a>
                                @else
                                    <a href="{{route('consultant.index',$consultant->id)}}" class="fs-10"><span>{{$consultant->nama}},</span></a>
                                @endif
                            @empty
                                <a href="#"><span>Internal</span></a>
                            @endforelse
                        </div>
                        <div class="col-md-5 col-sm-6 justify-content-end">
                            <span class="d-block font-weight-bold">Project Manager</span>
                            <span>{{!empty($data->project_managers->nama)?$data->project_managers->nama:"(Tidak ada data)"}}</span>
                            <small class="d-block">
                                <i class="far fa-envelope"></i>
                                <a href="{{!empty($data->project_managers->email)?"mailto:".$data->project_managers->email:"#"}}">{{!empty($data->project_managers->email)?\Str::limit($data->project_managers->email,20):"(Tidak ada data)"}}</a>
                            </small>
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
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="row">
                <h6 class="font-weight-bolder">Detail</h6>
            </div>
            <div class="row">
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Direktorat</div>
                    <div class="col-md-8 px-0  d-min"><a class="font-weight-bold" href="{{route('divisi',$data->divisi->id)}}">{{$data->divisi->direktorat}}</a></div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Pemilik Proyek</div>
                    <div class="col-md-8 px-0  d-min"><a class="font-weight-bold" href="{{route('divisi',$data->divisi->id)}}">{{$data->divisi->divisi}}</a></div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Tanggal Mulai</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">{{date('d F Y', strtotime($data->tanggal_mulai))}}</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Tanggal Selesai</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">
                        @if($data->project->status_finish == 0)
                            -
                        @else
                            {{date('d F Y', strtotime($data->tanggal_selesai))}}
                        @endif
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Status</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">
                        @if($data->project->status_finish == 0)
                            On Progress
                        @else
                            Selesai
                        @endif
                    </div>
                </div>
            </div>

            Tags
            <div class="row mt-4">
                <h6 class="font-weight-bolder">Tags</h6>
            </div>
            <div class="row col-md-12 px-0 font-weight-normal mb-4">
                @if($data->project->keywords)
                    @foreach ($data->project->keywords as $tag)
                        <span class="badge badge-cyan-light text-dark mr-1 mb-2">{{$tag->nama}}</span>
                    @endforeach
                @else
                    <span class="badge badge-cyan-light text-dark mr-1">-</span>
                @endif
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify metodologi">
            <div class="row">
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div style="background-color: #0a53be; border-radius: 5px; padding: 3px;">
                        <h6 class="text-white mt-1">Piloting</h6>
                    </div>
                    <div class="metodologi-isi wrap"><p>{!! !empty($data->desc_piloting)?$data->desc_piloting:"-"!!}</p></div>
                </div>
                <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="#" class="w-100" id="search">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                      <span class="input-group-text search-sm attr_input">
                          <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                      </span>
                                        </div>
                                        <input type="text" class="form-control search-sm" placeholder="Search files..." aria-describedby="inputGroup-sizing-sm" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-1" id="allcheck"> Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow">
                            @forelse($data->attach_file as $value)
                                @if($value->tipe === 'piloting')
                                    <tr class="rowdoc">
                                        <td id="td-attachment"><span>{{$value->nama}}</span></td>
                                        <td id="td-attachment"><span>{{\Carbon\carbon::create($value->updated_at)->format('d F Y')}}</span></td>
                                        <td id="td-attachment"><span>{{formatBytes($value->size)}}</span></td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="rowdoc">
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div style="background-color: #0a53be; border-radius: 5px; padding: 3px;">
                        <h6 class="text-white mt-1">Roll Out</h6>
                    </div>
                    <div class="metodologi-isi wrap"><p>{!! !empty($data->desc_roll_out)?$data->desc_roll_out:'-' !!}</p></div>
                </div>
                <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="#" class="w-100" id="search">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                      <span class="input-group-text search-sm attr_input">
                          <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                      </span>
                                        </div>
                                        <input type="text" class="form-control search-sm" placeholder="Search files..." aria-describedby="inputGroup-sizing-sm" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-1" id="allcheck"> Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow">
                            @forelse($data->attach_file as $value)
                                @if($value->tipe === 'rollout')
                                    <tr class="rowdoc">
                                        <td id="td-attachment"><span>{{$value->nama}}</span></td>
                                        <td id="td-attachment"><span>{{\Carbon\carbon::create($value->updated_at)->format('d F Y')}}</span></td>
                                        <td id="td-attachment"><span>{{formatBytes($value->size)}}</span></td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="rowdoc">
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div style="background-color: #0a53be; border-radius: 5px; padding: 3px;">
                        <h6 class="text-white mt-1">Sosialisasi</h6>
                    </div>
                    <div class="metodologi-isi wrap"><p>{!! !empty($data->desc_sosialisasi)?$data->desc_sosialisasi:'-' !!}</p></div>
                </div>
                <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="#" class="w-100" id="search">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                      <span class="input-group-text search-sm attr_input">
                          <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                      </span>
                                        </div>
                                        <input type="text" class="form-control search-sm" placeholder="Search files..." aria-describedby="inputGroup-sizing-sm" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-1" id="allcheck"> Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow">
                            @forelse($data->attach_file as $value)
                                @if($value->tipe === 'sosialisasi')
                                    <tr class="rowdoc">
                                        <td id="td-attachment"><span>{{$value->nama}}</span></td>
                                        <td id="td-attachment"><span>{{\Carbon\carbon::create($value->updated_at)->format('d F Y')}}</span></td>
                                        <td id="td-attachment"><span>{{formatBytes($value->size)}}</span></td>
                                    </tr>
                                @endif
                            @empty
                                <tr class="rowdoc">
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection