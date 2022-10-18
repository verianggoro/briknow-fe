@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')
<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Communication Support</h3>

        <div class="my-4 d-flex align-content-between">
            <div class="d-flex mr-auto ml-2 flex-wrap">
                <a href="{{route('manage_com.com_init')}}" class="btn-com mt-2 mr-3" id="communication" role="button">Communication Initiative</a>
                <a class="btn-com mt-2 mr-3 active disabled" id="strategic" role="button">Strategic Initiative</a>
                <a href="{{route('manage_com.implementation')}}" class="btn-com mt-2 mr-3" id="implementation" role="button">Implementation</a>
            </div>
            <div class="mr-2" style="margin-top: auto">
            </div>
        </div>

        <div class="mb-2 mt-4 d-flex align-content-between">
            <div class="d-flex mr-auto ml-2 flex-wrap" style="font-size: 18px">
                <a href="{{route('manage_com.strategic')}}" class="badge-str mt-2 mr-3" id="strategic_text">Strategic Initiative</a>
                <a class="badge-str mt-2 mr-3 disabled">/</a>
                <a class="badge-str mt-2 mr-3 disabled">Project</a>
            </div>
            <div class="mr-4 d-flex align-items-center" style="margin-top: auto">
                <!--<select style="border-radius: 8px; margin-right: 1rem;font-size: 12px;padding: 4px 15px;" class="form-control" id="select-sort" name="select-sort">
                    <option value="" selected disabled>Sort by</option>
                    <option value="tipe">Tipe File</option>
                    <option value="total">Total File</option>
                </select>-->
                <div>
                    <a href="{{route('manage_com.upload_form', ['type'=>'content'])}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success d-flex align-items-center"><i class="fa fa-plus mr-3"></i>Upload</a>
                </div>
            </div>
        </div>

        <!-- NAVIGASI -->
        <!-- NAVIGASI -->
        @include('layouts.alert')

        <div>
            <a href="{{route('project.index',$data->project->slug)}}" class="badge-str mt-2 ml-2" style="font-size: 22px; font-weight: 600; text-decoration: underline from-font">{{$data->project->nama}}</a>
        </div>

        <div class="content-file mt-4 ml-2">
            @forelse($data->type as $item)
                <div class="mb-4">
                    <div style="font-size: 22px;font-weight: 700;">{{$item->name}}</div>
                    <div style="font-weight: 500" class="mb-2">{{$item->total_content}} files</div>
                    <div class="d-flex justify-content-between pr-5">
                        <div class="d-flex align-items-center">
                            @forelse($item->content as $content)
                            <div class="container-img mr-3">
                                <div class="d-none">{{json_encode($content)}}</div>
                                <img src="{{config('app.url').'storage/'.$content->thumbnail}}" onclick="view(this)" onerror="imgError(this)"
                                     alt="{{$content->title}}" title="{{$content->title}}" width="150" height="150" class="img-com">
                            </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center" onclick="showMore('{{$item->id}}', '{{$slug}}')" style="margin: auto 4px; font-size: 18px; color: #2f80ed; cursor:pointer;">
                            <i class="fas fa-chevron-circle-right mr-3"
                               style="font-size: 32px;border: 3px solid #2f80ed;border-radius: 50%;background: #2f80ed;color: #f4f6f9;"></i>Lihat Semua</div>
                    </div>
                </div>
                <hr>
            @empty
            @endforelse
        </div>
    </div>
</div>
@endsection
@section('popup')
<div class="modal fade bd-example-modal-lg modal-preview" id="modal-preview-1" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100">
                    @include('admin.managecomsupport.preview-content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-script')
<script>
    localStorage.clear();
