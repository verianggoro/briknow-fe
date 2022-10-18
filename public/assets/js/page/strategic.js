let $table = $('#table')
let selections = [];
var uri;
var csrf = '';
var be      = '';

const Toast2 = Swal.mixin({
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

    if (metas[i].getAttribute('name') === "BE") {
        be = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

function ajaxRequest(params) {
    const url = `${uri}/get/strategicinitiative`

    $.ajax({
        url: url + '?' + $.param(params.data),
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
        },
        success: function(data){
            let pagination_height = data.totalRow === data.total ? 0 : 54
            const height = data.totalRow === 0 ? 105 : 51 + (data.totalRow * 108) + pagination_height
            $table.bootstrapTable( 'resetView' , {height: height} );
            $('.senddataloader').hide();
            params.success(data)
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        height: 660,
        locale: 'id-ID',
        paginationParts: 'pageList',
        classes: 'table table-hover',
        columns: [
            [
                {
                    field: 'nama',
                    title: 'Judul',
                    // align: 'center',
                    cellStyle: {
                        classes: 'font-weight-bold',
                        css: {
                            padding: '0.7rem 0!important'
                        }
                    },
                    formatter: titleFormatter,
                    width: 275
                },
                {
                    field: 'divisi',
                    title: 'Direktorat',
                    align: 'center',
                    formatter: direkFormatter,
                    width: 170
                },
                {
                    field: 'divisi',
                    title: 'Divisi',
                    align: 'center',
                    formatter: divisiFormatter,
                    width: 170
                },
                {
                    field: 'views',
                    title: 'Views',
                    align: 'center',
                    formatter: viewsFormatter,
                    width: 85
                },
                {
                    field: 'created_at',
                    title: 'Tanggal',
                    sortable: true,
                    align: 'center',
                    formatter: dateFormater,
                    cellStyle: {
                        classes: 'font-weight-bold',
                    },
                    width: 100
                },
                {
                    field: 'flag_mcs',
                    title: 'Status',
                    align: 'center',
                    formatter: statusFormatter,
                    width: 210
                },
                {
                    field: 'id',
                    title: 'Action',
                    align: 'center',
                    /*cellStyle: {
                        classes: 'd-flex align-items-center justify-content-center',
                    },*/
                    clickToSelect: false,
                    events: window.operateEvents,
                    formatter: operateFormatter
                }]
        ]
    })

    $table.on('click-row.bs.table', function (e, name, args) {
        window.location.href = uri+`/managecommunication/strategicinitiative/project/${name.slug}`;
    })
}

$(function() {
    initTable()
})

function imgError(image) {
    let r = Math.floor(Math.random() * 9) + 1
    image.onerror = "";
    image.src = `${uri}/assets/img/news/img0${r}.jpg`;
    return true;
}

function titleFormatter(value, row, index) {
    let src = `${uri}/storage/${row.thumbnail}`
    return `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" width="85" height="85" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <a href="${uri}/project/${row.slug}" style="width: fit-content; text-align: left" class="ellipsis-2 link-format-table font-weight-bold">
                ${value}
            </a>
        </div>`
}

function viewsFormatter(value, row, index) {
    let view = 0
    const com = row.communication_support
    for (let i=0; i<com.length; i++) {
        view += com[i].views
    }
    return [
        '<div class="pl-2">',
        '<i class="fas fa-eye mr-2"></i>',
        view,
        '</div>',
    ].join('')
}

function dateFormater(date) {
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [day, month, year].join('/');
}

function statusFormatter (value, row, index) {

    let status_title = ''
    if (value === 3) {
        status_title = 'Pending Review'
    } else if (value === 4) {
        status_title = 'Reviewed'
    } else if (value === 5) {
        status_title = 'Published'
    } else if (value === 6) {
        status_title = 'Unpublished'
    } else if (value === 7) {
        status_title = 'Rejected'
    } else {
        status_title = value
    }
    return `<div class="d-flex align-items-center justify-content-center" style="padding: 0.1rem;margin-left:auto;margin-right: auto;font-size: 14px;border-radius: 6px;width: 150px; border: 1px solid #cccccc">${status_title}</div>`;
}

function operateFormatter(value, row, index) {
    return [
        '<div class="d-flex align-items-center justify-content-center" style="padding-top: 0; padding-bottom: 0">',
        '<div class="view border-action d-flex align-items-center justify-content-center mr-1 action-icon" title="View">',
        '<i class="fas fa-eye" style="margin: 0; font-size: 18px"></i>',
        '</div>  ',
        '<div class="edit border-action d-flex align-items-center justify-content-center mr-1 action-icon" title="Edit">',
        '<i class="fas fa-pencil-alt" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        '<div class="remove border-action d-flex align-items-center justify-content-center mr-1 action-icon" title="Remove">',
        '<i class="fas fa-trash" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        '<div class="download border-action d-flex align-items-center justify-content-center action-icon" title="Download">',
        '<i class="fas fa-download" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        '</div>'
    ].join('')
}

window.operateEvents = {
    'click .view': function (e, value, row, index) {
        views(e, row.slug);
    },
    'click .edit': function (e, value, row, index) {
        edit(e, row.slug)
    },
    'click .remove': function (e, value, row, index) {
        hapus(e, value)
    },
    'click .download': function (e, value, row, index) {
        download(e, row.id);
    },
}

function divisiFormatter(value) {
    return `
            <a href="${uri}/katalog" onclick="toKatalog('${value.shortname}')" oncontextmenu="toKatalog('${value.shortname}')" onmousedown="toKatalog('${value.shortname}')" class="ellipsis-2 link-format-table" id="divdirek">
                ${value.divisi}
            </a>`
}

function direkFormatter(value) {
    return `
            <a href="${uri}/katalog" onclick="toKatalog('${value.shortname}')" oncontextmenu="toKatalog('${value.shortname}')" onmousedown="toKatalog('${value.shortname}')" class="ellipsis-2 link-format-table" id="divdirek">
                ${value.direktorat}
            </a>`;
}

function toKatalog(short) {
    localStorage.removeItem("fil_div");
    localStorage.setItem("fil_div",short);
}

function download(e, id) {
    e.stopPropagation();
    window.location.href = uri+`/attach/download/project/${id}`;
}

function edit(e, slug) {
    e.stopPropagation();
    window.location.href = uri+`/kontribusi/${slug}`;
}

function hapus(e, a){
    e.stopPropagation();
    let t = "{{$token_auth}}";
    const url = `${uri}/manageproject/review/destroy/${a}`
    swal.fire({ title: "Anda yakin akan menghapus Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            $.ajax({
                url: url,
                type: "DELETE",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                    $('.senddataloader').show();
                },
                success: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'success',title: 'Berhasil dihapus'}); //PERLU DIGANTI BAHASANYA
                    if(i.isConfirmed){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: 'Gagal dihapus'}); //PERLU DIGANTI BAHASANYA
                },
            })
        }
    });
}

function views(e, slug) {
    e.stopPropagation();
    var url = `${uri}/myproject/preview2/`+slug;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf},
        type: "get",
        beforeSend: function()
        {
            $('.senddataloader').show();
            $('.content-preview').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            $('.content-preview').append(data.html);
            $('#modalpreview').modal({
                show : true
            });
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}