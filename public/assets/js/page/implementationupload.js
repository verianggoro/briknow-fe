let BE                      = '';
let uri                     = '';
let base_url                = '';
let token                   = '';
let old_photo               = '';
let old_attach              = [];
let old_attach_rollout      = [];
let old_attach_sosialisasi  = [];
let attach_pilot = [];
let input_attach_pilot = [];
let data_attach_pilot = []
let attach_rollout = [];
let input_attach_rollout = [];
let data_attach_rollout = []
let attach_sosialisasi = [];
let input_attach_sosialisasi = [];
let data_attach_sosialisasi = []
let project = [];
const slug = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
let formSubmitting = false;

let $table = $('#table')

//toast
const Toast3 = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// CHECK SELECT2 COMPONENTS
const checkSelect2Component = (previewClicked) => {
    const direktorat = $('#direktorat')
    const divisi = $('#divisi')
    const konsultant = $('#konsultant')
    const restrictedUser = $('#restricted-user')
    const tags = $('#tags')
    const checker = $('#checker')
    const signer = $('#signer')

    // NEXT BUTTON
    if(direktorat.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Direktorat tidak boleh kosong!'})
    }

    if(divisi.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Divisi tidak boleh kosong!'})
    }

    if(konsultant.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Konsultan/Vendor tidak boleh kosong!'})
    }

    if(restrictedUser.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'User yang mendapatkan Hak Akses tidak boleh kosong!'})
    }

    if(tags.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Tags tidak boleh kosong!'})
    }

    // PREVIEW BUTTON
    if(!checker.val() && previewClicked === 1){
        return Toast3.fire({icon: 'error',title: 'Checker tidak boleh kosong!'})
    }

    if(!signer.val() && previewClicked === 1){
        return Toast3.fire({icon: 'error',title: 'Signer tidak boleh kosong!'})
    }
}



// remove function
function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "token") {
        token = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "kunci") {
        BE = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "base_url") {
        base_url = metas[i].getAttribute('content');
    }
}

let optionkonsultant = '';
let optionuser = '';
let lesson_learned_urut = $("#urut").val();
let foto;
let attach_file=[];
let photo_file = uri+"/public/assets/img/boxdefault.svg";
var today = new Date();
// base waktu
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


