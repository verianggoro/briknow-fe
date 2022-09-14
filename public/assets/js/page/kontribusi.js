let BE                      = '';
let uri                     = '';
let base_url                = '';
let token                   = '';
let old_photo               = '';
let old_attach              = [];
let old_attach_rollout      = [];
let old_attach_sosialisasi  = [];

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

// CHECK FILEPOND COMPONENTS
const checkFilepondComponent = (previewClicked) => {
    const photo = $('#photo')
    const attach = $('#attach')
    const oldAttachType = $('.old_attach_type')

    // NEXT BUTTON
    if(photo.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Thumbnail Project tidak boleh kosong!'})
    }else{
        $("[id='photo']").attr("style", "border-color:#38c172;");
    }

    // PREVIEW BUTTON
    const checkFileUploaded = attach[0].innerText.includes('Upload complete')
    let cekFileExisting     = attach[0].querySelectorAll('.filepond--item').length
    console.log(cekFileExisting);
    if(!checkFileUploaded && previewClicked === 1 && cekFileExisting === 0){
        return Toast3.fire({icon: 'error',title: 'Dokumen Project tidak boleh kosong!'})
    }
}

// editing
old_photo   =   $('#old_photo').val();
var urut = 0;
var inputs = document.getElementsByClassName('old_attach'),
    temp  = [].map.call(inputs, function( input ) {

        var size = document.getElementsByClassName('old_attach_size')[urut];
        var type = document.getElementsByClassName('old_attach_type')[urut];

        old_attach.push({
            nama : input.value,
            size : size.value,
            type : type.value,
        });
        urut++;
    });
// console.log(old_attach);

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

document.addEventListener('DOMContentLoaded', function() {
    FilePond.registerPlugin(
        FilePondPluginFileEncode,
        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation
    );

    // photo
    const inputfoto  = document.querySelector('input[id="photo"]');
    foto       = FilePond.create( inputfoto,
        {
            allowFileTypeValidation         : true,
            acceptedFileTypes               : ['image/png','image/jpg','image/jpeg'],
            allowImagePreview               : true,
            labelIdle                       : "Pilih Foto",
            imagePreviewHeight              : 170,
            imageCropAspectRatio            : '1:1',
            imageResizeTargetWidth          : 200,
            imageResizeTargetHeight         : 200,
            stylePanelLayout                : 'compact square',
            styleLoadIndicatorPosition      : 'center bottom',
            styleProgressIndicatorPosition  : 'right bottom',
            styleButtonRemoveItemPosition   : 'left bottom',
            styleButtonProcessItemPosition  : 'right bottom',
            fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                resolve(type);
            })
        });

    if (typeof(old_photo) !== 'undefined') {
        foto.files = [
            {
                source: old_photo,
                options: {
                    type: 'local',
                    file: {
                        name: old_photo,
                        size: 3001025,
                        type: 'image/png'
                    },
                }
            }
        ];
    }

    let pondBox = document.querySelector('.filepond--root');
    pondBox.addEventListener('FilePond:processfile', e => {
        photo_file = uri+"/storage/"+foto.getFile().serverId;
        if (photo_file === 'undefined') {
            photo_file = uri+"/public/assets/img/boxdefault.svg";
        }
        // console.log('photo nya : ' +foto.getFiles());
    });

    foto.setOptions({
        name : 'photo',
        allowRemove: true,
        server: {
            url:uri+'/up/photo',
            headers:{
                'X-CSRF-TOKEN' : `${csrf}`,
            }
        }
    });
});


FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
);
// attach
const inputattach       = document.querySelector('input[id="attachPiloting"]');
let attach              = FilePond.create(inputattach,
    {
        labelIdle           : `<div><h5>Pilih Dokumen Anda <span class="fa fa-file"></span></h5></div>`,
        allowImagePreview   : true,
        allowDrop           : false,
        allowMultiple       : true,
        allowFileEncode     : true,
        allowFileSizeValidation : true,
        maxFileSize         : "100000",
        maxTotalFileSize    : "1000000000",
        name                : "attachPiloting[]"
    });

    let tamping     = [];
    // console.log(old_attach);
    if (typeof(old_attach) !== 'undefined') {
        for (let index = 0; index < old_attach.length; index++) {
            tamping.push(
                {
                    source: old_attach[index].nama,
                    options: {
                        type: 'local',
                        file: {
                            name: old_attach[index].nama,
                            size: parseInt(old_attach[index].size),
                            type: old_attach[index].type
                        },
                    }
                },
            );
        }
    }
    // console.log(tamping);
    attach.files    = tamping;
    attach_file     = tamping;

// attach rollout
const inputRollout      = document.querySelector('input[id="attachRollout"]');
let attachrolout        = FilePond.create(inputRollout,
    {
        labelIdle           : `<div><h5>Pilih Dokumen Anda <span class="fa fa-file"></span></h5></div>`,
        allowImagePreview   : true,
        allowDrop           : false,
        allowMultiple       : true,
        allowFileEncode     : true,
        allowFileSizeValidation : true,
        maxFileSize         : "100000",
        maxTotalFileSize    : "1000000000",
        name                : "attachRollout[]"
    });

let tampingrollout     = [];
// console.log(old_attach);
if (typeof(old_attach_rollout) !== 'undefined') {
    for (let index = 0; index < old_attach_rollout.length; index++) {
        tampingrollout.push(
            {
                source: old_attach_rollout[index].nama,
                options: {
                    type: 'local',
                    file: {
                        name: old_attach_rollout[index].nama,
                        size: parseInt(old_attach_rollout[index].size),
                        type: old_attach_rollout[index].type
                    },
                }
            },
        );
    }
}
// console.log(tamping);
attachrolout.files    = tamping;
attachrolout          = tamping;

//attach dokumentasi
const inputSosialisasi      = document.querySelector('input[id="attachSosialisasi"]');
let attachSosialisasi        = FilePond.create(inputSosialisasi,
    {
        labelIdle           : `<div><h5>Pilih Dokumen Anda <span class="fa fa-file"></span></h5></div>`,
        allowImagePreview   : true,
        allowDrop           : false,
        allowMultiple       : true,
        allowFileEncode     : true,
        allowFileSizeValidation : true,
        maxFileSize         : "100000",
        maxTotalFileSize    : "1000000000",
        name                : "attachSosialisasi[]"
    });

let tampingSosialisasi     = [];
// console.log(old_attach);
if (typeof(old_attach_sosialisasi) !== 'undefined') {
    for (let index = 0; index < old_attach_sosialisasi.length; index++) {
        tampingSosialisasi.push(
            {
                source: old_attach_sosialisasi[index].nama,
                options: {
                    type: 'local',
                    file: {
                        name: old_attach_sosialisasi[index].nama,
                        size: parseInt(old_attach_sosialisasi[index].size),
                        type: old_attach_sosialisasi[index].type
                    },
                }
            },
        );
    }
}
// console.log(tamping);
attachSosialisasi.files    = tamping;
attachSosialisasi          = tamping;

let pondBox2 = document.querySelector('.filepond--root');
pondBox2.addEventListener('FilePond:processfile', e => {
    // referensi
    // https://stackoverflow.com/questions/57157019/filepond-jquery-get-file-name-that-was-dragged-an-dropped
    // https://pqina.nl/filepond/docs/patterns/api/filepond-instance/#events
    // url file getFile().serverId
    // url file getFile().filename
    // url file getFile().filenameWithoutExtension
    // url file getFile().fileType
    attach_file.push(attach.getFile());
    // console.log('array nya : ' +attach_file);
});

pondBox2.addEventListener('FilePond:removefile', (e,file) => {
    attach_file = [];
    for (let index = 0; index <= attach.getFiles().length-1; index++) {
        attach_file.push(attach.getFile(index));
    }
    // console.log('array nya : ' +attach_file);
});

attach.setOptions({
    name : 'attach',
    allowRemove: true,
    server: {
        url:uri+'/up/attach',
        headers:{
            'X-CSRF-TOKEN' : `${csrf}`,
        }
    }
});

