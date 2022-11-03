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
const url = document.location.href;
const urlParam = new URLSearchParams(window.location.search)
const slug = urlParam.get('slug')

let slideIndex = 1;

const metas = document.getElementsByTagName('meta');
var lastpath = window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

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
    const url = `${uri}/mycomsupport/getall/initiative/${lastpath}?page=${page}&year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#card-content-cominit").empty();
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data === undefined || data.data.length !== 0){
                for (let index=0; index < data.data.length; index++){
                    $("#card-content-cominit").append(`<div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreview(${data.data[index].id})">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreview(${data.data[index].id})">
                                                        <h5 class="card-title">${data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data[index].id}">${data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data[index].type_file+"?slug="+data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data[index].id})">
                                                            <img src="${uri+(data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`);
                }

                if (slug) {
                    const datas = data.data.find(i => i.slug === slug)
                    if (datas) {
                        openPreview(datas.id)
                    } else {
                        Toast2.fire({icon: 'error',title: 'Content tidak ditemukan!'});
                        if (urlParam) {
                            if (slug) {
                                window.history.pushState({}, '', url.split("?")[0]);

                            }
                        }
                    }
                }
            }else{
                $("#card-content-cominit").append(`
                    <div class="p-2 w-100 pt-5 text-center">
                        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                        <h5 class="font-weight-bold mt-5 mb-1">Oops.. Content tidak ditemukan</h5>
                        <p class="w-100 text-center font-weight-bold">Coba cari content lain</p>
                    </div>`)
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function openPreview(id) {
    const url = `${uri}/communication/views/content/${id}?public=1`
    let t = "{{$token_auth}}";

    $.ajax({
        url: url,
        type: 'post',
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
            $('#content-modal').empty();
        },
        success: function (data) {
            $('.senddataloader').hide();

            let view = data.data.views
            $(`#view-${id}`).text(view)
            $('#content-modal').append(data.prev);

            $('#preview').modal({
                show : true
            });

            showSlides(slideIndex);
        },
        error: function () {
            $('.senddataloader').hide();
            Toast2.fire({icon: 'error',title: 'Gagal'});
        },
    })
}

$('#preview').on('hidden.bs.modal', function () {
    let video = $('video').get(0)
    if (video) {
        video.pause()
    }

    if (urlParam) {
        if (slug) {
            window.history.pushState({}, '', url.split("?")[0]);

        }
    }

    $('#content-modal').empty();
})

$(document).ready(function () {

    $('#direktorat-com-init').select2({
        placeholder: 'Pilih Direktorat'
    });

    $('#divisi-com-init').select2({
        placeholder: 'Pilih Unit Kerja'
    });
})

$('#direktorat-com-init').on('select2:select', function (e) {
    cekDivisi('select', e.params.data.id)
})

$('#direktorat-com-init').on('select2:unselect', function(e){
    cekDivisi('unselect', e.params.data.id)
});

$('#divisi-com-init').on('select2:select', function (e) {
    divisiParam = e.params.data.id
    getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
})

const cekDivisi = (selOrUn, value) => {
    if($('#divisi-com-init').hasClass('is-invalid') || $('#divisi-com-init').hasClass('is-valid')){
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
                        $('#divisi-com-init').append(`<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`);
                    } else {
                        $(`#divisi-com-init option[value="${data.data[index].id}"]`).detach();
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
        getData(pageParam, yearParam, monthParam, divisiParam, '', keywordParam)
        document.getElementById('btn-sort-comsup').innerHTML = "Sort By"
    }
}

function download(id) {
    window.location.href = uri+`/attach/download/content/${id}`;
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

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
}

function saveFavCom(e, id){
    const $img = $(e).children()
    var url = `${uri}/favoritcomsupport/content/${id}`;
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