$(document).ready(function () {
    var t = 0;
    let isValid = true;
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        first_page = $('#step-1'),
        allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');



    const slug = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
    if (slug !== 'implementation') {
        const url = `${uri}/form/implementation/upload/${slug}`
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function(data){
                const attach = data.data.data.attach_file
                for (let x = 0; x<attach.length; x++) {
                    if (attach[x].tipe === 'piloting') {
                        const array_p = {name: attach[x].nama, date: attach[x].updated_at, size: attach[x].size, url: attach[x].url_file}
                        input_attach_pilot.push(array_p)
                    } else if (attach[0].tipe === 'rollout') {
                        const array_r = {name: attach[x].nama, date: attach[x].updated_at, size: attach[x].size, url: attach[x].url_file}
                        input_attach_rollout.push(array_r)
                    } else if (attach[x].tipe === 'sosialisasi') {
                        const array_s = {name: attach[x].nama, date: attach[x].updated_at, size: attach[x].size, url: attach[x].url_file}
                        input_attach_sosialisasi.push(array_s)
                    }
                }
            },
            error : function(e){
                console.error(e);
            }
        });
    }

    allWells.hide();
    first_page.show();

    if ($('#piloting').is(':checked')) {
        $('#piloting_view').removeAttr("style")
    }
    if ($('#rollout').is(':checked')) {
        $('#rollout_view').removeAttr("style")
    }
    if ($('#sosialisasi').is(':checked')) {
        $('#sosialisasi_view').removeAttr("style")
    }

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            curStepBtn = $($(this).attr('id')),
            $item = $(this);

        if (curStepBtn == 's-1') {
            t = 1;
        }else if (curStepBtn == 's-2') {
            t = 2;
        }

        $item.removeClass('disable');
        $item.removeClass('btn-default');
        $item.removeAttr( "style" );

        if (!$item.hasClass('disable')) {
            if (t == 1) {
                jQuery('.s2').addClass('stepwizard-step-oren');
            }else if(t == 2) {
                jQuery('.s3').addClass('stepwizard-step-oren');
            }

            $item.addClass('btn-warning aktiv');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        isValid = true
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id");
        var pointer = 0;

        if (curStepBtn == 'step-1') {
            pointer = 1;
        }

        var nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
        var curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file'],input[type='date'],input[type='email'],select")

        $(".form-control").removeClass("is-invalid");
        $(".thumbnail-input").removeClass("is-invalid");
        $('#form').removeClass('was-validated');
        $('#form').addClass('was-validated');
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-control").addClass("is-invalid");
                $(curInputs[i]).closest(".thumbnail-input").addClass("is-invalid");
            }
        }

        // validasi ui
        var kolomvendor     = $('#jenispekerja').val();
        var kolomrestricted = $('#restricted').val();

        // console.log(t);
        if (t == 0) {
            // foto
            if($('#photo').hasClass('is-invalid')){
                $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
            }else{
                $("#thumbnail-prev").attr("style", "border:solid 1px #38c172;");
            }


            // direktorat
            if($('#direktorat').hasClass('is-invalid')){
                $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:red;");
            }else{
                $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:#38c172;");
            }

            // divisi
            if($('#divisi').hasClass('is-invalid')){
                $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:red;");
            }else{
                $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:#38c172;");
            }

            // jenis pekerja
            if($('#jenispekerja').val() === '1'){
                if($('#konsultant').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:#38c172;");
                }
            }

            // restricted user
            if($('#restricted').val() === '1'){
                var urut;
                if (kolomvendor === '1') {
                    urut = 1;
                }else{
                    urut = 0;
                }

                for (let i=1; i<=counterUser; i++) {
                    let $nextChild = $(`#restricted-user-${i}`).next().children().children()
                    if($(`#restricted-user-${i}`).hasClass('is-invalid')){
                        $nextChild.attr("style", "border-color:red;");
                    }else{
                        $nextChild.attr("style", "border-color:#38c172;");
                    }
                }
                // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
                /*if($('#restricted-user').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
                }*/
            }

        }else if(t === 1){
            // slide 2
            // console.log('masuk');

            if($('#link').hasClass('is-invalid')){
                $("[aria-labelledby='select2-link-container']").attr("style", "border-color:red;");
            }else{
                $("[aria-labelledby='select2-link-container']").attr("style", "border-color:#38c172;");
            }

            if (!$('#piloting').is(':checked') && !$('#rollout').is(':checked') && !$('#sosialisasi').is(':checked')) {
                isValid = false
                Toast3.fire({icon: 'error',title: 'Pilih setidaknya 1 tahap implementasi!'});
            }

            if ($('#piloting').is(':checked')) {
                isValid = checkEditor('editor-deskripsi')
                if($('#file-piloting').hasClass('is-invalid')){
                    $("#attach-wrap-piloting").attr("style", "border:1px solid #e3342f;");
                }else{
                    $("#attach-wrap-piloting").attr("style", "border:solid 1px #38c172;");
                }
            }

            if ($('#rollout').is(':checked')) {
                isValid = checkEditor('editor-rollout')
                if($('#file-rollout').hasClass('is-invalid')){
                    $("#attach-wrap-rollout").attr("style", "border:1px solid #e3342f;");
                }else{
                    $("#attach-wrap-rollout").attr("style", "border:solid 1px #38c172;");
                }
            }

            if ($('#sosialisasi').is(':checked')) {
                isValid = checkEditor('editor-sosialisasi')
                if($('#file-sosialisasi').hasClass('is-invalid')){
                    $("#attach-wrap-sosialisasi").attr("style", "border:1px solid #e3342f;");
                }else{
                    $("#attach-wrap-sosialisasi").attr("style", "border:solid 1px #38c172;");
                }
            }

            for(i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                }
            }

        }

        if (isValid){
            if (pointer > t) {
                // console.log('masuk');
                t = t+1;
                // console.log(t);
            }
            nextStepWizard.removeAttr('disabled').trigger('click');
        }

        // CALL CHECKER FOR SELECT2 COMPONENTS
        checkSelect2Component()
    });

    function checkEditor(instance) {
        let valid = true;
        let msgLength = CKEDITOR.instances[instance].getData().replace(/<[^>]*>/gi, '').length;

        $("#cke_"+instance).removeClass('border-none');
        if(msgLength <= 200){
            $("#cke_"+instance).attr("style", "border-color:#e3342f");
        }else{
            $("#cke_"+instance).attr("style", "border-color:#38c172");
        }

        if(msgLength  ===  0) {
            valid = false
            Toast3.fire({icon: 'error',title: 'Deskripsi tidak boleh kosong!'});
        } else if (msgLength <= 200) {
            valid = false
            Toast3.fire({icon: 'error',title: 'Deskripsi kurang dari 200 karakter!'});
        }

        return valid;
    }

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file']"),
            isValid = true;

        if (isValid){
            t = t-1;
            nextStepWizard.removeAttr('disabled').trigger('click');
        }
    });

    $('div.setup-panel div a.btn-warning').trigger('click');


    $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());
            if(e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if(prev.length) {
                    $(prev).select();
                }
            } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));

                if(next.length) {
                    $(next).select();
                } else {
                    if(parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

    $('#direktorat').select2({
        placeholder : 'Pilih Direktorat'
    });

    $('#tags').select2({
        placeholder : 'Cari Tags',
        tags: true
    });

    $('#checker').select2({
        placeholder : 'Cari Checker Project'
    });

    $('#restricted-user').select2({
        placeholder : 'Cari User'
    });

    $('#signer').select2({
        placeholder : 'Cari Signer Project'
    });

    $('#divisi').select2({
        placeholder : 'Pilih Unit Kerja'
    });
    getKonsultan();
    // getUser();

    $("#checker").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                // Query parameters will be ?pn=[term]
                return {
                    pn: params.term,
                    mode: 66
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    $("#signer").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                // Query parameters will be ?pn=[term]
                return {
                    pn: params.term,
                    mode: 66
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    $("#restricted-user").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 11
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    $('#link').select2({
        placeholder : 'Nama Proyek'
    });

    $("#link").select2({
        placeholder: 'Nama Proyek',
        tags: true,
        minimumInputLength: 1,
        templateResult: formatSelect,
        language: {
            inputTooShort: function (args) {
                return "Type at least 1 character";
            },
        },
        ajax: {
            url: `${base_url}/searchproject`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                // Query parameters will be ?search=[term]
                return {
                    search: params.term,
                    impl: 'Y'
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });


    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    $('#preview').click(function(){
        // check attach
        let inputPilot = $('input[name^=attach_piloting]').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        let inputRoll = $('input[name^=attach_rollout]').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        let inputSos = $('input[name^=attach_sosialisasi]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        const slug = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
        if (slug !== 'implementation') {
            for (let i=0; i<input_attach_pilot.length; i++) {
                if (inputPilot.includes(input_attach_pilot[i].url)) {
                    if (!attach_pilot.includes(input_attach_pilot[i])) {
                        attach_pilot.push(input_attach_pilot[i])
                    }
                }
            }
            for (let i=0; i<input_attach_rollout.length; i++) {
                if (inputRoll.includes(input_attach_rollout[i].url)) {
                    if (!attach_rollout.includes(input_attach_rollout[i])) {
                        attach_rollout.push(input_attach_rollout[i])
                    }
                }
            }
            for (let i=0; i<input_attach_sosialisasi.length; i++) {
                if (inputSos.includes(input_attach_sosialisasi[i].url)) {
                    if (!attach_sosialisasi.includes(input_attach_sosialisasi[i])) {
                        attach_sosialisasi.push(input_attach_sosialisasi[i])
                    }
                }
            }
        }


        $('#desc-preview').empty();
        if ($('#piloting').is(':checked')) {
            data_attach_pilot = []
            for (let i=0; i<attach_pilot.length; i++) {
                if (attach_pilot[i] instanceof File) {
                    const lastModifiedDate = attach_pilot[i].lastModifiedDate
                    data_attach_pilot.push({'name': attach_pilot[i].name, 'date':lastModifiedDate, 'size': attach_pilot[i].size})
                } else {
                    const lastModifiedDate = new Date(attach_pilot[i].date)
                    data_attach_pilot.push({'name': attach_pilot[i].name, 'date':lastModifiedDate, 'size': attach_pilot[i].size})
                }
            }
            appendDesc('Piloting', 'editor-deskripsi', data_attach_pilot)
        }

        if ($('#rollout').is(':checked')) {
            data_attach_rollout = []
            for (let i=0; i<attach_rollout.length; i++) {
                if (attach_rollout[i] instanceof File) {
                    const lastModifiedDate = attach_rollout[i].lastModifiedDate
                    data_attach_rollout.push({'name': attach_rollout[i].name, 'date':lastModifiedDate, 'size': attach_rollout[i].size})
                } else {
                    const lastModifiedDate = new Date(attach_rollout[i].date)
                    data_attach_rollout.push({'name': attach_rollout[i].name, 'date':lastModifiedDate, 'size': attach_rollout[i].size})
                }
            }
            appendDesc('Roll Out', 'editor-rollout', data_attach_rollout)
        }

        if ($('#sosialisasi').is(':checked')) {
            data_attach_sosialisasi = []
            for (let i=0; i<attach_sosialisasi.length; i++) {
                if (attach_sosialisasi[i] instanceof File) {
                    const lastModifiedDate = attach_sosialisasi[i].lastModifiedDate
                    data_attach_sosialisasi.push({'name': attach_sosialisasi[i].name, 'date':lastModifiedDate, 'size': attach_sosialisasi[i].size})
                } else {
                    const lastModifiedDate = new Date(attach_sosialisasi[i].date)
                    data_attach_sosialisasi.push({'name': attach_sosialisasi[i].name, 'date':lastModifiedDate, 'size': attach_sosialisasi[i].size})
                }
            }
            appendDesc('Sosialisasi', 'editor-sosialisasi', data_attach_sosialisasi)
        }

        let t_photo = uri+"/storage/"+$('#thumbnail').val();
        let t_divisi            = $('#divisi :selected').map((_, e) => e.getAttribute("data-value")).get();
        let t_direktorat            = $('#direktorat :selected').map((_, e) => e.getAttribute("data-value")).get();
        let t_email = $('#email').val();
        let date_mulai          = new Date($('#tgl_mulai').val());
        let t_tgl_mulai         = date_mulai.getDate()+" "+ months[date_mulai.getMonth()]+" "+date_mulai.getFullYear();

        let t_stat_project;
        let t_tgl_selesai;
        if ($('#stat_project').prop('checked')) {
            // waktu
            let temp_date           = new Date($('#tgl_selesai').val());
            t_tgl_selesai         = temp_date.getDate()+" "+ months[temp_date.getMonth()]+" "+temp_date.getFullYear();

            t_stat_project      = 'Selesai';
        }else{
            t_tgl_selesai = '-';
            t_stat_project      = 'On Progress';
        }

        $('#prev_namaproject').empty();
        $('#prev_pm').empty();
        $('#prev_emailpm').empty();
        $('#prev_divisi').empty();
        $('#prev_direktorat').empty();
        $('#prev_tglmulai').empty();
        $('#prev_tglselesai').empty();
        $('#prev_status').empty();
        /*if (photo_file === uri+"/public/assets/img/boxdefault.svg") {
            t_photo             = uri+"/storage/"+$('#thumbnail').val();
        }else{
            t_photo             = photo_file;
        }*/
        $('#prev_thumbnail').attr('src',`${t_photo}`);
        $('#prev_thumbnail').attr('alt',`${$('#nama_project').val()}`);
        $('#prev_namaproject').append(`${$('#nama_project').val()}`);
        $('#prev_pm').append($('#projectmanager').val());
        $('#prev_emailpm').append(`<i class="far fa-envelope mr-1"></i><a href="mailto:${t_email}">${t_email}</a>`);
        $('#prev_divisi').append(`${t_divisi}`);
        $('#prev_direktorat').append(`${t_direktorat}`);
        $('#prev_tglmulai').append(`${t_tgl_mulai}`);
        $('#prev_tglselesai').append(`${t_tgl_selesai}`);
        $('#prev_status').append(`${t_stat_project}`);

        if (isValid) {
            $('#modal-preview').modal({
                show : true
            });
        }
    });

    function appendDesc(step, editor, data) {
        const t_deskripsi = CKEDITOR.instances[editor].getData();
        let desc = `
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div class="preview-desc-head">${step}</div>
                    <div class="metodologi-isi wrap" id="prev_deskripsi">${t_deskripsi}</div>
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
                                <input type="text" style="border: none;" class="form-control" id="inlineFormInput-${editor}" placeholder="Search files..">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12" style="padding-left: 8px;">
                            <select style="border-radius: 8px;" class="form-control" id="select-${editor}" name="select-${editor}">
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
                                <div id="list-${editor}" class="list-files"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `
        $('#desc-preview').append(desc)
        renderList(data)

        $(`#inlineFormInput-${editor}`).keypress(function (e) {
            if (e.which === 13) {
                let a = data.filter(i => i.name.toLowerCase().includes($(this).val().toLowerCase()))
                renderList(a)
            }
        })

        $(`#select-${editor}`).on('change', function () {
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
            $(`#list-${editor}`).html(html)
        }

    }

});

function dateFormat(date) {
    return date.getDate()+" "+ months[date.getMonth()]+" "+date.getFullYear();
}

function formatSelect(project) {
    let contents = `<div class="d-flex align-items-center">`;
    if (project !== null && project !== undefined) {
        if (project.image !== null && project.image !== undefined) {
            let src = `${uri}/storage/${project.image}`
            contents += `<div><img src='${src}' alt="${project.text}" onerror="imgError(this)" width="50" height="50" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)"></div> `
        }
        contents += `<div>${project.text}</div>`
    }
    contents += `</div>`

    return $(contents);
}

$('#piloting').change(function () {
    if ($('#piloting').is(':checked')) {
        const attr = $('#file-piloting').attr('required');
        if (typeof attr === 'undefined' || attr === false) {
            if ($('#preview-piloting').children().length === 0) {
                $('#file-piloting').attr('required', true)
            }
        }
    } else {
        $('#file-piloting').attr('required', false)
    }
})

$('#rollout').change(function () {
    if ($('#rollout').is(':checked')) {
        const attr = $('#file-rollout').attr('required');
        if (typeof attr === 'undefined' || attr === false) {
            if ($('#preview-rollout').children().length === 0) {
                $('#file-rollout').attr('required', true)
            }
        }
    } else {
        $('#file-rollout').attr('required', false)
    }
})

$('#sosialisasi').change(function () {
    if ($('#sosialisasi').is(':checked')) {
        const attr = $('#file-sosialisasi').attr('required');
        if (typeof attr === 'undefined' || attr === false) {
            if ($('#preview-sosialisasi').children().length === 0) {
                $('#file-sosialisasi').attr('required', true)
            }
        }
    } else {
        $('#file-sosialisasi').attr('required', false)
    }
})

const getKonsultan = () => {
    var url = `${uri}/getconsultant`;
    $.ajax({
        url: url,
        type: "get",
        success: function(data){
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    optionkonsultant += `<option value='${data.data[index].id}' data-value='${data.data[index].nama}'>${data.data[index].nama}</option>`;
                }
            }
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

const getUser = () => {
    var url = `${uri}/getuser`;
    $.ajax({
        url: url,
        type: "get",
        success: function(data){
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    optionuser += `<option value='${data.data[index].id}' data-value='${data.data[index].name}'>${data.data[index].name}</option>`;
                }
            }
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

$('#jenispekerja').change(function(){
    var sample = $('select[name=jenispekerja] option').filter(':selected').val();
    if (sample == 0) {
        $('.content-worker').remove();
    }else if(sample == 1){
        var content = ` <div class="form-group row content-worker">
                            <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center label-cus-2">Pilih Konsultan/Vendor<span class='text-danger'>*</span></label>
                            <div class="col-md-10 col-sm-12">
                                <select class="select2 text-black form-control" id="konsultant" name="konsultant[]" multiple required>                                  
                                    ${optionkonsultant}
                                </select>
                            </div>
                        </div>`;
        $('#worker').append(content);
        $('#konsultant').on('select2:select', function (e) {
            if($('#konsultant').hasClass('is-invalid') || $('#konsultant').hasClass('is-valid')){
                if(this.value == ""){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:#38c172;");
                }
            }
        });
    }

    // set select2
    $('#konsultant').select2({
        placeholder : 'Pilih Konsultan/Vendor',
        tags: true
    });
});

if ($('#konsultant').hasClass('select2')) {
    // set select2
    $('#konsultant').select2({
        placeholder : 'Pilih Konsultan/Vendor',
        tags: true
    });
}

$('#restricted-old').change(function(){
    let sample = $('select[name=restricted] option').filter(':selected').val();
    let $restricted_content = $('#restricted_content')

    if (sample === 0) {
        $('.content-restricted').remove();
        $restricted_content.addClass('d-none')
    }else if(sample === 1){
        let content =   `
                        <div class="form-group row content-restricted">
                            <div class="col-md-12 col-sm-12">
                                <select class="select2 form-control" id="user" name="user[]" multiple required>
                                    ${optionuser}
                                </select>
                            </div>
                        </div>
                        `;
        $restricted_content.append(content);
        $restricted_content.removeClass('d-none')
    }

    // set select2
    $('#user').select2({
        placeholder : 'Pilih User'
    });
});

let counterUser = 1;
function addUserAccess() {
    let $restricted_content = $('#restricted_content')
    counterUser++;
    let id = "restricted-user-" + counterUser
    let content =   `
                        <div class="form-group row content-restricted">
                            <label for="" class="col-md-2 col-sm-12 col-form-label label-cus-2">User ${counterUser}</label>
                            <div class="col-md-10 col-sm-12">
                                <select name="user[]" id="${id}" class="restricted-user select2 form-control" placeholder='Masukan Personal Number' required></select>
                            </div>
                        </div>
                        `;

    $restricted_content.append(content);

    $('#'+id+'').on('select2:select', function (e) {
        if($('#'+id+'').hasClass('is-invalid') || $('#'+id+'').hasClass('is-valid')){
            // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
            if($('#'+id+'').hasClass('is-invalid')){
                document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
            }else if($('#'+id+'').hasClass('is-valid')){
                document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
            }
        }
    });

    $('#'+id+'').select2({
        placeholder : 'Cari User'
    });

    $('#'+id+'').select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 11
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

}

$('#restricted').change(function(){
    let sample = $('select[name=restricted] option').filter(':selected').val();
    let $restricted_content = $('#restricted_content')

    if (sample == 0) {
        $('.content-restricted').remove();
        $restricted_content.addClass('d-none')
    }else if(sample == 1){
        let content =   `
                        <div class="form-group row content-restricted">
                            <label for="" class="col-md-2 col-sm-12 col-form-label label-cus-2">User 1</label>
                            <div class="col-md-10 col-sm-12">
                                <select name="user[]" id="restricted-user-1" class="restricted-user select2 form-control" placeholder='Masukan Personal Number'  required></select>
                            </div>
                        </div>
                        `;

        $restricted_content.append(content);
        $restricted_content.removeClass('d-none')

        $('#restricted-user-1').on('select2:select', function (e) {
            if($('#restricted-user-1').hasClass('is-invalid') || $('#restricted-user-1').hasClass('is-valid')){
                var kolomvendor = $('#jenispekerja').val();
                var urut;
                if (kolomvendor === '1') {
                    urut = 1;
                }else{
                    urut = 0;
                }
                // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
                if($('#restricted-user-1').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
                }else if($('#restricted-user').hasClass('is-valid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
                }
            }
        });
    }

    // set select2
    $('#restricted-user-1').select2({
        placeholder : 'Cari User'
    });

    $("#restricted-user-1").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 11
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });
});


$('#stat_project').change(function(){
    if ($('#stat_project').prop('checked')) {
        var element = `
                        <div class="form-group row content-selesai">
                            <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai label-cus-2">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                            <div class="col-md-5 col-sm-12 content-selesai">
                                <input style="width: 80%; height: 40px" type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Tanggal selesai" required>
                            </div>
                        </div>
                    `;
        $('#form_tgl_selesai').append(element);
    } else {
        $('.content-selesai').remove();
    }
});

$('#photo').change(function(){
    if($('#photo').hasClass('is-invalid') || $('#photo').hasClass('is-valid')){
        if(this.value == ""){
            $("#photo").attr("style", "border-color:red;");
        }else{
            $("#photo").attr("style", "border-color:#38c172;");
        }
    }
});

$('#direktorat').change(function(){
    if ($(this).val() !== null) {
        cekDivisi();
    }
});

$('#link').change(function () {
    cekProject($(this).val())
})

function cekProject(id) {
    if (!isNaN(id)) {
        let url = `${uri}/getproject/${id}`;
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function()
            {
                $('.senddataloader').show();
            },
            success: function(data){
                $('.senddataloader').hide();
                project = data.data
                const divisi = data.data.divisi
                $("#direktorat").val(divisi.direktorat).trigger('change');
                $("#direktorat").attr("readonly", "readonly");
                $("#divisi").attr("readonly", "readonly");
                $('#is_new').val(0)
                /*$("#direktorat").select2(divisi.direktorat);
                $("#divisi").select2(divisi.id, divisi.divisi);*/
            },
            error : function(e){
                $('.senddataloader').hide();
                alert(e);
            }
        });
    } else {
        project = []
        $("#direktorat").val(null).trigger('change');
        $("#divisi").val(null).trigger('change');
        $("#direktorat").removeAttr('readonly');
        $("#divisi").removeAttr('readonly');
        $('#is_new').val(1)
    }
}

const cekDivisi = (valueOld = null) => {
    if($('#divisi').hasClass('is-invalid') || $('#divisi').hasClass('is-valid')){
        if(this.value == ""){
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:#38c172;");
        }
    }

    var direktorat  = $('select[name=direktorat] option').filter(':selected').val();
    var url = `${uri}/getdivisi/${direktorat}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.pagination').remove();

            $("#divisi option").each(function() {
                $(this).remove();
            });

            $('.senddataloader').show();
        },
        success: function(data){
            var option = "<option value='' selected disabled>Pilih Unit Kerja</option>";
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    if (valueOld !== null) {
                        if (valueOld === data.data[index].id) {
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`;
                        }else{
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        }
                    } else if (project.length !== 0) {
                        if (project.divisi.id === data.data[index].id) {
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`;
                        }else{
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        }
                    } else{
                        option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                    }
                }
            }
            $('#divisi').append(option);
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

let divisiVal = $('#divisi').val();
if (divisiVal !== "" && divisiVal !== null) {
    divisiVal   =   parseInt(divisiVal);
    cekDivisi(divisiVal);
}

$('#divisi').change(function(){
    if($('#divisi').hasClass('is-invalid') || $('#divisi').hasClass('is-valid')){
        if(this.value == ""){
            $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:#38c172;");
        }
    }
});

$('#konsultant').on('select2:select', function (e) {
    if($('#konsultant').hasClass('is-invalid') || $('#konsultant').hasClass('is-valid')){
        if(this.value == ""){
            document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:red;");
        }else{
            document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:#38c172;");
        }
    }
});

$('#restricted-user').on('select2:select', function (e) {
    if($('#restricted-user').hasClass('is-invalid') || $('#restricted-user').hasClass('is-valid')){
        var kolomvendor = $('#jenispekerja').val();
        var urut;
        if (kolomvendor === '1') {
            urut = 1;
        }else{
            urut = 0;
        }
        if($('#restricted-user').hasClass('is-invalid')){
            document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
        }else if($('#restricted-user').hasClass('is-valid')){
            document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
        }
    }
});

$("#save").click(function(){
    formSubmitting = true;
    $('#form').submit();
    $('.senddataloader').show();
});

$("#send").click(function(){
    v = $("#send").val();
    if (v == 1) { //SEND
        pesan = "Anda yakin akan mengirim Proyek ini?";
        btn_txt = "SEND";
    } else if (v == 2) { //PUBLISH
        pesan = "Anda yakin akan menerbitkan Proyek ini?";
        btn_txt = "PUBLISH";
    } else if (v == 3) { //SEND & APPROVE
        pesan = "Anda yakin ingin menyimpan dan menyetujui Proyek ini?";
        btn_txt = "SAVE & APPROVE";
        // pesan = "Anda yakin akan mengirim dan menyetujui Proyek ini?"; //versi detail
    }
    swal.fire({ title: pesan, text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: btn_txt, cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            try {
                let cek_edit = document.getElementById('id').value;
                if (typeof(cek_edit) == 'undefined') {
                    $("#project").val('1');
                    $('#form').submit();
                    $('.senddataloader').show();
                }else{
                    $('.senddataloader').show();
                    $('#form').attr('action',uri+"/kontribusi/update");
                    // console.log(uri+"/kontribusi/update");

                    $("#project").val('1');
                    $('#form').submit();
                }
            } catch (error) {
                $('.senddataloader').hide();
                $("#project").val('1');
                $('#form').submit();
            }
        }
    });
});

$(".ll_min").click(function(){
    var urutannya   =    $('.ll_min').index(this);
    removeFieldls(urutannya);
});

$('#stat_project').change(function () {
    if ($('#stat_project').is(':checked')) {
        $('#tgl_selesai').change(function () {
            let res = false;
            if($('#tgl_mulai').val() !== '' && $('#tgl_selesai').val() !== ''){
                if($('#tgl_selesai').val() < $('#tgl_mulai').val()){
                    Toast3.fire({icon: 'error',title: 'Tanggal Selesai tidak boleh kurang dari Tanggal Mulai'});
                    res = true;
                }
            }

            if(res){
                $('#tgl_selesai').val('');
            }
        });
    }
});

$('#tgl_mulai').change(function () {
    let res = false;
    if($('#tgl_mulai').val() !== '' && $('#tgl_selesai').val() !== ''){
        if($('#tgl_mulai').val() > $('#tgl_selesai').val()){
            Toast3.fire({icon: 'error',title: 'Tanggal Mulai Tidak Boleh Lebih Dari Tanggal Selesai'});
            res = true;
        }
    }
    if(res){
        $('#tgl_mulai').val('');
    }
});

const removeFieldls = (urutan) => {
    if ($('.ll_field').length > 1) {
        if (confirm('Apakah Anda Yakin Menghapusnya ?')) {
            $('.ll_field')[urutan].remove();
            urutFields();

            if ($('.ll_field').length <= 1) {
                $('.ll_min').attr("class","ll_min ll_min_disabled");
            }else{
                $('.ll_min').attr("class","ll_min");
            }
        }
    }
}

const urutFields = () => {
    var urut_temp  = $('.ll_field').length + 1;
    var u          = 1;
    $('.control_ll').empty();
    for (let index = 0; index < urut_temp; index++) {
        $('.control_ll').eq(index).html(`<img class='ll_min' src='${uri}/assets/img/datatables/details_close.png'/> ${u}`);
        u++;
    }
    $(".ll_min").click(function(){
        var urutannya   =    $('.ll_min').index(this);
        removeFieldls(urutannya);
    });
}

$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        if($(this).prop("checked") == true){
            $($(this).data('id')).show();
        }
        else if($(this).prop("checked") == false){
            $($(this).data('id')).hide();

        }
    });
});

const $photo = $('#photo')
let $dropWrap = $('.dropzones-wrapper')
$dropWrap.on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragover');
});
$dropWrap.on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass('dragover');
});
$dropWrap.on('drop', function(e) {
    /*e.preventDefault();
    e.stopPropagation();*/
    $(this).removeClass('dragover');
});

$photo.change(function(){
    readThumbnail(this);
});

$('#file-piloting').change(function(){
    readFile(this, 'piloting');
});

$('#file-rollout').change(function(){
    readFile(this, 'rollout');
});

$('#file-sosialisasi').change(function(){
    readFile(this, 'sosialisasi');
});

function readThumbnail(input) {
    const type_file = ['image/png', 'image/jpg', 'image/jpeg']
    if (!type_file.includes(input.files[0].type)) {
        $photo.val('')
        Toast3.fire({icon: 'error',title: 'Tipe file tidak sesuai !'});
        return;
    }

    $('#drop-wrap').css({border: 'none'})
    $('#thumbnail-prev').remove()
    $('#thumbnail-del').remove()
    $('#thumbnail-loading').remove()
    let src = URL.createObjectURL(input.files[0])
    photo_file = src
    let imagePrev = `
        <img id="thumbnail-prev" class="blur-image thumbnail-prev" src="${src}" alt="thumbnail" />
        <div id="thumbnail-del" title="Hapus" class="thumbnail-delete d-flex align-items-center justify-content-center d-none" onclick="removeThumbnailPreview()">
            <i class="fas fa-times" style="font-size: 24px"></i>
        </div>
        <div id="thumbnail-loading" style="height: inherit; width: inherit; position:absolute; z-index: 88;" class="d-flex align-items-center justify-content-center">
            <i class="fas fa-circle-notch fa-spin" style="font-size: 70px"></i>
        </div>
    `

    $('#thumbnail-desc').append($(imagePrev).hide().fadeIn(300));

    if($('#form').hasClass('was-validated')){
        $("#thumbnail-prev").attr("style", "border:solid 1px #38c172;");
    }

    let form_data = new FormData();
    form_data.append('thumbnail', input.files[0]);

    $.ajax({
        url: uri+'/up/thumbnail',
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(res){
            $('#hidden-thumbnail').empty()
            $('#thumbnail-loading').fadeOut(200, function () {$(this).remove()});
            $('#thumbnail-del').removeClass('d-none')
            $('#thumbnail-prev').removeClass('blur-image')

            let hidden_thumb = `<input type="hidden" class="d-none" id="thumbnail" name="thumbnail" value="${res}">`
            $('#hidden-thumbnail').append(hidden_thumb);
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Upload Gagal'});
            $('#thumbnail-prev').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail').remove().val('');
            $('#thumbnail-del').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail-loading').remove();
            $('#drop-wrap').css({border: 'dashed 1px black'})
            $photo.val('')

            if($('#form').hasClass('was-validated')){
                $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
            }
        },
    });
}

function readFile(input, step) {
    const type_file = ['application/x-zip-compressed', 'zip', 'rar']
    const name_file = input.files[0].name;
    if (type_file.includes(input.files[0].type) || type_file.includes(name_file.split('.')[1])) {
        $('#file-'+step+'').val('')
        Toast3.fire({icon: 'error',title: 'Tipe file tidak sesuai !'});
        return;
    }
    for (let f in input.files) {
        if (input.files[f] instanceof File) {
            showPreview(input.files[f], step)
        }
    }
}

function showPreview(file, step) {
    const $preview = $('#preview-'+step+'')
    const timemillis = Date.now()
    let htmlPreview = [
        '<div id="prev-'+step+timemillis+'" class="d-flex align-items-center mb-3" style=" width: 55%; height: 40px;">',
            '<div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">',
                '<div class="d-flex align-items-center justify-content-between" style="width: 100%">',
                    '<div class="d-flex align-items-center justify-content-center">',
                        '<i class="fas fa-file mr-3"></i>',file.name,
                    '</div>',
                    `<div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Cancel" onclick="removePreview(this, \'cancel\', ${step}, ${file})">`,
                        '<i class="fas fa-circle-notch fa-spin"></i>',
                    '</div>',
                '</div>',
            '</div>',
            '<div id="loading" class="d-flex align-items-center" style="width: 20px;">',
                '<p class="m-0 d-flex align-items-center">Uploading&nbsp;<span class="loadings">...</span></p>',
            '</div>',
        '</div>'
    ]

    // $preview.removeClass('hidden');
    $preview.append($(htmlPreview.join('')).hide().fadeIn(300))

    let $container = $('#prev-'+step+timemillis+'')
    if (step === 'piloting') {
        attach_pilot.push(file)
    } else if (step === 'rollout') {
        attach_rollout.push(file)
    } else if (step === 'sosialisasi') {
        attach_sosialisasi.push(file)
    }
    // let id = $container.attr('id')

    /*if($('#form').hasClass('was-validated')){
        $("#attach-wrap-"+step).attr("style", "border:solid 1px #38c172;");
    }*/

    let form_data = new FormData();
    form_data.append(`attach_${step}`, file);

    $.ajax({
        url: uri+`/up/attach_${step}`,
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(res){
            let $first = $container.children().first().children()
            $first.addClass('detail-prev')

            let $click = $first.children().last()
            $click.prop("onclick", null).off("click");
            $click.on('click', function () {
                removePreview(this, 'delete', step, file)
            })
            let $icon = $click.find(':first-child')
            $icon.removeClass('fa-circle-notch fa-spin')
            $icon.addClass('fa-times')
            $icon.prop('title', 'Delete')

            let $last = $container.children().last()
            $last.children().remove()
            $last.append('<div class="d-flex align-items-center" style="border-radius: 50%; padding: 6px 5px 4px; border: 2px solid #218838; color: #218838">' +
                '<i style="font-size: 10px" class="fas fa-check"></i></div>')

            const input_hidden = `<input type="hidden" name="attach_${step}[]" id="attach" value="${res}">`
            $('#prev-'+step+timemillis).append(input_hidden)
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Upload Gagal'});
            removePreview('prev'+timemillis, 'cancel', file)
        },
    });
}

function removePreview(id, type, step, file = null) {
    const $preview = $('#preview-'+step+'')
    if (type === 'cancel') {
        $(id).parent().parent().parent().fadeOut(300, function () {
            $(this).remove()
            if ( $preview.children().length === 0 ) {
                $('#file-'+step+'').val('')
            }
            if($('#form').hasClass('was-validated')){
                $('#attach-wrap-'+step+'').attr("style", "border:1px solid #e3342f;");
            }
        });
        if (step === 'piloting') {
            let index = attach_pilot.indexOf(file);
            attach_pilot.splice(index, 1);
        } else if (step === 'rollout') {
            let index = attach_rollout.indexOf(file);
            attach_rollout.splice(index, 1);
        } else if (step === 'sosialisasi') {
            let index = attach_sosialisasi.indexOf(file);
            attach_sosialisasi.splice(index, 1);
        }
    } else {
        let $last = $(id).parent().parent().parent().children().last()
        let form_data = new FormData();
        form_data.append(`attach_${step}`, $last.val());
        form_data.append('isNew', slug === 'implementation' ? "1" : "0");
        $.ajax({
            url: uri+`/delete/attach_${step}`,
            data: form_data,
            type: 'post',
            contentType: false,
            processData: false,
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function(response) {
                $(id).parent().parent().parent().fadeOut(300, function () {
                    $(this).remove()
                    if ( $preview.children().length === 0 ) {
                        $('#file-'+step+'').val('')
                        const attr = $('#file-'+step+'').attr('required');
                        if (typeof attr === 'undefined' || attr === false) {
                            $('#file-'+step+'').attr('required', true)
                        }
                        if($('#form').hasClass('was-validated')){
                            $('#attach-wrap-'+step+'').attr("style", "border:1px solid #e3342f;");
                        }
                    }
                });

                if (step === 'piloting') {
                    let index = attach_pilot.indexOf(file);
                    attach_pilot.splice(index, 1);
                } else if (step === 'rollout') {
                    let index = attach_rollout.indexOf(file);
                    attach_rollout.splice(index, 1);
                } else if (step === 'sosialisasi') {
                    let index = attach_sosialisasi.indexOf(file);
                    attach_sosialisasi.splice(index, 1);
                }

                if (slug !== 'implementation') {
                    const hidden_del = `<input type="hidden" name="temp_delete[]" value="${response.request.path}">`
                    $('#temp_delete').append(hidden_del)
                }
            },
            error: function () {
                Toast3.fire({icon: 'error',title: 'Delete Gagal'});
            },
        });
    }

    /*if ( $preview.children().length === 0 ) {
        $preview.addClass('hidden')
    }*/
}

function removeThumbnailPreview() {
    let form_data = new FormData();
    form_data.append('thumbnail', $('#thumbnail').val());
    form_data.append('isNew', slug === 'implementation' ? "1" : "0");
    $.ajax({
        url: uri+'/delete/thumbnail',
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(response){
            $('#thumbnail-prev').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail').remove().val('');
            $('#thumbnail-del').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail-loading').remove();
            $('#drop-wrap').css({border: 'dashed 1px black'})
            $photo.val('')

            if($('#form').hasClass('was-validated')){
                $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
            }

            const attr = $('#photo').attr('required');
            if (typeof attr === 'undefined' || attr === false) {
                $('#photo').attr('required', true)
            }

            if (slug !== 'implementation') {
                const hidden_del = `<input type="hidden" name="temp_delete[]" value="${response.request.path}">`
                $('#temp_delete').append(hidden_del)
            }
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Delete Gagal'});
        },
    });
}

window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (formSubmitting) {
            return undefined;
        }
        let temp_upload = [];
        if ($('#thumbnail').val()) {
            temp_upload.push($('#thumbnail').val())
        }
        if ($('#attach').val()) {
            $('input#attach').each(function () {
                temp_upload.push($(this).val())
            })
        }

        if (temp_upload.length > 0) {

            let form_data = new FormData();
            form_data.append('temp', temp_upload.toString());

            $.ajax({
                url: uri+'/deleteonleave',
                data: form_data,
                type: 'post',
                contentType: false,
                processData: false,
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                },
                success: function(){
                    return undefined;
                },
                error: function () {
                    return undefined;
                },
            });
        }

        return undefined;
    });
};

function imgError(image) {
    let r = Math.floor(Math.random() * 9) + 1
    image.onerror = "";
    image.src = `${uri}/assets/img/news/img0${r}.jpg`;
    return true;
}