$(document).ready(function () {
    var t = 0;
    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            first_page = $('#step-1'),
            allNextBtn = $('.nextBtn');
            allPrevBtn = $('.prevBtn');

    allWells.hide();
    first_page.show();

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
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id");
        var pointer = 0;

        if (curStepBtn == 'step-1') {
            pointer = 1;
        }

        var nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
        var curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file'],input[type='date'],input[type='email'],select"),
            isValid = true;

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
                $("[id='photo']").attr("style", "border-color:red;");
            }else{
                $("[id='photo']").attr("style", "border-color:#38c172;");
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
                // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
                if($('#restricted-user').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
                }
            }

        }else if(t == 1){
            // slide 2
            // console.log('masuk');
            var msgLengthDeskripsi = CKEDITOR.instances['editor-deskripsi'].getData().replace(/<[^>]*>/gi, '').length;
            var msgLengthRollout = CKEDITOR.instances['editor-rollout'].getData().replace(/<[^>]*>/gi, '').length;
            var msgLengthSosialisasi = CKEDITOR.instances['editor-sosialisasi'].getData().replace(/<[^>]*>/gi, '').length;
            // console.log(msgLengthDeskripsi);

            // validasi ui
            if(msgLengthDeskripsi <= 200){
                $("#cke_editor-deskripsi").attr("style", "border-color:red;");
            }else{
                $("#cke_editor-deskripsi").attr("style", "border-color:#38c172;");
            }

            if(msgLengthRollout <= 200){
                $("#cke_editor-metodologi").attr("style", "border-color:red;");
            }else{
                $("#cke_editor-metodologi").attr("style", "border-color:#38c172;");
            }

            // tags
            if (kolomvendor === '1' && kolomrestricted === '1') {
                urut = 2;
            }else if (kolomvendor === '1' || kolomrestricted === '1' ) {
                urut = 1;
            }else{
                urut = 0;
            }
            if($('#tags').hasClass('is-invalid')){
                document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
            }else{
                document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
            }

            // validasi alert
            if(msgLengthDeskripsi  ==  0) {
                Toast3.fire({icon: 'error',title: 'Deskripsi tidak boleh kosong!'});
            } else if (msgLengthDeskripsi <= 200) {
                Toast3.fire({icon: 'error',title: 'Deskripsi kurang dari 200 karakter!'});
            }else if (msgLengthRollout ==  0) {
                Toast3.fire({icon: 'error',title: 'Metodologi tidak boleh kosong!'});
            } else if (msgLengthRollout <= 10) {
                Toast3.fire({icon: 'error',title: 'Metodologi kurang dari 10 karakter!'});
            }else if($('#tags').hasClass('is-invalid')){
                Toast3.fire({icon: 'error',title: 'Tags tidak boleh kosong!'})
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
        checkFilepondComponent()
    });

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
    // console.log(`${base_url}/searchuser/`);
    $("#checker").select2({
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
                    mode: 66
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

    $("#signer").select2({
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
                    mode: 66
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

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    $('#preview').click(function(){
        // CHECK SELECT2 COMPONENT
        let isClicked = 1
        const check = !(checkFilepondComponent(isClicked) || checkSelect2Component(isClicked))

        if(check){
            isClicked = 0
            // change name filpond attach
            $("input[name='attach']").attr('name','attach[]');

            // init
            // if (typeof(old_photo) !== 'undefined') {
            //     var t_photo             = uri+"/storage/"+old_photo;
            // }else{
            //     var t_photo             = photo_file;
            // }
            if (photo_file == uri+"/public/assets/img/boxdefault.svg") {
                var t_photo             = uri+"/storage/"+old_photo;
            }else{
                var t_photo             = photo_file;
            }
            var t_direktorat        = $('#direktorat').val();
            var t_divisi            = $('#divisi :selected').map((_, e) => e.getAttribute("data-value")).get();
            var t_nama_project      = $('#nama_project').val();

            // waktu mulai
            var temp_date           = new Date($('#tgl_mulai').val());
            var t_tgl_mulai         = temp_date.getDate()+" "+ months[temp_date.getMonth()]+" "+temp_date.getFullYear();
            // console.log("Date inputan user: "+$('#tgl_mulai').val());
            // console.log("temp_date: "+temp_date);
            // console.log("t_tgl_mulai: "+t_tgl_mulai);
            // console.log(temp_date.getUTCHours()); // Hours
            // console.log(temp_date.getUTCMinutes());
            // console.log(temp_date.getUTCSeconds());

            var t_stat_project;
            var t_tgl_selesai;
            if ($('#stat_project').prop('checked')) {
                // waktu
                var temp_date           = new Date($('#tgl_selesai').val());
                var t_tgl_selesai         = temp_date.getDate()+" "+ months[temp_date.getMonth()]+" "+temp_date.getFullYear();

                t_stat_project      = 'Selesai';
            }else{
                t_tgl_selesai = '-';
                t_stat_project      = 'On Progress';
            }
            var t_projectmanager    = $('#projectmanager').val();
            var t_email             = $('#email').val();
            var t_jenispekerja      = $('#jenispekerja').val();
            var vendor;
                if (t_jenispekerja == 1) {
                    // vendor = $('#konsultant').find(":selected").attr("data-value");
                    vendor = $("#konsultant :selected").map((_, e) => e.getAttribute("data-value")).get();
                }else{
                    vendor = 'Internal';
                }
            var t_user = $('#user').val();
            var t_deskripsi = CKEDITOR.instances['editor-deskripsi'].getData();
            var t_metodologi = CKEDITOR.instances['editor-metodologi'].getData();
            var t_tags = $('#tags').val();
            var t_lesson = $('.lesson').map((_, e) => e.value).get();
            var t_lesson_keterangan = $('.lesson_keterangan').map((_, e) => e.value).get();
            var t_attach = attach_file;
            var t_checker = $('#checker').val();
            var t_signer = $('#signer').val();


            // empty
            $('#prev_namaproject').empty();
            $('#prev_pm').empty();

            // konsultant
            $('#prev_konsultant').empty();
            var tampung_vendor = "";
            if (t_jenispekerja == 1) {
                if (typeof vendor !== 'undefined') {
                    if (vendor.length > 1) {
                        for (let index = 0; index < vendor.length; index++) {
                            if (index == vendor.length - 1) {
                                tampung_vendor += `<span class='fs-10'>${vendor[index]}</span>`;
                            }else{
                                tampung_vendor += `<span class='fs-10'>${vendor[index]}</span>`+", ";
                            }
                        }
                    }else{
                        tampung_vendor = `<span class='fs-10'>${vendor}</span>`;
                    }
                }else{
                    tampung_vendor = vendor;
                }
            }else{
                tampung_vendor = vendor;
            }
            $('#prev_emailpm').empty();
            $('#prev_divisi').empty();
            $('#prev_tglmulai').empty();
            $('#prev_tglselesai').empty();
            $('#prev_status').empty();
            $('#prev_keyword').empty();
            var tampung_tags = "";
            if (t_tags.length > 1) {
                for (let index = 0; index < t_tags.length; index++) {
                    tampung_tags += `<span class="badge badge-cyan-light text-dark mr-1 mb-2">${t_tags[index]}</span>`;
                }
            }else{
                tampung_tags = `<span class="badge badge-cyan-light text-dark mr-1 mb-2">${t_tags}</span>`;
            }
            $('#prev_deskripsi').empty();
            $('#prev_metodologi').empty();
            $('#prev_lessonlearned').empty();
            var tampung_lesson = "";
            if (typeof t_lesson !== 'undefined') {
                if (t_lesson.length > 1) {
                    var urutin=1;
                    for (let index = 0; index < t_lesson.length; index++) {
                        if (t_lesson[index] === "" && t_lesson_keterangan[index] === "") {
                        }else{
                            tampung_lesson += `<tr>
                                                    <td id="td-metodologi" style="text-align:center !important;"><span>${urutin++}</span></td>
                                                    <td id="td-metodologi"><span>${t_lesson[index]}</span></td>
                                                    <td id="td-metodologi"><span>${t_lesson_keterangan[index]}</span></td>
                                                </tr>`;
                        }
                    }
                }else{
                    tampung_lesson = `<tr>
                                            <td id="td-metodologi"><span>1</span></td>
                                            <td id="td-metodologi"><span>${t_lesson}</span></td>
                                            <td id="td-metodologi"><span>${t_lesson_keterangan}</span></td>
                                        </tr>`;
                }
            }else{
                tampung_lesson += `<tr>
                                        <td id="td-metodologi"><span>-</span></td>
                                        <td id="td-metodologi"><span>-</span></td>
                                        <td id="td-metodologi"><span>-</span></td>
                                    </tr>`;
            }

            $('#prev_document').empty();
            var tampung_attach = "";
            // if (typeof(old_attach) !== 'undefined') {
            //     var urutin=0;
            //     for (let index = 0; index < old_attach.length; index++) {
            //         tampung_attach += `<tr>
            //                                 <td id="td-attachment" class="pl-2"><small>${old_attach[index].nama}</small></td>
            //                                 <td id="td-attachment" class="pl-1"><small>${old_attach[index].type}</small></td>
            //                                 <td id="td-attachment" class="pl-1"><small>${old_attach[index].size}</small></td>
            //                             </tr>`;
            //     }
            // }

            if (typeof t_attach !== []) {
                var urutin=0;
                for (let index = 0; index < t_attach.length; index++) {
                    // console.log(t_attach[index]);
                    tampung_attach += `<tr>
                                            <td id="td-attachment" class="pl-2"><small>${(typeof (t_attach[index].options) !== 'undefined') ? t_attach[index].options.file.name : t_attach[index].filenameWithoutExtension}</small></td>
                                            <td id="td-attachment" class="pl-1"><small>${(typeof (t_attach[index].options) !== 'undefined') ? t_attach[index].options.file.type : t_attach[index].fileType}</small></td>
                                            <td id="td-attachment" class="pl-1"><small>${(typeof (t_attach[index].options) !== 'undefined') ? bytesToSize(t_attach[index].options.file.size) : bytesToSize(t_attach[index].fileSize)}</small></td>
                                        </tr>`;
                }
            }else{
                tampung_attach += `<tr>
                                        <td id="td-attachment" class="pl-2"><small>-</small></td>
                                        <td id="td-attachment" class="pl-1"><small>-</small></td>
                                        <td id="td-attachment" class="pl-1"><small>-</small></td>
                                    </tr>`;
            }

            $('#prev_namaproject').append(`${t_nama_project}`);
            $('#prev_thumbnail').attr('src',`${t_photo}`);
            $('#prev_konsultant').append(`${tampung_vendor}`);
            $('#prev_pm').append(t_projectmanager);
            $('#prev_emailpm').append(`<i class="far fa-envelope mr-1"></i><a href="mailto:${t_email}">${t_email}</a>`);
            $('#prev_divisi').append(`${t_divisi}`);
            $('#prev_tglmulai').append(`${t_tgl_mulai}`);
            $('#prev_tglselesai').append(`${t_tgl_selesai}`);
            $('#prev_status').append(`${t_stat_project}`);
            $('#prev_keyword').append(`${tampung_tags}`);
            $('#prev_deskripsi').append(`${t_deskripsi}`);
            $('#prev_metodologi').append(`${t_metodologi}`);
            $('#prev_lessonlearned').append(`${tampung_lesson}`);
            $('#prev_document').append(`${tampung_attach}`);
            $('#modalpreview').modal({
                show : true
            });
        }
    });
});

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
                            <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Pilih Konsultan/Vendor<span class='text-danger'>*</span></label>
                            <div class="col-md-10 col-sm-12">
                                <select class="select2 form-control" id="konsultant" name="konsultant[]" multiple required>
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
    var sample = $('select[name=restricted] option').filter(':selected').val();

    if (sample == 0) {
        $('.content-restricted').remove();
    }else if(sample == 1){
        var content =   `
                        <div class="form-group w-100 d-flex justify-content-start content-restricted">
                            <div>
                                <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                            </div>
                        </div>
                        <div class="form-group row content-restricted">
                            <div class="col-md-12 col-sm-12">
                                <select class="select2 form-control" id="user" name="user[]" multiple required>
                                    ${optionuser}
                                </select>
                            </div>
                        </div>
                        `;
        $('#restricted_content').append(content);
    }

    // set select2
    $('#user').select2({
        placeholder : 'Pilih User'
    });
});

