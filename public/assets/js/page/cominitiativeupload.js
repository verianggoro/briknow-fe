let BE                      = '';
let uri                     = '';
let base_url                = '';
let token                   = '';
let csrf                   = '';

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

const $parent = $('#parent');
$parent.change(function () {
    const $projectContent = $('#content-project')
    if ($(this).val() === "1") {
        let content =   `
            <div class="form-group project-link" style="width: 70%;">
                <label for="link" class="label-cus">Project Link <span style="font-size: 14px;font-weight: normal">(jika project existing di BRIKNOW)</span></label>
                <select class="select2 form-control" id="link" name="link" placeholder='Project Link' required>
                </select>
<!--                <input type="text" class="form-control" style="width: 70%; height: 40px" id="link" name="link" placeholder="Project Link">-->
            </div>
        `

        $projectContent.append($(content).hide().fadeIn(300));
    } else {
        $('.project-link').fadeOut(300, function () {$(this).remove()});
    }

    $('#link').select2({
        placeholder : 'Project Link'
    });

    $("#link").select2({
        placeholder: 'Project Link',
        minimumInputLength: 1,
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
                    search: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });
})

const $preview = $('#preview')
const $photo = $('#photo')

function readFile(input) {
    const type_file = ['application/x-zip-compressed', 'zip', 'rar']
    const name_file = input.files[0].name;
    if (type_file.includes(input.files[0].type) || type_file.includes(name_file.split('.')[1])) {
        $('#file').val('')
        Toast3.fire({icon: 'error',title: 'Tipe file tidak sesuai !'});
        return;
    }
    for (let f in input.files) {
        if (input.files[f] instanceof File) {
            showPreview(input.files[f])
        }
    }
}

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

function showPreview(file) {
    const unique_name = Date.now().toString(36) + Math.random().toString(36).substring(2) + file.name.replace(/ /g, "")
    const timemillis = Date.now()
    let htmlPreview = [
        '<div id="prev'+timemillis+'" class="d-flex align-items-center mb-3" style=" width: 55%; height: 40px;">',
            '<div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">',
                '<div class="d-flex align-items-center justify-content-between" style="width: 100%">',
                    '<div class="d-flex align-items-center justify-content-center">',
                        '<i class="fas fa-file mr-3"></i>',file.name,
                    '</div>',
                    '<div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Cancel" onclick="removePreview(this, \'cancel\')">',
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

    let $container = $('#prev'+timemillis+'')
    let id = $container.attr('id')

    if($('#form').hasClass('was-validated')){
        $("#attach-wrap").attr("style", "border:solid 1px #38c172;");
    }

    let form_data = new FormData();
    form_data.append(`content_communication_support`, file);

    $.ajax({
        url: uri+`/up/content_communication_support`,
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
                removePreview(this, 'delete')
            })
            let $icon = $click.find(':first-child')
            $icon.removeClass('fa-circle-notch fa-spin')
            $icon.addClass('fa-times')
            $icon.prop('title', 'Delete')

            let $last = $container.children().last()
            $last.children().remove()
            $last.append('<div class="d-flex align-items-center" style="border-radius: 50%; padding: 6px 5px 4px; border: 2px solid #218838; color: #218838">' +
                '<i style="font-size: 10px" class="fas fa-check"></i></div>')

            const input_hidden = `<input type="hidden" name="attach[]" value="${res}">`
            $('#prev'+timemillis).append(input_hidden)
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Upload Gagal'});
            removePreview(this, 'cancel')
        },
    });
}

function removePreview(id, type) {
    if (type === 'cancel') {
        $(id).parent().parent().parent().fadeOut(300, function () {
            $(this).remove()
            if ( $preview.children().length === 0 ) {
                $('#file').val('')
            }
            if($('#form').hasClass('was-validated')){
                $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
            }
        });
    } else {
        let $last = $(id).parent().parent().parent().children().last()
        let form_data = new FormData();
        form_data.append(`content_communication_support`, $last.val());
        $.ajax({
            url: uri+`/delete/content_communication_support`,
            data: form_data,
            type: 'post',
            contentType: false,
            processData: false,
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function(){
                $(id).parent().parent().parent().fadeOut(300, function () {
                    $(this).remove()
                    if ( $preview.children().length === 0 ) {
                        $('#file').val('')
                        const attr = $('#file').attr('required');
                        if (typeof attr === 'undefined' || attr === false) {
                            $('#file').attr('required', true)
                        }
                        if($('#form').hasClass('was-validated')){
                            $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
                        }
                    }
                });
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
    $.ajax({
        url: uri+'/delete/thumbnail',
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(){
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
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Delete Gagal'});
        },
    });
}

function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}
$('#file').change(function(){
    readFile(this);
});
$photo.change(function(){
    readThumbnail(this);
});
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
$('.remove-preview').on('click', function() {
    var boxZone = $(this).parents('.preview-zone').find('.box-body');
    var previewZone = $(this).parents('.preview-zone');
    var dropzones = $(this).parents('.form-group').find('.dropzones');
    boxZone.empty();
    previewZone.addClass('hidden');
    reset(dropzones);
});

$(document).ready(function () {
    CKEDITOR.on("instanceReady", function(event) {
        $("#cke_deskripsi").addClass('border-none');
    });
    $('#submit').on('click', function () {
        const $form = $('#form')
        let curInputs = $form.find("input[type='text'],input[type='url'],input[type='file'],input[type='date'],input[type='email'],select")
        let isValid = true;

        $(".form-control").removeClass("is-invalid");
        // $(".thumbnail-input").removeClass("is-invalid");
        $form.removeClass('was-validated');
        $form.addClass('was-validated');
        for(let i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-control").addClass("is-invalid");
                // $(curInputs[i]).closest("#drop-wrap").addClass("is-invalid");
            }
        }

        if($('#photo').hasClass('is-invalid')){
            $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
        }else{
            $("#thumbnail-prev").attr("style", "border:solid 1px #38c172;");
        }

        if($('#link').hasClass('is-invalid')){
            $("[aria-labelledby='select2-link-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-link-container']").attr("style", "border-color:#38c172;");
        }

        if($('#file').hasClass('is-invalid')){
            $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
        }else{
            $("#attach-wrap").attr("style", "border:solid 1px #38c172;");
        }

        isValid = checkEditor()

        if (isValid) {
            $('form#form').submit();
            $('.senddataloader').show();
        }

    })

    $('#project').select2({
        placeholder : 'Based on project',
        tags: true,
    });

    $("#link").select2({
        placeholder: 'Project Link',
        minimumInputLength: 1,
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
                    search: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });
});

function checkEditor() {
    let valid = true;
    let msgLengthDeskripsi = CKEDITOR.instances['deskripsi'].getData().replace(/<[^>]*>/gi, '').length;

    $("#cke_deskripsi").removeClass('border-none');
    if(msgLengthDeskripsi <= 200){
        $("#cke_deskripsi").attr("style", "border-color:#e3342f");
    }else{
        $("#cke_deskripsi").attr("style", "border-color:#38c172");
    }

    if(msgLengthDeskripsi  ===  0) {
        valid = false
        Toast3.fire({icon: 'error',title: 'Deskripsi tidak boleh kosong!'});
    } else if (msgLengthDeskripsi <= 200) {
        valid = false
        Toast3.fire({icon: 'error',title: 'Deskripsi kurang dari 200 karakter!'});
    }

    return valid;
}

/*
*/
