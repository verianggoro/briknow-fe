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

    $('#content-modal').empty();
})

if (lastpath === 'strategic'){
    getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}else if(lastpath === twoLastPath[3]){
    getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}else if (twoLastPath[3] !== undefined){
    getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}

function getData(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/strategic/publish?year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#card-content-strategic").html("");
            if (data.data !== undefined || data.data.length !== 0){
                for (let index=0; index < data.data.length; index++){
                    $('#card-content-strategic').append(`<div class="col-lg-4 d-flex justify-content-center">
                                                <a class="w-100" href="${uri+'/mycomsupport/strategic/'+data.data[index].slug}">
                                                    <div class="card" style="border-radius: 16px;">
                                                        <img class="card-img-up" src="${uri+'/storage/'+data.data[index].thumbnail}"
                                                             alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-center">${data.data[index].nama}</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>`);
                }
            }else{
                $('#card-content-strategic').append(`<div class="p-2">
                                            <p class="w-100 text-center font-weight-600 font-italic">Tidak Ada Data</p>
                                        </div>`);
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function getDataByProject(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/strategic/publish/${lastpath}?year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            if (data.data.content !== undefined || data.data.content.length !== 0){
                for (let index=0; index < data.data.content.length; index++){
                    for (let index2=0; index2 < data.data.content[index].data.length; index2++){
                        if (data.data.content[index].id === 'article'){
                            $("#ContentArticle").html("");
                            $("#ContentArticle").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/article'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'video'){
                            $("#ContentVideo").html("");
                            $("#ContentVideo").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/video'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'podcast'){
                            $("#ContentPodcast").html("");
                            $("#ContentPodcast").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/podcast'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'instagram'){
                            $("#ContentIg").html("");
                            $("#ContentIg").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/instagram'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'transformation'){
                            $("#ContentTrans").html("");
                            $("#ContentTrans").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/transformation'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'logo'){
                            $("#ContentLogo").html("");
                            $("#ContentLogo").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/logo'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'infographics'){
                            $("#ContentInfo").html("");
                            $("#ContentInfo").append(`<div class="col-2 justify-content-center">
                                                        <a href="${uri+'/mycomsupport/strategic/'+data.data.content[index].data[index2].slug+'/infographics'}">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                        </a>
                                                    </div>`);
                        }
                    }
                }
            }else{
                document.getElementById('card-content-strategic').innerHTML = `<div class="p-2">
                                            <p class="w-100 text-center font-weight-600 font-italic">Tidak Ada Data</p>
                                        </div>`
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function getDataByContent(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/strategic/publish/${twoLastPath[3]}/${lastpath}?year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#card-content-strategic").html("");
            if (data.data !== undefined || data.data.length !== 0){
                for (let index=0; index < data.data.length; index++) {
                    $("#card-content-strategic").append(`<div class="col-lg-4 d-flex justify-content-center">
                                        <a onclick="openPreview(${data.data[index].id})" style="width: inherit">
                                            <div class="card" style="border-radius: 16px;">
                                                <img class="card-img-up"
                                                     src="${uri+'/storage/'+data.data[index].thumbnail}"
                                                     alt="Card image cap">
                                                <div class="card-body">
                                                    <h5 class="card-title">${data.data[index].title}</h5>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye">
                                                            <span>${data.data[index].views}</span>
                                                        </i>
                                                         <button class="btn p-2 grey" style="font-size: 20px">
                                                      <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                  </button>
                                                  <button class="btn fas grey" style="font-size: 20px">
                                                      <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                  </button>
                                                  <button class="btn fas grey" style="font-size: 20px">
                                                      <img src="${uri+'/assets/img/logo/favoriite_ic.png'}"/>
                                                  </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>`);
                }
            }else{
                $("#card-content-strategic").append(`<div class="p-2">
                                            <p class="w-100 text-center font-weight-600 font-italic">Tidak Ada Data</p>
                                        </div>`)
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

$(document).ready(function () {

    $('#dir-strategic-init').select2({
        placeholder: 'Pilih Direktorat'
    });

    $('#divisi-strategic-init').select2({
        placeholder: 'Pilih Unit Kerja'
    });
})

$('#dir-strategic-init').on('select2:select', function (e) {
    cekDivisi('select', e.params.data.id)
})

$('#dir-strategic-init').on('select2:unselect', function(e){
    cekDivisi('unselect', e.params.data.id)
});

$('#divisi-strategic-init').on('select2:select', function (e) {
    divisiParam = e.params.data.id
    if (lastpath === 'strategic'){
        getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
})

const cekDivisi = (selOrUn, value) => {
    if($('#divisi-strategic-init').hasClass('is-invalid') || $('#divisi-strategic-init').hasClass('is-valid')){
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
                        $('#divisi-strategic-init').append(`<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`);
                    } else {
                        $(`#divisi-strategic-init option[value="${data.data[index].id}"]`).detach();
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
    if (lastpath === 'strategic'){
        getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
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
    if (lastpath === 'strategic'){
        getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
}

function searchCominit(){
    keywordParam = document.getElementById("searchCominit").value;
    if (lastpath === 'strategic'){
        getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
}

function sortingBy(params){
    sortParam = document.getElementById(params).getAttribute('data-value')
    if (sortParam !== 'init'){
        if (lastpath === 'strategic'){
            getData(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        }else if(lastpath === twoLastPath[3]){
            getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        }else{
            getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        }
        if (sortParam === 'title'){
            document.getElementById('btn-sort-comsup').innerHTML = "Judul"
        }else if (sortParam === 'created_at'){
            document.getElementById('btn-sort-comsup').innerHTML = "Tanggal"
        }else if (sortParam === 'views'){
            document.getElementById('btn-sort-comsup').innerHTML = "View"
        }
    }else{
        if (lastpath === 'strategic'){
            getData(pageParam, yearParam, monthParam, divisiParam, '', keywordParam)
        }else if(lastpath === twoLastPath[3]){
            getDataByProject(pageParam, yearParam, monthParam, divisiParam, '', keywordParam)
        }else{
            getDataByContent(pageParam, yearParam, monthParam, divisiParam, '', keywordParam)
        }
        document.getElementById('btn-sort-comsup').innerHTML = "Sort By"
    }
}

