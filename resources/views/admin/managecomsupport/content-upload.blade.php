@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}" />
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
<script src="{{asset_app('assets/js/plugin/ckeditor/ckeditor.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

<!--<style>
    .select2-results__option--disabled {
        display: none;
    }
</style>-->
@endpush


@section('breadcumb', 'Admin')
@section('pages', asset_app(''))
@section('back', route('home'))

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">

        <nav aria-label="breadcrumb">
            <div class="row">
                <a href="{{url()->previous()}}" class="text-dark pt-3 ">
                    <svg class="w-6 h-6 ml-2 arrow" width="35px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
            </div>
        </nav>

        <div class="pl-5 pb-4">
            <div class="my-4 d-flex align-content-between">
                <div class="d-flex mr-auto ml-2 flex-wrap">
                    <a class="btn-com mt-2 mr-3 active disabled" id="communication" role="button">Content Communication Support</a>
                    <a href="{{route('manage_com.upload_form', ['type'=>'implementation'])}}" class="btn-com mt-2 mr-3" id="implementation" role="button">Implementation</a>
                </div>
            </div>

            <h3 class="pl-2 pt-2">Upload Content</h3>

            <!-- NAVIGASI -->
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                </div>
            </div>
            <!-- NAVIGASI -->
            @include('layouts.alert')

            <form action="{{route('manage_com.create')}}" id="form" class="px-3 pb-5" method="post" enctype="multipart/form-data">
                @csrf

                @isset($data->data->id)
                    <input type="hidden" name="id" id="id" value="{{$data->data->id}}">
                @endisset
                <div class="form-group">
                    <label for="thumbnail" class="label-cus">Thumbnail</label>
                    <div id="drop-wrap" class="dropzones-wrapper d-flex align-items-center justify-content-center thumbnail-wrap">
                        <div class="dropzones-desc d-flex align-items-center justify-content-center" id="thumbnail-desc" style="width: inherit; height: inherit">
                            <p id="thumbnail-text" style="text-align:left;cursor:default;margin-bottom: 0; position:absolute;">Drag image here<br>or <span class="choose-file">choose your file</span></p>
                            @isset($data->data->thumbnail)
                            <img id="thumbnail-prev" class="thumbnail-prev" src="{{config('app.url').'storage/'.$data->data->thumbnail??asset_app('assets/img/boxdefault.svg')}}" alt="thumbnail" />
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

                <div class="hidden" id="hidden-thumbnail">
                    @isset($data->data->thumbnail)
                    <input type="hidden" class="d-none" id="thumbnail" name="thumbnail" value="{{$data->data->thumbnail}}">
                    @endisset
                </div>

                <div class="form-group">
                    <label for="file_type" class="label-cus">Parent Project</label>
                    <select class="form-control" id="parent" name="parent" style="width: 33%; height: 40px" required>
                        <option value="" selected disabled>Pilih Parent Project</option>
                        @if($data->data)
                            @isset($data->data->project_id)
                                <option value="1" selected>Based on Project</option>
                                <option value="2">General</option>
                            @else
                                <option value="1">Based on Project</option>
                                <option value="2" selected>General</option>
                            @endisset
                        @else
                            <option value="1">Based on Project</option>
                            <option value="2">General</option>
                        @endif
                    </select>
                </div>

                <div id="content-project">

                    @isset($data->data->nama)
                        <div class="form-group project-link" style="width: 70%;">
                            <label for="link" class="label-cus">Project Link <span style="font-size: 14px;font-weight: normal">(jika project existing di BRIKNOW)</span></label>
                            <select class="link select2 form-control @error('link') is-invalid @enderror" id="link" name="link" placeholder='Project Link' required>
                                <option value="{{$data->data->project_id}}" data-value="{{$data->data->project_id}}" selected>{{$data->data->nama}}</option>
                            </select>
                        </div>
                    @endisset
                    <!--<div class="form-group">
                        <label for="nama" class="label-cus">Nama Project</label>
                        <input type="text" class="form-control" style="width: 70%; height: 40px" id="nama" name="nama" placeholder="Nama Project">
                    </div>

                    <div class="form-group">
                        <label for="link" class="label-cus">Project Link <span style="font-size: 14px;font-weight: normal">(jika project existing di BRIKNOW)</span></label>
                        <input type="text" class="form-control" style="width: 70%; height: 40px" id="link" name="link" placeholder="Project Link">
                    </div>-->
                </div>

                <div class="form-group">
                    <label for="title" class="label-cus">Judul</label>
                    <input type="text" class="form-control" style="width: 70%; height: 40px" id="title" name="title"  value="{{$data->data->title ?? '' }}" placeholder="Judul" required>
                </div>

                <div class="form-group">
                    <label for="file_type" class="label-cus">Jenis File</label>
                    <select class="form-control" id="file_type" name="file_type" style="width: 33%; height: 40px; padding: 5px 15px" required>
                        <option value="" selected disabled>Pilih Jenis File</option>
                        @forelse($data->type_file as $item)
                            @isset($data->data->type_file)
                                @if($data->data->type_file == $item->value)
                                    <option value="{{$item->value}}" selected>{{$item->name}}</option>
                                @else
                                    <option value="{{$item->value}}">{{$item->name}}</option>
                                @endif
                            @else
                                <option value="{{$item->value}}">{{$item->name}}</option>
                            @endisset
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="label-cus">Caption</label>
                    <textarea name="deskripsi" class="form-control" style="width: 90%" id="deskripsi" value="{{$data->data->desc ?? ''}}">{{$data->data->desc ?? ''}}</textarea>
                </div>

                <div class="form-group mb-1">
                    <label for="file" class="label-cus">Attachment File</label>
                    <div id="attach-wrap" class="dropzones-wrapper d-flex align-items-center justify-content-center">
                        <div class="dropzones-desc d-flex align-items-center justify-content-center">
                            <i class="fa fa-file mr-3" style="font-size: 24px"></i>
                            <p style="text-align:left;cursor:default;margin-bottom: 0">Drag file here<br>or <span class="choose-file">choose your file</span></p>
                        </div>
                        @isset($data->data->attach_file)
                        <input type="file" name="file[]" class="dropzones form-control" id="file" multiple>
                        @else
                        <input type="file" name="file[]" class="dropzones form-control" id="file" multiple required>
                        @endisset
                    </div>
                </div>
                <p style="margin-bottom: 0;line-height: 18px;font-size: 12px;font-style: italic;">* 1 file maks. 100 mb.</p>
                <p class="mb-2" style="margin-bottom: 0;line-height: 18px;font-size: 12px;font-style: italic;">* Upload sesuai dengan jenis file</p>

                <div class="preview-zone mt-3" id="preview">
                    @isset($data->data->attach_file)
                    @forelse($data->data->attach_file as $item)
                    <div id="prev{{$item->id}}" class="d-flex align-items-center mb-3" style=" width: 55%; height: 40px;">
                        <div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">
                            <div class="d-flex align-items-center justify-content-between detail-prev" style="width: 100%">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-file mr-3"></i>{{$item->nama}}
                                </div>
                                <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Delete" onclick="removePreview(this, 'delete')">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="attach[]" value="{{$item->url_file}}">
                    </div>
                    @empty
                    @endforelse
                    @endisset
                </div>

                <button class="btn btn-primary button-upload mt-3" type="submit" id="submit">Upload</button>
            </form>
        </div>

    </div>
</div>
@endsection
@push('page-script')
<script src="{{asset_app('assets/js/select2.min.js')}}"></script>
<script src="{{asset_app('assets/js/page/cominitiativeupload.js')}}"></script>
<script>
    let tok = '{{csrf_token()}}';
    CKEDITOR.replace('deskripsi', {
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
@endpush
