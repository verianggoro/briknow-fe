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

function getData(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/communicationinitiative/publish/${lastpath}?page=${page}&year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            for (let index=0; index < data.data.data.length; index++){
                document.getElementById('card-content-cominit').innerHTML = `<div class="col-lg-4 d-flex justify-content-center">
                                            <a href="{{route('view.comsup')}}" target="_blank">
                                                <div class="card" style="border-radius: 16px">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                    <div class="card-body">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                        <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <i class="mr-auto p-2 fas fa-eye">
                                                                <span>${data.data.data[index].views}</span>
                                                            </i>
                                                            <button class="btn fas fa-download p-2" style="font-size: 20px"></button>
                                                            <button class="btn fas fa-share-square p-2"
                                                                    style="font-size: 20px"></button>
                                                            <button class="btn fas fa-heart p-2" style="font-size: 20px"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>`
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

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

