@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
<script src="{{asset_app('assets/js/plugin/ckeditor/ckeditor.js')}}"></script>
@endpush


@section('breadcumb', 'Admin')
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
                    <a class="btn-com mt-2 mr-3 active disabled" id="communication" role="button">Communication Initiative</a>
                    <a class="btn-com mt-2 mr-3" id="strategic" role="button">Strategic Initiative</a>
                    <a class="btn-com mt-2 mr-3" id="implementation" role="button">Implementation</a>
                </div>
            </div>

            <h3 class="pl-2 pt-2">Upload Communication Initiative</h3>

            <!-- NAVIGASI -->
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                </div>
            </div>
            <!-- NAVIGASI -->
            @include('layouts.alert')

            <form action="" id="form" class="px-3 pb-5" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title" class="label-cus">Judul</label>
                    <input type="text" class="form-control" style="width: 70%; height: 40px" id="title" name="title" placeholder="Judul">
                </div>

                <div class="form-group">
                    <label for="file_type" class="label-cus">Jenis File</label>
                    <select class="form-control select-upload" id="file_type" name="file_type" style="width: 33%; height: 40px">
                        <option value="" selected disabled>Pilih Jenis File</option>
                        @forelse($type_file as $item)
                        <option value="{{$item['value']}}">{{$item['name']}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="label-cus">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" style="width: 90%" id="deskripsi"></textarea>
                </div>

                <div class="form-group mb-1">
                    <label for="file" class="label-cus">Attachment File</label>
                    <div class="dropzones-wrapper d-flex align-items-center justify-content-center">
                        <div class="dropzones-desc d-flex align-items-center justify-content-center">
                            <i class="fa fa-file mr-3" style="font-size: 24px"></i>
                            <p style="text-align:left;cursor:default;margin-bottom: 0">Drag file here<br>or <span class="choose-file">choose your file</span></p>
                        </div>
                        <input type="file" name="file[]" class="dropzones form-control" id="file" multiple>
                    </div>
                </div>
                <p style="margin-bottom: 0;line-height: 18px;font-size: 12px;font-style: italic;">* 1 file maks. 100 mb.</p>
                <p class="mb-2" style="margin-bottom: 0;line-height: 18px;font-size: 12px;font-style: italic;">* Upload sesuai dengan jenis file</p>

                <div class="preview-zone hidden" id="preview">
                </div>

                <button class="btn btn-primary button-upload mt-3 disabled" type="submit" id="submit" disabled>Upload</button>
            </form>
        </div>

    </div>
</div>
@endsection
@push('page-script')
<script>
    localStorage.clear();
</script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
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
