@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
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
                            <img src="{{config('app.url').'storage/'.$content->thumbnail??asset_app('assets/img/boxdefault.svg')}}"
                                 alt="{{$content->title}}" title="{{$content->title}}" width="150" height="150" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
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
</script>

@endpush