</script>
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
<!--<script src="{{asset_app('assets/js/page/strategic.js')}}"></script>-->
<script>
    var uri;
    var csrf = '';
    var be      = '';
    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    const type = [
        {'id': 'article', 'name': 'Articles'},
        {"id": "logo", "name": "Icon, Logo, Maskot BRIVO"},
        {"id": "infographics", "name": "Infographics"},
        {"id": "transformation", "name": "Transformation Journey"},
        {"id": "podcast", "name": "Podcast"},
        {"id": "video", "name": "Video Content"},
        {"id": "instagram", "name": "Instagram Content"}
    ]

    const metas = document.getElementsByTagName('meta');
    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === "pages") {
            uri = metas[i].getAttribute('content');
        }

        if (metas[i].getAttribute('name') === "BE") {
            be = metas[i].getAttribute('content');
        }

        if (metas[i].getAttribute('name') === "csrf") {
            csrf = metas[i].getAttribute('content');
        }
    }
    function showMore(type, slug) {
        window.location.href = uri+`/managecommunication/strategicinitiative/project/${slug}/${type}`;
    }

    function imgError(image) {
        let r = Math.floor(Math.random() * 9) + 1
        image.onerror = "";
        image.src = `${uri}/assets/img/news/img0${r}.jpg`;
        return true;
    }

    function view(e) {
        let row = JSON.parse($(e).parent().children().first().text())
        // return undefined;
        $('#desc-preview').empty();
        let data_attach = []
        let attach = row.attach_file
        for (let i=0; i<attach.length; i++) {
            const lastModifiedDate = new Date(attach[i].updated_at)
            data_attach.push({'name': attach[i].nama, 'date':lastModifiedDate, 'size': attach[i].size})
        }
        appendDesc(row.desc, data_attach)

        $('#prev_namaproject').empty();
        $('#prev_type').empty();
        // $('#prev_project').empty();
        $('.parent-project-desc').remove();
        $('#prev_tglmulai').empty();
        $('#prev_tglselesai').empty();
        $('#prev_status').empty();
        $('#prev_divisi').empty();
        $('#prev_direktorat').empty();

        let project = row.project
        if (project !== null) {
            $('#prev_direktorat').append(`<a class="font-weight-bold" href="${uri}/divisi/${project.divisi.id}">${project.divisi.direktorat}</a>`);
            $('#prev_divisi').append(`<a class="font-weight-bold" href="${uri}/divisi/${project.divisi.id}">${project.divisi.divisi}</a>`);
        } else {
            $('#prev_divisi').append(`-`);
            $('#prev_direktorat').append(`-`);
        }

        let t_project = ``
        if (row.project_id !== null) {
            t_project = `<a class="font-weight-bold fs-18 parent-project-desc" href="${uri}/project/${project.slug}">${project.nama}</a>`;
        } else {
            t_project = `<span class="parent-project-desc">General</span>`
        }

        let date_mulai          = new Date(row.tanggal_mulai);
        let t_tgl_mulai         = dateFormat(date_mulai);

        let t_tgl_selesai;
        if (row.tanggal_selesai !== null) {
            // waktu
            let temp_date           = new Date(row.tanggal_selesai);
            t_tgl_selesai         = dateFormat(temp_date);
            $('#prev_status').append(`Selesai`);

        }else{
            t_tgl_selesai = '-';
            $('#prev_status').append(`On Progress`);
        }
        let result = type.filter(obj => {
            return obj.id === row.type_file
        })

        $('#prev_thumbnail').attr('src',`${uri}/storage/${row.thumbnail}`);
        $('#prev_thumbnail').attr('alt',`${row.title}`);
        $('#prev_namaproject').append(`${row.title}`);
        $('#prev_type').append(`${result[0].name}`);
        $('#prev_project').append(`${t_project}`);
        $('#prev_tglmulai').append(`${t_tgl_mulai}`);
        $('#prev_tglselesai').append(`${t_tgl_selesai}`);

        const url = `${uri}/communication/views/content/${row.id}`

        $.ajax({
            url: url,
            data: {data: attach},
            type: 'post',
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function () {
            },
            error: function () {
                Toast2.fire({icon: 'error',title: 'Gagal'});
            },
        })

        $('#modal-preview-1').modal({
            show : true
        });
    }

    function dateFormat(date) {
        return date.getDate()+" "+ months[date.getMonth()]+" "+date.getFullYear();
    }

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    function appendDesc(caption, data) {
        let desc = `
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div class="preview-desc-head">Caption</div>
                    <div class="metodologi-isi wrap" id="prev_deskripsi">${caption}</div>
                </div>
                <div class="col-md-12 d-block w-100">
                    <h6>Attachment</h6>
                </div>
                <div class="col-md-12 d-block w-100" style="margin-bottom: 4rem">
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <div class="input-group control border-1 pencarian mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0"><i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" style="border: none;" class="form-control" id="inlineFormInput-search" placeholder="Search files..">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12" style="padding-left: 8px;">
                            <select style="border-radius: 8px;" class="form-control" id="select-file" name="select-file">
                                <option value="" selected disabled>Sort by</option>
                                <option value="name">Nama</option>
                                <option value="date">Date Modified</option>
                                <option value="size">Size</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-12" style="border: 2px solid #cccccc; border-radius: 8px">
                                <div class="row" style="border-bottom: 2px solid #cccccc;padding: 4px;font-weight: bold">
                                    <div class="col-md-9">Files</div>
                                    <div class="col-md-2">Date Modified</div>
                                    <div class="col-md-1">Size</div>
                                </div>
                                <div id="list-file" class="list-files"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `
        $('#desc-preview').append(desc)
        renderList(data)

        $(`#inlineFormInput-search`).keypress(function (e) {
            if (e.which === 13) {
                let a = data.filter(i => i.name.toLowerCase().includes($(this).val().toLowerCase()))
                renderList(a)
            }
        })

        $(`#select-file`).on('change', function () {
            let prop = $(this).val()
            let sort;
            if (prop === 'size') {
                sort = data.sort(function (a,b) {
                    return a[prop] - b[prop]
                })
            } else if (prop === 'name') {
                sort = data.sort(function (a,b) {
                    return a[prop].localeCompare(b[prop])
                })
            } else {
                sort = data.sort(function (a,b) {
                    return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0)
                })
            }
            renderList(sort)
        })

        function renderList(data) {
            let html = '';
            for (let e in data) {
                html += `
                    <div class="row" style="padding: 2px; color: #2f80ed; border-bottom: 1px solid #cccccc; font-weight: 500">
                        <div class="col-md-9 pl-4"><i class="fas fa-file mr-3"></i>${data[e].name}</div>
                        <div class="col-md-2">${dateFormat(data[e].date)}</div>
                        <div class="col-md-1">${bytesToSize(data[e].size)}</div>
                    </div>
                `
            }
            $(`#list-file`).html(html)
        }

    }
</script>

@endpush