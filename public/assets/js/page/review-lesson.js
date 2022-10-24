var uri;

var tahapParam = "";
var divisiParam = "";
var keyParam = "";

const metas = document.getElementsByTagName('meta');
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

$(document).ready(function () {

    $('#direktorat-lesson-init').select2({
        placeholder: 'Pilih Direktorat'
    });

    $('#divisi-lesson-init').select2({
        placeholder: 'Pilih Unit Kerja'
    });
})

$('#direktorat-lesson-init').on('select2:select', function (e) {
    cekDivisi('select', e.params.data.id)
})

$('#direktorat-lesson-init').on('select2:unselect', function(e){
    cekDivisi('unselect', e.params.data.id)
});

$('#divisi-lesson-init').on('select2:select', function (e) {
    divisiParam = e.params.data.id
    getData(tahapParam, divisiParam, keyParam)
})

const cekDivisi = (selOrUn, value) => {
    if($('#divisi-lesson-init').hasClass('is-invalid') || $('#divisi-lesson-init').hasClass('is-valid')){
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
                        $('#divisi-lesson-init').append(`<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`);
                    } else {
                        $(`#divisi-lesson-init option[value="${data.data[index].id}"]`).detach();
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

function sortByTahap(params){
    tahapParam = document.getElementById(params).getAttribute('data-value')
    if (tahapParam !== 'init'){
        if (tahapParam === 'plan'){
            document.getElementById('btn-sort-lesson').innerHTML = "Plan"
            document.getElementById('main-title-lesson').innerHTML = "Plan"
        }else if (tahapParam === 'procurement'){
            document.getElementById('btn-sort-lesson').innerHTML = "Procurement"
            document.getElementById('main-title-lesson').innerHTML = "Procurement"
        }else if (tahapParam === 'development'){
            document.getElementById('btn-sort-lesson').innerHTML = "Development"
            document.getElementById('main-title-lesson').innerHTML = "Development"
        }else if (tahapParam === 'pilot'){
            document.getElementById('btn-sort-lesson').innerHTML = "Pilot"
            document.getElementById('main-title-lesson').innerHTML = "Pilot"
        }else if (tahapParam === 'implementation'){
            document.getElementById('btn-sort-lesson').innerHTML = "Implementation"
            document.getElementById('main-title-lesson').innerHTML = "Implementation"
        }
        getData(tahapParam, divisiParam, keyParam)
    }else{
        getData('', divisiParam, keyParam)
        document.getElementById('btn-sort-lesson').innerHTML = "Tahap Proyek"
        document.getElementById('main-title-lesson').innerHTML = "All"
    }
}

function searchLesson(){
    keyParam = document.getElementById("searchLessoninit").value;
    getData(tahapParam, divisiParam, keyParam)
}

function getData(tahap, divisi, search){
    const url = `${getCookie('url_be')}api/managelessonlearned?tahap=${tahap}&divisi=${divisi}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#container-review").html("");
            let namaLesson = "";
            let descLesson = "";
            for (let i=0; i < data.data.length; i++) {
                if (data.data[i].lesson_learned.length !== 0 || data.data[i].consultant.length !== 0) {
                    for (let ilesson=0; ilesson < data.data[i].lesson_learned.length; ilesson++){
                        namaLesson = data.data[i].lesson_learned[ilesson].lesson_learned
                        descLesson = data.data[i].lesson_learned[ilesson].detail
                    }
                    $("#container-review").append(`<div class="card card-body w-100 d-flex mb-1" style="border-radius: 10px">
                        <div class="row">
                            <div class="col-2">
                                <p class="text-primary">${data.data[i].divisi.direktorat}</p>
                            </div>
                            <div class="col-3">
                                <p class="text-primary">${data.data[i].divisi.divisi}</p>
                            </div>
                            <div class="col-3">
                                <p>${data.data[i].nama}</p>
                            </div>
                            <div class="col-2">
                                 <p class="text-primary">${data.data[i].consultant[0].nama}</p>
                            </div>
                            <div class="col-2">
                                <a href="{{route('kontribusi.edit', $value->slug)}}" class="btn btn-outline-secondary fas fa-pen"></a>
                                <button class="btn btn-outline-secondary fas fa-trash"></button>
                                <button class="btn btn-outline-secondary fas fa-caret-down" data-toggle="collapse" href="#${data.data[i].nama.trim()}" aria-expanded="false" aria-controls="${data.data[i].nama.trim()}"></button>
                            </div>
                        </div>
                            <div class="collapse" id="${data.data[i].nama.trim()}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <h6>Lesson Learned</h6>
                                        </div>
                                        <div class="col-8">
                                            <h6>Keterangan</h6>
                                        </div>
                                    </div>
                                    <hr/>
                                        <div class="row">
                                            <div class="col-4">
                                                <p>${namaLesson}</p>
                                            </div>
                                            <div class="col-8">
                                                <p>${descLesson}</p>
                                            </div>
                                        </div>
                                        <hr/>
                                </div>
                            </div>
                    </div>`)
                }else{
                    $("#container-review").append(`<div class="card card-body w-100 d-flex mb-1" style="border-radius: 10px">
                        <div class="row">
                            <div class="col-2">
                                <p class="text-primary">${data.data[i].divisi.direktorat}</p>
                            </div>
                            <div class="col-3">
                                <p class="text-primary">${data.data[i].divisi.divisi}</p>
                            </div>
                            <div class="col-3">
                                <p>${data.data[i].nama}</p>
                            </div>
                            <div class="col-2">
                                 <p class="text-primary">Internal</p>
                            </div>
                            <div class="col-2">
                                <a href="{{route('kontribusi.edit', $value->slug)}}" class="btn btn-outline-secondary fas fa-pen"></a>
                                <button class="btn btn-outline-secondary fas fa-trash"></button>
                            </div>
                        </div>
                            <div class="collapse" id="empty">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <h6>Lesson Learned</h6>
                                        </div>
                                        <div class="col-8">
                                            <h6>Keterangan</h6>
                                        </div>
                                    </div>
                                    <hr/>
                                        <div class="row">
                                            <div class="col-4">
                                                <p>EMPTY</p>
                                            </div>
                                            <div class="col-8">
                                                <p>EMPTY</p>
                                            </div>
                                        </div>
                                        <hr/>
                                </div>
                            </div>
                    </div>`)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });

}

