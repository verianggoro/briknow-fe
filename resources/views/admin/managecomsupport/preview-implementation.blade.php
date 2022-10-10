<div class="navbar-bg sticky-top navbar-gray bg-gray pr-0 mr-0" style="height: 80px">
    <div class="d-flex justify-content-between flex-row-reverse header-nav">
        <div class="d-flex align-items-center px-4">
            <button type="button" class="close d-inline bg-tranparent text-light" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div>
            <nav class="prev-navbar navbar navbar-expand-lg main-navbar">
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="cardbg-white bg-white w-100 px-3 pb-5">
    <div class="row judul mt-4" style="min-height: 185px;">
        <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
            <img src="{{asset_app('assets/img/boxdefault.svg')}}" alt="" onerror="imgError(this)" id="prev_thumbnail" class="img-detail">
        </div>
        <div class="col-md-10 col-sm-12 pr-0 header-detail">
            <div class="row mt-4">
                <div class="col-md-8 col-sm-12 mb-2">
                    <div class="col-sm-12 px-0">
                        <a href="#" class="d-block font-weight-bold" style="font-size: 1.8rem; width: fit-content;margin-bottom: 0.5rem;line-height: 1.2;" id="prev_namaproject">-</a>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6" id="prev_const">
                            <span class="d-block font-weight-bold">Konsultan</span>
                            <a href="#" class="konsultan"><span>Internal</span></a>
                        </div>
                        <div class="col-md-5 col-sm-6 justify-content-end">
                            <span class="d-block font-weight-bold">Project Manager</span>
                            <span id="prev_pm">-</span>
                            <small class="d-block fs-12">
                                <i class="far fa-envelope"></i>
                                <a href="#" id="prev_emailpm">-</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row judul">
        <hr width="100%"/>
    </div>

    <div class="row judul">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="row">
                <h6 class="font-weight-bolder">Detail</h6>
            </div>
            <div class="row">
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Direktorat</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min" id="prev_direktorat">-</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Pemilik Proyek</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min" id="prev_divisi">-</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Tanggal Mulai</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_tglmulai">-</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Tanggal Selesai</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_tglselesai">-</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Status</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_status">-</div>
                </div>
            </div>

            <div class="row mt-4">
                <h6 class="font-weight-bolder">Tags</h6>
            </div>
            <div class="row col-md-12 px-0 font-weight-normal mb-4" id="prev_tag">
                <span class="badge badge-cyan-light text-dark mr-1">-</span>
            </div>

        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 pr-0 pl-4 text-justify">
            <div class="row" id="desc-preview">
            </div>
        </div>
    </div>

</div>