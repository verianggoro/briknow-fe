$(document).ready(function(){
    var search = "*";
    var uri;
    var order = 'asc';
    var sort = 'created_at';
    var csrf = '';
    var id_project = '';
    var project = '';

// meta url
    const metass = document.getElementsByTagName('meta');
    for (let i = 0; i < metass.length; i++) {
        if (metass[i].getAttribute('name') === "pages") {
            uri = metass[i].getAttribute('content');
        }

        if (metass[i].getAttribute('name') === "csrf") {
            csrf = metass[i].getAttribute('content');
        }
    }

    const Toast = Swal.mixin({
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

    id_project = $('input#id_project').val();
    project = $('input#project').val();

    $("#allcheck").change(function(e){
        if ($('#allcheck').prop('checked')) {
            $('.file').prop('checked',true);
        } else {
            $('.file').prop('checked',false);
        }
        klik();
    });

    $("#btn-archive").click(function(e){
        const files = document.getElementsByClassName('file');
        var tampung = [];
        var urut = 0;
        for (let i = 0; i < files.length; i++) {
            if (files[i].checked === true) {
                tampung[urut] = files[i].value;
                urut++;
            }
        }

        var data_send = {
            "data":tampung
        };

        var url = `${uri}/archive`;
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': csrf},
            type: "POST",
            data: data_send,
            beforeSend: function()
            {
                $('.senddataloader').show();
            },
            success: function(data){
                if (data == false) {
                    alert('Gagal Mengarchieve File');
                }else{
                    window.open(data , '_blank');
                    $('.senddataloader').hide();
                    $('.file').prop('checked',false);
                    unaktif_archive();
                }
            },
            error : function(e){
                alert(e);
            }
        });
    });

    $("#search").submit(function(e){
        if (!e.isDefaultPrevented()){
            var tampung = e.target[0].value;
            if (tampung == "" || !tampung.trim().length) {
                search = "*";
            }else{
                search = tampung;
            }
            getData();
        }
        return false;
    });

    $('#sort').click(function () {
        if (order === 'desc') {
            $('#sort').empty()
            $('#sort').append(`<i class="fas fa-arrow-down mr-2"></i>`)
            order = 'asc'
        } else {
            $('#sort').empty()
            $('#sort').append(`<i class="fas fa-arrow-up mr-2"></i>`)
            order = 'desc'
        }

        getData()
    })

    $('#select-file').on('change', function () {
        sort = $(this).val()
        getData()
    })

    const getData = () =>{
        let query = `?order=${order}`
        if (search && search !== '*') {
            query += `&search=${search}`
        }
        if (sort) {
            query += `&sort=${sort}`
        }
        var url = `${uri}/list_doc/${project}/${id_project}${query}`;
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function()
            {
                $('#coloumnrow').empty();
                $('.senddataloader').show();
            },
            success: function(data){
                if(data.html == "" || data.html == null){
                    $('.senddataloader').hide();
                    return;
                }
                $('.senddataloader').hide();
                // innert html
                $("#coloumnrow").append(data.html);

                // set default input form
                $("#btn-archive").attr('disabled',true);
            },
            error : function(e){
                $('.senddataloader').hide();
                alert(e);
            }
        });
    }

    function toKatalog(short) {
        localStorage.removeItem("fil_div");
        localStorage.setItem("fil_div",short);
    }
})

function klik() {
    const files = document.getElementsByClassName('file');
    let cek = 0;
    let jml_cek = 0;
    for (let i = 0; i < files.length; i++) {
        if (files[i].checked === true) {
            cek = 1;
            jml_cek++
        }
    }
    if (jml_cek === files.length) {
        $('#allcheck').prop('checked',true);
    } else {
        $('#allcheck').prop('checked',false);
    }
    if (cek == 1) {
        aktif_archive();
    } else {
        unaktif_archive();
    }
}

function aktif_archive() {
    // $('#btn-archive').attr('class','btn btn-sm btn-primary d-inline');
    $('#btn-archive').removeClass('btn-secondary')
    $('#btn-archive').addClass('btn-primary')
    $('#btn-archive').attr('disabled',false);
}

function unaktif_archive() {
    // $('#btn-archive').attr('class','btn btn-sm btn-secondary d-inline');
    $('#btn-archive').removeClass('btn-primary')
    $('#btn-archive').addClass('btn-secondary')
    $('#btn-archive').attr('disabled',true);
    $('#allcheck').prop('checked',false);
}
