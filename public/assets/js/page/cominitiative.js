let $table = $('#table')
let selections = [];
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

function imgError(image) {
    let r = Math.floor(Math.random() * 9) + 1
    image.onerror = "";
    image.src = `${uri}/assets/img/news/img0${r}.jpg`;
    return true;
}

function hapus(a){
    const url = `${uri}/communicationinitiative/delete/${a}`
    let t = "{{$token_auth}}";
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

                    location.reload();
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: 'Gagal dihapus'}); //PERLU DIGANTI BAHASANYA
                },
            })
        }
    });
}

function edit(e) {
    window.location.href = uri+`/managecommunication/upload/content/${e}`;
}

function download(id) {
    window.location.href = uri+`/attach/download/content/${id}`;
}

function view(row, index) {
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
        $('#prev_direktorat').append(
            `<a class="font-weight-bold" href="${uri}/katalog" onclick="toKatalog('${project.divisi.shortname}')" oncontextmenu="toKatalog('${project.divisi.shortname}')" onmousedown="toKatalog('${project.divisi.shortname}')">
                ${project.divisi.direktorat}
            </a>`);
        $('#prev_divisi').append(
            `<a class="font-weight-bold" href="${uri}/katalog" onclick="toKatalog('${project.divisi.shortname}')" oncontextmenu="toKatalog('${project.divisi.shortname}')" onmousedown="toKatalog('${project.divisi.shortname}')">
                ${project.divisi.divisi}
            </a>`);
    } else {
        $('#prev_divisi').append(`General`);
        $('#prev_direktorat').append(`General`);
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
    let t = "{{$token_auth}}";

    $.ajax({
        url: url,
        data: {data: attach},
        type: 'post',
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function (data) {
            let view = data.data.views
            $table.bootstrapTable('updateRow', {
                index: index,
                row: {
                    views: view
                }
            })
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

function setStatus(value, row, valueOld, index) {
    const url = `${uri}/communicationinitiative/status/${value}/${row}`
    let $select = $('#selectStatus'+row)
    let t = "{{$token_auth}}";
    let title = "";
    switch (value) {
        case 'approve':
            title = "Anda yakin ingin approve Proyek ini?"
            break
        case 'publish':
            title = "Anda yakin ingin menerbitkan Proyek ini?"
            break
        case 'reject':
            title = "Anda yakin ingin Reject Proyek ini?"
            break
        case 'unpublish':
            title = "Anda yakin ingin membatalkan publikasi Proyek ini?"
            break
        default:
            title = ""
            break
    }
    swal.fire({ title: title, text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            $.ajax({
                url: url,
                type: "post",
                data: { _method: "POST"},
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'success',title: data.data.toast});
                    $table.bootstrapTable('updateRow', {
                        index: index,
                        row: {
                            status: value
                        }
                    })
                },
                error: function (error) {
                    const resError = JSON.parse(error.responseText);
                    $('.senddataloader').hide();
                    $select.val(valueOld)
                    Swal.fire({ icon: "error", title: "Oops...", text: resError.data.toast });
                },
            })
        } else {
            $select.val(valueOld)
        }
    });
}

function ajaxRequest(params) {
    const types = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
    const url = `${uri}/communicationinitiative/${types}`

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
            /*if (data.total === 0) {
                $table.find('tbody').find('.no-records-found').children().text('no data')
            }*/
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
        return row.id
    })
}

function responseHandler(res) {
    $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.id, selections) !== -1
    })
    return res
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
        view(row, index)
    },
    'click .edit': function (e, value, row, index) {
        edit(row.slug)
    },
    'click .remove': function (e, value, row, index) {
        hapus(value)
    },
    'click .download': function (e, value, row, index) {
        download(row.id);
    },
}

function statusFormatter (value, row, index) {
    const options1 = ['Pending Review', 'Approve', 'Reject'];
    const options2 = ['Approve', 'Reject'];
    const options3 = ['Approve', 'Publish', 'Unpublish'];
    const options4 = ['Publish', 'Unpublish'];
    let options;
    if (value === 'pending review') {
        options = options1
    } else if (value === 'reject') {
        options = options2
    } else if (value === 'approve') {
        options = options3
    } else if (value === 'publish' || value === 'unpublish') {
        options = options4
    }
    const val = "'" + value + "'"
    /*let i = options.indexOf(value);
    if (i !== -1) {
        options.splice(i, 1);
    }*/
    let $select = ['<select id="selectStatus'+row.id+'" class="select-custom" onchange="setStatus(value,'+ row.id +','+ val +','+ index +')" style="padding: 0.1rem 1rem;font-size: 14px;border-radius: 6px;width: 75%">'];
    let $option;
    for (let val in options) {
        $option = '<option value="' + options[val].toLocaleLowerCase() + '"';
        if (options[val].toLocaleLowerCase() === value) {
            $option = $option + 'selected';
        }
        $option = $option + '>' + options[val] + '</option>'
        $select.push($option);
    }
    $select.push('</select>')
    return $select.join('');
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

function viewsFormatter(views) {
    return [
        '<div class="pl-2">',
        '<i class="fas fa-eye mr-2"></i>',
        views,
        '</div>',
    ].join('')
}

function titleFormatter(value, row, index) {
    let src = `${uri}/storage/${row.thumbnail}`
    let content = `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" width="85" height="85" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <div style="width: 72%" class="ellipsis-2">
                ${value}
            </div>
        </div>`

    if (row.project_id) {
        content = `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" width="85" height="85" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <a href="${uri}/project/${row.project.slug}" style="width: fit-content; text-align: left" class="ellipsis-2 link-format-table font-weight-bold">
                ${value}
            </a>
        </div>`
    }
    return content
}

function divisiFormatter(value) {
    let divisi = '';
    let content = `
        <div class="ellipsis-2 link-format-table">
            General
        </div>`
    if (value) {
        divisi = value.divisi.divisi
        content = `
                <a href="${uri}/katalog" onclick="toKatalog('${value.divisi.shortname}')" oncontextmenu="toKatalog('${value.divisi.shortname}')" onmousedown="toKatalog('${value.divisi.shortname}')" class="ellipsis-2 link-format-table" id="divdirek">
                    ${divisi}
                </a>`
    }
    return content
}

function direkFormatter(value) {
    let direk = '';
    let content = `
                <div class="ellipsis-2 link-format-table">
                    General
                </div>`
    if (value) {
        direk = value.divisi.direktorat
        content = `
                <a href="${uri}/katalog" onclick="toKatalog('${value.divisi.shortname}')" oncontextmenu="toKatalog('${value.divisi.shortname}')" onmousedown="toKatalog('${value.divisi.shortname}')" class="ellipsis-2 link-format-table" id="divdirek">
                    ${direk}
                </a>`
    }
    return content;
}

function toKatalog(short) {
    localStorage.removeItem("fil_div");
    localStorage.setItem("fil_div",short);
}

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        height: 660,
        locale: 'id-ID',
        paginationParts: 'pageList',
        classes: 'table',
        columns: [
            [{
                field: 'title',
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
                    field: 'project',
                    title: 'Direktorat',
                    align: 'center',
                    formatter: direkFormatter,
                    width: 170
                },
                {
                    field: 'project',
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
                    field: 'status',
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
    /*$table.on('check.bs.table uncheck.bs.table ' +
        'check-all.bs.table uncheck-all.bs.table',
        function () {
            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)

            // save your data, here just save the current page
            selections = getIdSelections()
            // push or splice the selections if you want to save all data selections
        })
    $table.on('all.bs.table', function (e, name, args) {
        console.log(name, args)
    })*/
}

$(function() {
    initTable()
})