$('#restricted').change(function(){
    var sample = $('select[name=restricted] option').filter(':selected').val();

    if (sample == 0) {
        $('.content-restricted').remove();
    }else if(sample == 1){
        var content =   `
                        <div class="form-group w-100 d-flex justify-content-start content-restricted">
                            <div>
                                <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                            </div>
                        </div>
                        <div class="form-group row content-restricted">
                            <div class="col-md-12 col-sm-12">
                                <select name="user[]" id="restricted-user" class="restricted-user select2 form-control" placeholder='Masukan Personal Number'  multiple required></select>
                            </div>
                        </div>
                        `;

        $('#restricted_content').append(content);
        $('#restricted-user').on('select2:select', function (e) {
            if($('#restricted-user').hasClass('is-invalid') || $('#restricted-user').hasClass('is-valid')){
                var kolomvendor = $('#jenispekerja').val();
                var urut;
                if (kolomvendor === '1') {
                    urut = 1;
                }else{
                    urut = 0;
                }
                // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
                if($('#restricted-user').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
                }else if($('#restricted-user').hasClass('is-valid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
                }
            }
        });
    }

    // set select2
    $('#restricted-user').select2({
        placeholder : 'Cari User'
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
});


$('#stat_project').change(function(){
    if ($('#stat_project').prop('checked')) {
        var element = `
                        <div class="form-group row content-selesai">
                            <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                            <div class="col-md-5 col-sm-12 content-selesai">
                                <input type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Tanggal selesai" required>
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
    cekDivisi();
});

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
                        if (valueOld == data.data[index].id) {
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`;
                        }else{
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        }
                    }else{
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

var divisiVal = document.getElementById('divisi').getAttribute('value');
if (divisiVal != "") {
    divisiVal   =   parseInt(divisiVal);
    console.log(divisiVal);
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

$('#add_lesson').click(function(){
    lesson_learned_urut++;
    let element = ` <tr class='ll_field'>
                <td class="bg-white attr_input"><span class='control_ll'> </span></td>
                <td><input type="text" class="form-control w-100 lesson_field lesson" name="lesson[]" value="" placeholder="..." required/></td>
                <td><input type="text" class="form-control w-100 lesson_field lesson_keterangan" name="lesson_keterangan[]" value="" placeholder="..." required/></td>
            </tr>`;
    $('.content_lesson').append(element);
    urutFields();
    if ($('.ll_field').length <= 1) {
        $('.ll_min').attr("class","ll_min ll_min_disabled");
    }else{
        $('.ll_min').attr("class","ll_min");
    }
    $(".ll_min").unbind();
    $(".ll_min").click(function(){
        var urutannya   =    $('.ll_min').index(this);
        removeFieldls(urutannya);
    });
});

$("#save").click(function(){
    try {
        let cek_edit = document.getElementById('id').value;
        if (typeof(cek_edit) == 'undefined') {
            $("#project").val('0');
            $('#form').submit();
            $('.senddataloader').show();
        }else{
            $('#form').attr('action',uri+"/kontribusi/update");
            // console.log(uri+"/kontribusi/update");

            $("#project").val('0');
            $('#form').submit();
            $('.senddataloader').show();
        }
    } catch (error) {
        $("#project").val('0');
        $('#form').submit();
        $('.senddataloader').show();
    }
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
