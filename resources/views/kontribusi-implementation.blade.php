@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <!-- Filepond stylesheet -->
<!--    <link rel="stylesheet" href="{{asset_app('assets/css/filepond.css')}}">-->
<!--    <link href="{{asset_app('assets/css/filepond-preview.css')}}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}" />
    <link rel="stylesheet" href="{{ asset_app('assets/css/kontribusi.css') }}" />
    <script src="{{asset_app('assets/js/plugin/ckeditor/ckeditor.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css">
<style>
    .select2-selection__choice__display {
        margin-left: 10px;
    }

    .select2-dropdown--below:has(> span.select2-results:has(> ul.select2-konsultant-results)) {
        margin-top: 12px;
    }

    .setup-content > .form-group {
        margin-bottom: 1.75rem;
    }

    select[readonly].select2-hidden-accessible + .select2-container {
        pointer-events: none;
        touch-action: none;
    }

    select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
        background: #eee;
        box-shadow: none;
    }

    /*select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,*/
    select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
        display: none;
    }
</style>
@endpush

@section('breadcumb', 'Kontribusi Implementasi')
@section('pages', asset_app(''))
@section('token', session()->get('token'))

@section('content')
<div class="row judul mb-4">
    <div class="stepwizard align-items-center mb-4">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step s2 stepwizard-step-garis">
                <a href="#step-1" id="s-1" class="btn bunderan btn-warning btn-circle reguler">1</a>
                <p class="ket"><strong>Data Project</strong></p>
            </div>
            <div class="stepwizard-step s3">
                <a href="#step-2" id="s-2" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">2</a>
                <p class="ket"><strong>Detail Implementasi & Upload Dokumen</strong></p>
            </div>

        </div>
    </div>
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    <span class="font-weight-bold d-block">Mohon Dilengkapi :</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (Session::has('error'))
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
        @endif
    </div>
    <div class="col-md-12">
        <form action="{{route('kontribusi.createimplementation')}}" id="form"  method="post" enctype="multipart/form-data">
            @csrf
            {{-- STEP 1 --}}
                <div class="mb-5 setup-content" id="step-1">
                    <div class="mb-4">
                        <h4>Data Project</h4>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center label-cus-2">Thumbnail<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-10 col-sm-12 ">
                            <div id="drop-wrap" class="dropzones-wrapper d-flex align-items-center justify-content-center thumbnail-wrap" style="width: 175px;height: 175px;box-shadow: none;border: dashed 1px black;border-radius: 8px">
                                <div class="dropzones-desc d-flex align-items-center justify-content-center" id="thumbnail-desc" style="width: inherit; height: inherit">
                                    <p id="thumbnail-text" style="text-align:left;cursor:default;margin-bottom: 0; position:absolute;">Drag image here<br>or <span class="choose-file">choose your file</span></p>
                                    @isset($data->data->thumbnail)
                                    <img id="thumbnail-prev" class="thumbnail-prev" src="{{config('app.url').'storage/'.$data->data->thumbnail}}" onerror="imgError(this)" alt="thumbnail" />
                                    <div id="thumbnail-del" title="Hapus" class="thumbnail-delete d-flex align-items-center justify-content-center d-none" onclick="removeThumbnailPreview()">
                                        <i class="fas fa-times" style="font-size: 24px"></i>
                                    </div>
                                    @endisset
                                </div>
                                @isset($data->data->thumbnail)
                                <input type="file" accept="image/png, image/jpg, image/jpeg" value="{{$data->data->thumbnail}}" name="photo" class="dropzones form-control" id="photo" style="height: 100% !important;z-index: 97">
                                @else
                                <input type="file" accept="image/png, image/jpg, image/jpeg" name="photo" class="dropzones form-control" id="photo" style="height: 100% !important;z-index: 97" required>
                                @endisset
                            </div>
                        </div>

                    </div>

                    <div class="hidden" id="hidden-thumbnail">
                        @isset($data->data->thumbnail)
                        <input type="hidden" class="d-none" id="thumbnail" name="thumbnail" value="{{$data->data->thumbnail}}">
                        @endisset
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Direktorat<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <select name="direktorat" id="direktorat" class="form-control text-black select2" value="{{old('direktorat')}}" required>
                                <option value="" disabled selected>Pilih Direktorat</option>
                                @foreach ($data->direktorat == NULL ? 'Lainnya' : $data->direktorat as $item)
                                    @isset($data->data->divisi)
                                        @if($data->data->divisi->direktorat == $item->direktorat)
                                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}" selected>{{ $item->direktorat }}</option>
                                        @else
                                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                                        @endif
                                    @elseif(old('direktorat') <> null)
                                        @if(old('direktorat') == $item->direktorat)
                                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}" selected>{{ $item->direktorat }}</option>
                                        @else
                                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                                        @endif
                                    @else
                                        <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                                    @endisset
                                @endforeach
                                <option value="NULL">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Unit Kerja<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <select  id="divisi" class="form-control select2" value="{{old('divisi')}}" name="divisi" required>
                                <option value="" selected disabled>Pilih Unit Kerja</option>
                                @isset($data->data->divisi)
                                    <option value="{{$data->data->divisi->id }}" data-value="{{ $data->data->divisi->divisi }}" selected>{{ $data->data->divisi->divisi }}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Nama Proyek<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <input type="text" name="nama_project" id="nama_project" class="form-control" value="{{$data->data->nama ?? old('nama_project')}}" placeholder="Nama Proyek" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 col-sm-12"></div>
                        <div class="col-md-5 col-sm-12">
                            <input type="checkbox" name="status" class="box-shadow-none d-inline mr-2 h-50" id="stat_project" {{(isset($data->data->status_finish)) ? ($data->data->status_finish == '1' ? 'checked' : '') : (old('status') <> '' ? 'checked' : '')}}>Project telah selesai
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_mulai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Tanggal Mulai<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-5 col-sm-12">
                            <input type="date" data-provide="datepicker" class="form-control" value="{{(isset($data->data->tanggal_mulai)) ? \Carbon\carbon::create($data->data->tanggal_mulai)->format('Y-m-d') : old('tgl_mulai')}}" id="tgl_mulai" name="tgl_mulai" placeholder="Tanggal mulai" max="{{\Carbon\carbon::now()->format('Y-m-d')}}" required>
                        </div>
                    </div>
                    @if(old('tgl_selesai') <> '')
                            <div class="form-group row content-selesai">
                                <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                                <div class="col-md-5 col-sm-12 content-selesai">
                                    <input type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{old('tgl_selesai')}}" placeholder="Tanggal selesai" required>
                                </div>
                            </div>
                    @elseif(isset($data->data->status_finish))
                        @if($data->data->status_finish == '1')
                            <div class="form-group row content-selesai">
                                <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                                <div class="col-md-5 col-sm-12 content-selesai">
                                    <input type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{(isset($data->data->tanggal_selesai)) ? \Carbon\carbon::create($data->data->tanggal_selesai)->format('Y-m-d') : old('tgl_selesai')}}" placeholder="Tanggal selesai" required>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="w-100" id="form_tgl_selesai">
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Nama Project Manager<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <input type="text" class="form-control" id="projectmanager" value="{{$data->data->project_managers->nama ?? old('pm')}}" placeholder="Nama Project Manager" name="pm" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Email Project Manager<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <input type="email" class="form-control" id="email" value="{{$data->data->project_managers->email ?? old('emailpm')}}" placeholder="example@domain.com" name="emailpm" required>
                        </div>
                    </div>
                    <div class="w-100" id="worker"></div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Restricted Page<span class="text-danger ml-1">*</span></label>
                        <div class="col-md-3 col-sm-12">
                            <select class="form-control" id="restricted" value="{{old('restricted')}}" name="restricted" required>
                                <option value="" selected disabled>Pilih Opsi</option>
                                @if(old('restricted') <> '')
                                    <option value="1" {{old('restricted') == '1' ? 'selected' : ''}}>Ya</option>
                                    <option value="0" {{old('restricted') == '0' ? 'selected' : ''}}>Tidak</option>
                                @else
                                    <option value="1" {{(isset($data->data->is_restricted)) ? ($data->data->is_restricted == 1 ? 'selected' : '') : ''}}>Ya</option>
                                    <option value="0" {{(isset($data->data->is_restricted)) ? ($data->data->is_restricted == 1 ? '' : 'selected') : ''}}>Tidak</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div id="restricted_content" class="d-none" style="padding: 10px 2rem">
                        <div class="form-group w-100 d-flex justify-content-start">
                            <div class="d-flex align-items-center">
                                <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                                <button type="button" style="border-radius: 8px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success ml-3" onclick="addUserAccess()"><i class="fa fa-plus mr-3"></i>Tambah User</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <div>
