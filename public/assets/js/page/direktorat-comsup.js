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
var splitLastPath = window.location.pathname.split('/');

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

if (splitLastPath[4]==='cominit'){
    getDataComsupDiv()
}else if (splitLastPath[4]==='strategic'){
    getDataStraDiv()
}else if (splitLastPath[4] === 'implementation'){
    getDataImpl()
}

function getDataComsupDiv(){
    //todo change api
    const url = `${getCookie('url_be')}api/divisi/3`
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
            if(data.data.data_cominit === undefined || data.data.data_cominit.length !== 0){
                for (let index=0; index < data.data.data_cominit.length; index++){
                    $("#row-cominit-div").append(`
                    <div class="col-md-6 col-sm-12 rowdoc">
                                <a href="http://127.0.0.1:9998/mycomsupport/initiative/video?slug=2022101716546-transformasi-bri" style="text-decoration: none">
                                    <div class="card border control list-project mb-2">
                                        <div class="row px-3">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                                <div class="row d-flex justify-content-center">
                                                    <img src="http://127.0.0.1:9998/storage/document/thumbnail/634d260524af4-1666000389/Ke8xZvFiqQXfvCBme7cfm6coqSpWa2eb3Wq7pL6n.png" width="120%" class="thumb card-img-left border-0">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                                <div class="card-body content-project">
                                                    <span class="d-block text-dark header-list-project mb-1">Transformasi BRI</span>
                                                    <small>
                                                        video
                                                    </small>
                                                    <small class="d-block">2022-09-01</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                </div>
                `)
                }
            }else{
                $("#container-cominit-div").append(`
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

function getDataStraDiv(){
    const url = `${getCookie('url_be')}api/divisi/3`
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
            if(data.data.data_stra === undefined || data.data.data_stra.length !== 0){
                for (let index=0; index < data.data.data_stra.length; index++){
                    $("#row-cominit-div").append(`
                    <div class="col-md-6 col-sm-12 rowdoc">
                                <a href="http://127.0.0.1:9998/mycomsupport/initiative/video?slug=2022101716546-transformasi-bri" style="text-decoration: none">
                                    <div class="card border control list-project mb-2">
                                        <div class="row px-3">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                                <div class="row d-flex justify-content-center">
                                                    <img src="http://127.0.0.1:9998/storage/document/thumbnail/634d260524af4-1666000389/Ke8xZvFiqQXfvCBme7cfm6coqSpWa2eb3Wq7pL6n.png" width="120%" class="thumb card-img-left border-0">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                                <div class="card-body content-project">
                                                    <span class="d-block text-dark header-list-project mb-1">Transformasi BRI</span>
                                                    <small>
                                                        video
                                                    </small>
                                                    <small class="d-block">2022-09-01</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                </div>
                `)
                }
            }else{
                $("#container-stra-div").append(`
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

function getDataImpl(){
    const url = `${getCookie('url_be')}api/divisi/3`
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
            if(data.data.data_impl === undefined || data.data.data_impl.length !== 0){
                for (let index=0; index < data.data.data_impl.length; index++){
                    $("#row-cominit-div").append(`
                    <div class="col-md-6 col-sm-12 rowdoc">
                                <a href="http://127.0.0.1:9998/mycomsupport/initiative/video?slug=2022101716546-transformasi-bri" style="text-decoration: none">
                                    <div class="card border control list-project mb-2">
                                        <div class="row px-3">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-cente thumb-katalog">
                                                <div class="row d-flex justify-content-center">
                                                    <img src="http://127.0.0.1:9998/storage/document/thumbnail/634d260524af4-1666000389/Ke8xZvFiqQXfvCBme7cfm6coqSpWa2eb3Wq7pL6n.png" width="120%" class="thumb card-img-left border-0">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1 d-flex align-items-center">
                                                <div class="card-body content-project">
                                                    <span class="d-block text-dark header-list-project mb-1">Transformasi BRI</span>
                                                    <small>
                                                        video
                                                    </small>
                                                    <small class="d-block">2022-09-01</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                </div>
                `)
                }
            }else{
                $("#container-impl-div").append(`
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
