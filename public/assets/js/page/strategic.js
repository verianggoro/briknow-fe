let $table = $('#table')
let $remove = $('#remove');
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
    // const url2 = `${uri}/get/strategicinitiative/project/5`

    /*$.ajax({
        url: url2,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(data){
            console.log(data)
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });*/
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

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        height: 660,
        locale: 'id-ID',
        paginationParts: 'pageList',
        classes: 'table',
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
                    field: 'created_at',
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
                    field: 'flag_mcs',
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
}

$(function() {
    initTable()
})

function titleFormatter(value, row, index) {
    let src = `${uri}/storage/${row.thumbnail}`
    return `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" width="85" height="85" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <div style="width: 72%" class="ellipsis-2">
                ${value}
            </div>
        </div>`
}

function viewsFormatter(views) {
    return [
        '<div class="pl-4">',
        '<i class="fas fa-eye mr-2"></i>',
        0,
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
    return `<div class="d-flex align-items-center justify-content-center" style="padding: 0.1rem;margin-left:2rem;font-size: 14px;border-radius: 6px;width: 70%; border: 1px solid #cccccc">${status_title}</div>`;
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
        window.location.href = uri+`/managecommunication/strategicinitiative/project/${row.slug}`;
    },
    'click .edit': function (e, value, row, index) {
        console.log('You click like action, row: ' + JSON.stringify(row))
    },
    'click .remove': function (e, value, row, index) {
        console.log('You click like action, row: ' + JSON.stringify(row))
    },
    'click .download': function (e, value, row, index) {
        console.log('You click like action, row: ' + JSON.stringify(row))
    },
}