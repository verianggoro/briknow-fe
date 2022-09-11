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

const $preview = $('#preview')

function readFile(input) {
    for (let f in input.files) {
        if (input.files[f] instanceof File) {
            showPreview(input.files[f])
        }
    }
    let $submit = $('#submit');
    $submit.prop("disabled", false)
    $submit.removeClass('disabled')
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
        '<input type="hidden" name="attach[]" value="'+unique_name+'">',
        '<div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Cancel" onclick="removePreview(\'prev\'+'+timemillis+', \'cancel\')">',
        '<i class="fas fa-circle-notch fa-spin"></i>',
        '</div>',
        '</div>',
        '</div>',
        '<div class="d-flex align-items-center" style="width: 20px;">',
        '<p class="m-0 d-flex align-items-center">Uploading&nbsp;<span class="loadings">...</span></p>',
        '</div>',
        '</div>'
    ]

    $preview.removeClass('hidden');
    $preview.append(htmlPreview.join(''))

    let $container = $('#prev'+timemillis+'')
    let id = $container.attr('id')

    // TODO : upload attachment
    setTimeout(() => {
        let $first = $container.children().first().children()
        $first.addClass('detail-prev')

        let $click = $first.children().last()
        $click.prop("onclick", null).off("click");
        $click.on('click', function () {
            removePreview(id, 'delete')
        })
        let $icon = $click.find(':first-child')
        $icon.removeClass('fa-circle-notch fa-spin')
        $icon.addClass('fa-times')
        $icon.prop('title', 'Delete')

        let $last = $container.children().last()
        $last.children().remove()
        $last.append('<div class="d-flex align-items-center" style="border-radius: 50%; padding: 6px 5px 4px; border: 2px solid #218838; color: #218838">' +
            '<i style="font-size: 10px" class="fas fa-check"></i></div>')
    },5000)
}

function removePreview(id, type) {
    $('#'+id+'').remove();
    if ( $preview.children().length === 0 ) {
        $preview.addClass('hidden')
    }
}

function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}
$('#file').change(function(){
    readFile(this);
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