<!--                                <a href="{{route('myproject')}}" class="btn btn-outline-primary btn-sm mr-2">Previous</a>-->
                                <button class="btn btn-primary text-white nextBtn btn-sm pull-right" type="button" >Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- END STEP 1 --}}

            {{-- STEP 2 --}}
                <div class="mb-5 setup-content" style="display:none;" id="step-2">
                    <div class="mb-4">
                        <h4>Detail Implementasi</h4>
                    </div>
                    <div class="mb-1">
                        <p>Pilih tahap implementasi yang akan diisi :</p>
                    </div>
                    <div class="mb-2">
                        <input type="hidden" name="piloting" value="0">
                        <input type="checkbox" id="piloting" name="piloting" value="1" data-id="#piloting_view">
                        <label for="piloting"> Piloting </label><br>
                        <input type="hidden" name="rollout" value="0">
                        <input type="checkbox" id="rollout" name="rollout" value="1" data-id="#rollout_view">
                        <label for="rollout"> Roll Out </label><br>
                        <input type="hidden" name="sosialisasi" value="0">
                        <input type="checkbox" id="sosialisasi" name="sosialisasi" value="1" data-id="#sosialisasi_view">
                        <label for="sosialisasi"> Sosialisasi </label>
                    </div>
                    <hr/>

                    <div id="piloting_view" style="display:none">
                        <div class="mb-4">
                            <h4>Deskripsi Piloting</h4>
                            <div class="form-group row ">
                                <!--                                <label for="" class="col-sm-12 col-form-label font-weight-600">Deskripsi Piloting<span class="text-danger ml-1">*</span></label>-->
                                <div class="col-md-12">
                                    <textarea name="deskripsi_piloting" class="w-100" value="{{$data->data->deskripsi ?? old('deskripsi')}}" id="editor-deskripsi">{{$data->data->deskripsi ?? old('deskripsi')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <!--                            <h4>Dokumen Piloting</h4>-->
                            <div class="form-group mb-1">
                                <h4>Dokumen Piloting</h4>
                                <div id="attach-wrap-piloting" class="dropzones-wrapper d-flex align-items-center justify-content-center">
                                    <div class="dropzones-desc d-flex align-items-center justify-content-center">
                                        <i class="fa fa-file mr-3" style="font-size: 24px"></i>
                                        <p style="text-align:left;cursor:default;margin-bottom: 0">Drag file here<br>or <span class="choose-file">choose your file</span></p>
                                    </div>
                                    @isset($data->data->attach_file)
                                    <input type="file" name="file_piloting[]" class="dropzones form-control" id="file-piloting" multiple>
                                    @else
                                    <input type="file" name="file_piloting[]" class="dropzones form-control" id="file-piloting" multiple>
                                    @endisset
                                </div>
                            </div>
                            <div class="my-0">
                                <p class="mb-0"><i>* File Maks 100Mb</i></p>
                                <p><i>* Tidak Bisa Upload Dengan Format RAR</i></p>
                            </div>

                            <div class="preview-zone mt-3" id="preview-piloting">
                                @isset($data->data->attach_file)
                                @forelse($data->data->attach_file as $item)
                                @if($item->tipe == 'pilotting')
                                <div id="prev-piloting{{$item->id}}" class="d-flex align-items-center mb-3" style=" width: 55%; height: 40px;">
                                    <div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">
                                        <div class="d-flex align-items-center justify-content-between detail-prev" style="width: 100%">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-file mr-3"></i>{{$item->nama}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Delete" onclick="removePreview(this, 'delete', 'piloting')">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="attach-piloting" type="hidden" name="attach_piloting[]" value="{{$item->url_file}}">
                                </div>
                                @endif
                                @empty
                                @endforelse
                                @endisset
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div id="rollout_view" style="display:none">
                        <div class="mb-4">
                            <h4>Deskripsi Roll Out</h4>
                            <div class="form-group row ">
                                <label for="" class="col-sm-12 col-form-label font-weight-600">Deskripsi Piloting<span class="text-danger ml-1">*</span></label>
                                <div class="col-md-12">
                                    <textarea name="deskripsi_rollout" class="w-100" value="{{$data->data->deskripsi ?? old('deskripsi')}}" id="editor-rollout">{{$data->data->deskripsi ?? old('deskripsi')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-group mb-1">
                                <h4>Dokumen Roll Out</h4>
                                <div id="attach-wrap-rollout" class="dropzones-wrapper d-flex align-items-center justify-content-center">
                                    <div class="dropzones-desc d-flex align-items-center justify-content-center">
                                        <i class="fa fa-file mr-3" style="font-size: 24px"></i>
                                        <p style="text-align:left;cursor:default;margin-bottom: 0">Drag file here<br>or <span class="choose-file">choose your file</span></p>
                                    </div>
                                    @isset($data->data->attach_file)
                                    <input type="file" name="file_rollout[]" class="dropzones form-control" id="file-rollout" multiple>
                                    @else
                                    <input type="file" name="file_rollout[]" class="dropzones form-control" id="file-rollout" multiple>
                                    @endisset
                                </div>
                            </div>
                            <div class="my-0">
                                <p class="mb-0"><i>* File Maks 100Mb</i></p>
                                <p><i>* Tidak Bisa Upload Dengan Format RAR</i></p>
                            </div>

                            <div class="preview-zone mt-3" id="preview-rollout">
                                @isset($data->data->attach_file)
                                @forelse($data->data->attach_file as $item)
                                @if($item->tipe == 'rollout')
                                <div id="prev-rollout{{$item->id}}" class="d-flex align-items-center mb-3" style=" width: 55%; height: 40px;">
                                    <div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">
                                        <div class="d-flex align-items-center justify-content-between detail-prev" style="width: 100%">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-file mr-3"></i>{{$item->nama}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Delete" onclick="removePreview(this, 'delete', 'rollout')">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="attach-rollout" type="hidden" name="attach_rollout[]" value="{{$item->url_file}}">
                                </div>
                                @endif
                                @empty
                                @endforelse
                                @endisset
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div id="sosialisasi_view" style="display:none">
                        <div class="mb-4">
                            <h4>Deskripsi Sosialisasi</h4>
                            <div class="form-group row ">
                                <label for="" class="col-sm-12 col-form-label font-weight-600">Deskripsi Sosialisasi<span class="text-danger ml-1">*</span></label>
                                <div class="col-md-12">
                                    <textarea name="deskripsi_sosialisasi" class="w-100" value="{{$data->data->deskripsi ?? old('deskripsi')}}" id="editor-sosialisasi">{{$data->data->deskripsi ?? old('deskripsi')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-group mb-1">
                                <h4>Dokumen Sosialisasi</h4>
                                <div id="attach-wrap-sosialisasi" class="dropzones-wrapper d-flex align-items-center justify-content-center">
                                    <div class="dropzones-desc d-flex align-items-center justify-content-center">
                                        <i class="fa fa-file mr-3" style="font-size: 24px"></i>
                                        <p style="text-align:left;cursor:default;margin-bottom: 0">Drag file here<br>or <span class="choose-file">choose your file</span></p>
                                    </div>
                                    @isset($data->data->attach_file)
                                    <input type="file" name="file_sosialisasi[]" class="dropzones form-control" id="file-sosialisasi" multiple>
                                    @else
                                    <input type="file" name="file_sosialisasi[]" class="dropzones form-control" id="file-sosialisasi" multiple>
                                    @endisset
                                </div>
                            </div>
                            <div class="my-0">
                                <p class="mb-0"><i>* File Maks 100Mb</i></p>
                                <p><i>* Tidak Bisa Upload Dengan Format RAR</i></p>
                            </div>

                            <div class="preview-zone mt-3" id="preview-sosialisasi">
                                @isset($data->data->attach_file)
                                @forelse($data->data->attach_file as $item)
                                @if($item->tipe == 'sosialisasi')
                                <div id="prev-sosialisasi{{$item->id}}" class="d-flex align-items-center mb-3" style=" width: 55%; height: 40px;">
                                    <div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">
                                        <div class="d-flex align-items-center justify-content-between detail-prev" style="width: 100%">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-file mr-3"></i>{{$item->nama}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Delete" onclick="removePreview(this, 'delete', 'sosialisasi')">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="attach-sosialisasi" type="hidden" name="attach_sosialisasi[]" value="{{$item->url_file}}">
                                </div>
                                @endif
                                @empty
                                @endforelse
                                @endisset
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="ml-1 row">
                            <h4>Nama Proyek</h4>
                        </div>
                        <div class="form-group row ">
                            <div class="col-md-12">
                                <select class="link select2 form-control @error('link') is-invalid @enderror" id="link" name="link" placeholder='Nama Proyek' required>
                                    @isset($data->data->nama)
                                    <option value="{{$data->data->project_id}}" data-value="{{$data->data->project_id}}" selected>{{$data->data->nama}}</option>
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="is_new" id="is_new" value="1">

                    @if(session()->get('role') == 3)
                        @isset($data->data->user_maker)
                            @if($data->data->user_maker <> session()->get('personal_number'))
                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                                    <div class="col-md-10 col-sm-12">
                                        <select name="checker" id="checker" class="checker select2 form-control @error('checker') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                                            @isset($data->data->user_checker)
                                                <option value="{{$data->data->user_checker}}" data-value="{{$data->data->user_checker}}" selected>{{$data->data->user_checker}} - {{$data->data->userchecker->name}}</option>
                                            @endisset
                                        </select>
                                        @error('checker')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                                    <div class="col-md-10 col-sm-12">
                                        <select name="signer" id="signer" class="signer select2 form-control @error('signer') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                                            @isset($data->data->user_signer)
                                                <option value="{{$data->data->user_signer}}" data-value="{{$data->data->user_signer}}" selected>{{$data->data->user_signer}} - {{$data->data->usersigner->name}}</option>
                                            @endisset
                                        </select>
                                        @error('signer')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                                    <div class="col-md-10 col-sm-12">
                                        <select class="select2 form-control" id="checker" name="checker" required>
                                            <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                                    <div class="col-md-10 col-sm-12">
                                        <select class="select2 form-control" id="signer" name="signer" required>
                                            <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                                <div class="col-md-10 col-sm-12">
                                    <select class="select2 form-control" id="checker" name="checker">
                                        <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                                <div class="col-md-10 col-sm-12">
                                    <select class="select2 form-control" id="signer" name="signer" required>
                                        <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                                    </select>
                                </div>
                            </div>
                        @endisset
                    @else
                        <div class="form-group row">
                            <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                            <div class="col-md-10 col-sm-12">
                                <select name="checker" id="checker" class="checker select2 form-control @error('checker') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                                    @if(old('checker'))
                                        <option value="{{old('checker')}}" data-value="{{old('checker')}}" selected>{{old('checker')}}</option>
                                    @elseif(isset($data->data->user_checker))
                                        <option value="{{$data->data->user_checker}}" data-value="{{$data->data->user_checker}}" selected>{{isset($data->data->userchecker->name) ? $data->data->user_checker.' - '.$data->data->userchecker->name : $data->data->user_checker}}</option>
                                    @endif
                                </select>
                                <small class='text-black font-italic'>* Pastikan <b>Personal Number</b> yang di Isi Bukan Anda Atau Admin</small>
                                @error('checker')
                                {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                            <div class="col-md-10 col-sm-12">
                                <select name="signer" id="signer" class="signer select2 form-control @error('signer') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                                    @if(old('signer'))
                                        <option value="{{old('signer')}}" data-value="{{old('signer')}}" selected>{{old('signer')}}</option>
                                    @elseif(isset($data->data->user_signer))
                                        <option value="{{$data->data->user_signer}}" data-value="{{$data->data->user_signer}}" selected>{{isset($data->data->usersigner->name) ? $data->data->user_signer.' - '.$data->data->usersigner->name : $data->data->user_signer}}</option>
                                    @endisset
                                </select>
                                <small class='text-black font-italic'>* Pastikan <b>Personal Number</b> yang di Isi Bukan Anda Atau Admin</small>
                                @error('signer')
                                {{$message}}
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="row mt-4">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <button class="btn btn-outline-primary prevBtn btn-sm mr-2" type="button">Previous</button>
                            <button class="btn btn-primary text-white nextBtn btn-sm pull-right" id="preview" type="button" >Preview</button>
                        </div>
                    </div>
                </div>
            {{-- END STEP 2 --}}
        </form>
    </div>
    <div class="modal fade bd-example-modal-lg modal-preview" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
            <div class="modal-content content-preview bg-transparent">
                <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                    <div class="bg-white bg-white w-100">
                        @include('admin.managecomsupport.preview-save')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
    <script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/implementationupload.js')}}"></script>
    <script>
        let tok = '{{csrf_token()}}';
        CKEDITOR.replace('editor-deskripsi', {
            filebrowserUploadUrl: `{{config('app.url')}}upimgcontent`,
            filebrowserUploadMethod: 'xhr',
            fileTools_requestHeaders: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': tok
            }
        });

        CKEDITOR.replace('editor-rollout', {
            filebrowserUploadUrl: `{{config('app.url')}}upimgcontent`,
            filebrowserUploadMethod: 'xhr',
            fileTools_requestHeaders: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': tok
            }
        });

        CKEDITOR.replace('editor-sosialisasi', {
            filebrowserUploadUrl: `{{config('app.url')}}upimgcontent`,
            filebrowserUploadMethod: 'xhr',
            fileTools_requestHeaders: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': tok
            }
        });

        CKEDITOR.config.toolbar = [
            { name: 'styles', items: [ 'Styles', 'Format', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
            { name: 'document', items: [ 'Source', 'Preview', 'Print' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'Smiley' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'colors', items: [ 'BGColor' ] },
        ];
        CKEDITOR.config.height = '300px';
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.resize_enabled = false;
    </script>

    @isset($data->data->consultant)
        @if($data->data->consultant !== [])
            <script>
                // set select2
                $('#konsultant').select2({
                    placeholder : 'Pilih Konsultan/Vendor'
                });
            </script>
        @endif
    @endisset
    @isset($data->data->user_restrict)
        @if($data->data->is_restricted == 1)
            <script>
                // set select2
                $('#user').select2({
                    placeholder : 'Pilih User'
                });
            </script>
        @endif
    @endisset
@endpush