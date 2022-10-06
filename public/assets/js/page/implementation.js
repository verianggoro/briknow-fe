let $table = $('#table')
let $remove = $('#remove');
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

function hapus(a){
    const url = `${uri}/implementation/delete/${a}`
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
    window.location.href = uri+`/managecommunication/upload/implementation/${e}`;
}

function toProject(slug) {
    window.location.href = uri+`/project/${slug}`;
}

function view(row) {
    $('#desc-preview').empty();
    let data_pilot = []
    let data_roll = []
    let data_sos = []
    let attach = row.attach_file
    for (let i=0; i<attach.length; i++) {
        const lastModifiedDate = new Date(attach[i].updated_at)
        if (attach[i].tipe === 'piloting') {
            data_pilot.push({'name': attach[i].nama, 'date':lastModifiedDate, 'size': attach[i].size})
        } else if (attach[i].tipe === 'rollout') {
            data_roll.push({'name': attach[i].nama, 'date':lastModifiedDate, 'size': attach[i].size})
        } else if (attach[i].tipe === 'sosialisasi') {
            data_sos.push({'name': attach[i].nama, 'date':lastModifiedDate, 'size': attach[i].size})
        }
    }

    if (row.desc_piloting !== null) appendDesc('Piloting', 'pilot',row.desc_piloting, data_pilot)
    if (row.desc_roll_out !== null) appendDesc('Roll Out', 'roll', row.desc_roll_out, data_roll)
    if (row.desc_sosialisasi !== null) appendDesc('Sosialisasi', 'sos', row.desc_sosialisasi, data_sos)

    $('#prev_namaproject').empty();
    $('#prev_project').empty();
    $('.paren-project-desc').remove();
    $('#prev_tglmulai').empty();
    $('#prev_tglselesai').empty();
    $('#prev_status').empty();

    let divisi = row.divisi
    if (divisi !== null) {
        $('#prev_divisi').empty();
        $('#prev_direktorat').empty();
        $('#prev_divisi').append(`${divisi.divisi}`);
        $('#prev_direktorat').append(`${divisi.direktorat}`);
    } else {
        $('#prev_divisi').empty();
        $('#prev_direktorat').empty();
        $('#prev_divisi').append(`-`);
        $('#prev_direktorat').append(`-`);
    }

    let t_project = ``
    if (row.project_id !== null) {
        t_project = `<div onclick="toProject('${row.slug_project}')" style="font-size: 18px" class="d-block font-weight-bold project-parent-link paren-project-desc">${row.nama}</div>`
    } else {
        t_project = `<span class="paren-project-desc d-block font-weight-bold">General</span>`
    }

    let date_mulai          = new Date(row.tanggal_mulai);
    let t_tgl_mulai         = dateFormat(date_mulai);

    let t_tgl_selesai;
    if (row.tanggal_selesai !== null) {
        // waktu
        let temp_date           = new Date(row.tanggal_selesai);
        t_tgl_selesai         = dateFormat(temp_date);

    }else{
        t_tgl_selesai = '-';
    }

    const titleCase = (s) =>
        s.replace(/^_*(.)|_+(.)/g, (s, c, d) => c ? c.toUpperCase() : ' ' + d.toUpperCase())

    $('#prev_thumbnail').attr('src',`${uri}/storage/${row.thumbnail}`);
    $('#prev_thumbnail').attr('alt',`${row.title}`);
    $('#prev_namaproject').append(`${row.title}`);
    $('#prev_project').append(`${t_project}`);
    $('#prev_tglmulai').append(`${t_tgl_mulai}`);
    $('#prev_tglselesai').append(`${t_tgl_selesai}`);
    $('#prev_status').append(`${titleCase(row.status)}`);

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

function appendDesc(step, editor, caption, data) {
    let desc = `
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div class="preview-desc-head">${step}</div>
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

function setStatus(value, row, valueOld) {
    const url = `${uri}/implementation/status/${value}/${row}`
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
                    location.reload();
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
    const step = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
    const url = `${uri}/implementation/${step}`
    /*$.get({url: url +'?' + $.param(params.data),
        headers: {
            'Authorization' :   `Bearer ${csrf}`,
            "Accept"        :   "application/json"
        }}).then(function (res) {
        params.success(res)
    })*/
    $.ajax({
        url: url + '?' + $.param(params.data),
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
        },
        success: function(data){
            const height = data.total === 0 ? 105 : 52 + (data.total * 108)
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
        '<div class="view border-action d-flex align-items-center justify-content-center mr-2 action-icon" title="View">',
        '<i class="fas fa-eye" style="margin: 0; font-size: 19px"></i>',
        '</div>  ',
        '<div class="edit border-action d-flex align-items-center justify-content-center mr-2 action-icon" title="Edit">',
        '<i class="fas fa-pencil-alt" style="margin: 0; font-size: 19px"></i>',
        '</div>',
        '<div class="remove border-action d-flex align-items-center justify-content-center mr-2 action-icon" title="Remove">',
        '<i class="fas fa-trash" style="margin: 0; font-size: 19px"></i>',
        '</div>',
        '<div class="download border-action d-flex align-items-center justify-content-center action-icon" title="Download">',
        '<i class="fas fa-download" style="margin: 0; font-size: 19px"></i>',
        '</div>',
        '</div>'
    ].join('')
}

window.operateEvents = {
    'click .view': function (e, value, row, index) {
        view(row)
    },
    'click .edit': function (e, value, row, index) {
        edit(row.slug)
    },
    'click .remove': function (e, value, row, index) {
        hapus(value)
    },
    'click .download': function (e, value, row, index) {
        console.log('You click like action, row: ' + JSON.stringify(row))
    },
}

function statusFormatter (value, row, index) {
    const options = ['Unpublish', 'Approve', 'Publish', 'Reject'];
    const val = "'" + value + "'"
    /*let i = options.indexOf(value);
    if (i !== -1) {
        options.splice(i, 1);
    }*/
    let $select = ['<select id="selectStatus'+row.id+'" class="select-custom" onchange="setStatus(value,'+ row.id +','+ val +')" style="padding: 0.1rem 1rem;font-size: 14px;border-radius: 6px;width: 70%">'];
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
        '<div class="pl-4">',
        '<i class="fas fa-eye mr-2"></i>',
        views,
        '</div>',
    ].join('')
}

function titleFormatter(value, row, index) {
    let src = `${uri}/storage/${row.thumbnail}`
    return `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" width="85" height="85" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <div style="width: 72%" class="ellipsis-2">
                ${value}
            </div>
        </div>`
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
                width: 410
            },
                {
                    field: 'views',
                    title: 'Views',
                    align: 'center',
                    formatter: viewsFormatter,
                    width: 120
                },
                {
                    field: 'tanggal_mulai',
                    title: 'Tanggal',
                    sortable: true,
                    align: 'center',
                    formatter: dateFormater,
                    cellStyle: {
                        classes: 'font-weight-bold',
                    },
                    width: 200
                },
                {
                    field: 'status',
                    title: 'Status',
                    align: 'center',
                    formatter: statusFormatter
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
    $remove.click(function () {
        var ids = getIdSelections()
        $table.bootstrapTable('remove', {
            field: 'id',
            values: ids
        })
        $remove.prop('disabled', true)
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