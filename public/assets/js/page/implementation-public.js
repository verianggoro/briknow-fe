let selections = [];
var csrf;
let urlBE = "";
var uri;

var pageParam = "1";
var yearParam = "";
var monthParam = "";
var divisiParam = "";
var sortParam = "";
var keywordParam = "";

const metas = document.getElementsByTagName('meta');
var lastpath = window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
var twoLastPath = window.location.pathname.split('/');

for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
}


function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)

function getData(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/implementation/all/publish/${lastpath}?page=${page}&year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#container-impl").empty();
            if (data.data.data !== undefined && data.data.data.length !== 0){
                for (let index=0; index < data.data.data.length; index++) {
                    $('#container-impl').append(
                        `<div class="container-fluid">
                            <div class="card d-flex w-100 p-2" style="border-radius: 16px; width: 30rem">
                                <a href="${uri+'/view/implementation/'+data.data.data[index].slug}">
                                    <div class="row">
                                    <div class="col-lg-2">
                                        <img class="card-img" style="height: auto;" src="${uri+'/storage/'+data.data.data[index].thumbnail}" alt="Card image cap">
                                    </div>
                                    <div class="col-lg-10">
                                        <h4>${data.data.data[index].title}</h4>
                                        <div style="background-color: #0a53be; border-radius: 10px;">
                                                <p class="text-white m-2">${lastpath === 'piloting' ? 'PILOTING' : lastpath === 'roll-out' ? 'ROLL-OUT' : 'SOSIALISASI'}</p>
                                        </div>
                                        <p>${lastpath === 'piloting' ? data.data.data[index].desc_piloting.substring(0,200) :
                                            lastpath === 'roll-out' ? data.data.data[index].desc_roll_out.substring(0,200) : data.data.data[index].desc_sosialisasi.substring(0,200)}</p>
                                    </div>
                                </div>
                                </a>
                                <div class="d-flex p-2 justify-content-end">
                                    <div class="row">
                                        <p class="pr-2 fas fa-eye mt-3" style="font-size: 16px; margin-bottom: 0px; margin-top: 0px">
                                            <span>${data.data.data[index].views}</span>
                                        </p>
                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                        </button>
                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                            onclick="migrasi('Eh, liat Implementation Project ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/view/implementation/"+data.data.data[index].slug}')">
                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                        </button>
                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                            <img src="${uri+(data.data.data[index].favorite_implementation.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                }
            }else{
                $('#container-impl').append(`
                    <div class="p-2 w-100 pt-5 text-center">
                        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                        <h5 class="font-weight-bold mt-5 mb-1">Oops.. Project tidak ditemukan</h5>
                        <p class="w-100 text-center font-weight-bold">Coba cari project lain</p>
                    </div>`)
            }
        },
        error : function(e){
            alert(e);
        }
    });
}


$(document).ready(function () {

    $('#dir-impl-init').select2({
        placeholder: 'Pilih Direktorat'
    });

    $('#divisi-impl-init').select2({
        placeholder: 'Pilih Unit Kerja'
    });
})

$('#dir-impl-init').on('select2:select', function (e) {
    cekDivisi('select', e.params.data.id)
})

$('#dir-impl-init').on('select2:unselect', function(e){
    cekDivisi('unselect', e.params.data.id)
});

$('#divisi-impl-init').on('select2:select', function (e) {
    divisiParam = e.params.data.id
    getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
})

const cekDivisi = (selOrUn, value) => {
    if($('#divisi-impl-init').hasClass('is-invalid') || $('#divisi-impl-init').hasClass('is-valid')){
        if(this.value == ""){
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:#38c172;");
        }
    }

    // var direktorat  = $('select[name=direktorat] option').filter(':selected').val();
    var url = `${uri}/getdivisi/${value}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.pagination').remove();

            /*$("#divisi option").each(function() {
                $(this).remove();
            });*/

            $('.senddataloader').show();
        },
        success: function(data){
            // var option = "<option value='' selected disabled>Pilih Unit Kerja</option>";
            let option = '';
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    if (selOrUn === 'select') {
                        // div_short.push(data.data[index].shortname)
                        //option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        $('#divisi-impl-init').append(`<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`);
                    } else {
                        $(`#divisi-impl-init option[value="${data.data[index].id}"]`).detach();
                        // div_short.push(data.data[index].shortname)
                        //option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        //$('#divisi').append(`<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`);
                    }
                }
            }
            // $('#divisi').append(option);
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

function getYearBtn(param, id){
    var element = document.getElementById(id);
    if (element.classList.contains("active")){
        element.classList.remove("active")
        if (yearParam.includes(','+param)){
            yearParam = yearParam.replace(','+param, "")
        }else{
            yearParam = yearParam.replace(param, "")
        }
    }else{
        element.classList.add("active");
        if (yearParam === ''){
            yearParam = param
        }else{
            yearParam = yearParam.concat(",", param)
        }
    }
    getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}

function getMonthBtn(param, id){
    var element = document.getElementById(id);
    if (element.classList.contains("active")){
        element.classList.remove("active")
        if (monthParam.includes(','+param)){
            monthParam = monthParam.replace(','+param, "")
        }else{
            monthParam = monthParam.replace(param, "")
        }
    }else{
        element.classList.add("active");
        if (monthParam === ''){
            monthParam = param
        }else{
            monthParam = monthParam.concat(",", param)
        }
    }
    getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}

function searchCominit(){
    keywordParam = document.getElementById("searchCominit").value;
    getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}

function sortingBy(params){
    sortParam = document.getElementById(params).getAttribute('data-value')
    if (sortParam !== 'init'){
        getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        if (sortParam === 'title'){
            document.getElementById('btn-sort-comsup').innerHTML = "Judul"
        }else if (sortParam === 'created_at'){
            document.getElementById('btn-sort-comsup').innerHTML = "Tanggal"
        }else if (sortParam === 'views'){
            document.getElementById('btn-sort-comsup').innerHTML = "View"
        }
    }else{
        getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        document.getElementById('btn-sort-comsup').innerHTML = "Sort By"
    }
}

function download(id) {
    window.location.href = uri+`/attach/download/implementation/${id}`;
}

function migrasi(pesan) {
    var kopi = document.getElementById("link");
    kopi.value = pesan
}

function kopas() {
    var kopi = document.getElementById("link");
    kopi.select();
    kopi.setSelectionRange(0, 99999);
    document.execCommand("copy");
}

function saveFavCom(e, id){
    const $img = $(e).children()
    var url = `${uri}/favoritcomsupport/implementation/${id}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
        },
        success: function (data) {
            $('.senddataloader').hide();
            if (typeof data.status !== "undefined") {
                if (data.status === 1) {
                    if (data.data.kondisi === 1) {
                        $img.attr('src', `${uri+'/assets/img/logo/ic_favorited.png'}`);
                    } else {
                        $img.attr('src', `${uri+'/assets/img/logo/favoriite_ic.png'}`);
                    }
                }else{
                    alert('Proses Favorite Gagal, Coba lagi');
                }
            }else{
                alert('Proses Favorite Gagal, Coba lagi');
            }
        },
        error: function (e) {
            $('.senddataloader').hide();
            alert('Proses Favorite Gagal, Coba lagi');
        },
    })
}

