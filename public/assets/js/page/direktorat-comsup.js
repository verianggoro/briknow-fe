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

if (lastpath ==='cominit'){
    getDataComsupDiv()
}else if (lastpath ==='strategic'){
    getDataStraDiv()
}else if (lastpath === 'implementation'){
    getDataImpl()
}

function getDataComsupDiv(){
    var elementInit = document.getElementById("btn-dir-init");
    var elementStra = document.getElementById("btn-dir-stra");
    var elementImpl = document.getElementById("btn-dir-impl");
    elementInit.classList.add("active");
    elementStra.classList.remove("active");
    elementImpl.classList.remove("active");
    clearLayout()
    const urlArticle = `${getCookie('url_be')}api/get/communicationinitiative/publish/article?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    const urlLogo = `${getCookie('url_be')}api/get/communicationinitiative/publish/logo?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    const urlInfo = `${getCookie('url_be')}api/get/communicationinitiative/publish/infographics?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    const urlTrans = `${getCookie('url_be')}api/get/communicationinitiative/publish/transformation?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    const urlPodcast = `${getCookie('url_be')}api/get/communicationinitiative/publish/podcast?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    const urlVideo = `${getCookie('url_be')}api/get/communicationinitiative/publish/video?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    const urlIg = `${getCookie('url_be')}api/get/communicationinitiative/publish/instagram?page=1&year=&month=&divisi=&sort=&search=${keywordParam}&divisi&direktorat=${splitLastPath[3]}`
    $.ajax({
        url: urlArticle,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-artikel-div").empty();
            $("#title-artikel-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-artikel-dir").append(`<h6>Artikel</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-artikel-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'article')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'article')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }else{
                $("#row-artikel-div").append(`
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
    $.ajax({
        url: urlLogo,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-logo-div").empty();
            $("#title-logo-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-logo-dir").append(`<h6>Logo</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-logo-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'logo')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'logo')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlInfo,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-infographics-div").empty();
            $("#title-infographics-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-infographics-dir").append(`<h6>Infographics</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-infographics-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'infographics')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'infographics')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlTrans,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-transformation-div").empty();
            $("#title-transformation-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-transformation-dir").append(`<h6>Transformation</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-transformation-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'transformation')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'transformation')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlPodcast,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-podcast-div").empty();
            $("#title-podcast-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-podcast-dir").append(`<h6>Podcast</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-podcast-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'podcast')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'podcast')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlVideo,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-video-div").empty();
            $("#title-video-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-video-dir").append(`<h6>Video</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-video-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'video')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'video')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlIg,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-instagram-div").empty();
            $("#title-instagram-dir").empty()
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if(data.data.data === undefined || data.data.data.length !== 0){
                $("#title-instagram-dir").append(`<h6>Instagram</h6>`)
                for (let index=0; index < data.data.data.length; index++){
                    $("#row-instagram-div").append(`
                                        <div class="col-lg-4 d-flex justify-content-center shadow-sm">
                                            <div class="card" style="border-radius: 16px">
                                                <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'instagram')">
                                                    <img class="card-img-up"
                                                         src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                         alt="Card image cap">
                                                </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreviewGo('${data.data.data[index].slug}', 'instagram')">
                                                        <h5 class="card-title">${data.data.data[index].title}</h5>
                                                    </button>
                                                    <p>${data.data.data[index].desc.substring(0,100)}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                                                        </i>
                                                        <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                                                            <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                            onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                                                            <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                        </button>
                                                        <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                                                            <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function getDataStraDiv(){
    var elementInit = document.getElementById("btn-dir-init");
    var elementStra = document.getElementById("btn-dir-stra");
    var elementImpl = document.getElementById("btn-dir-impl");
    elementInit.classList.remove("active");
    elementStra.classList.add("active");
    elementImpl.classList.remove("active");
    clearLayout()
    const url = `${getCookie('url_be')}api/get/strategic/publish?year=&month=&divisi=&sort=&search=${keywordParam}&direktorat=${splitLastPath[3]}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#title-artikel-dir").empty();
            $("#row-artikel-div").empty();
            $("#title-logo-dir").empty();
            $("#row-logo-div").empty();
            $("#title-infographics-dir").empty();
            $("#row-infographics-div").empty();
            $("#title-instagram-dir").empty();
            $("#row-instagram-div").empty();
            $("#title-video-dir").empty();
            $("#row-video-div").empty();
            $("#title-podcast-dir").empty();
            $("#row-podcast-div").empty();
            $("#title-transformation-dir").empty();
            $("#row-transformation-div").empty();
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if (data.data.length !== 0){
                for (let index=0; index < data.data.length; index++){
                    $("#row-artikel-div").append(`
                    <div class="col-lg-4 d-flex justify-content-center">
                                                <a class="w-100" href="${uri+'/mycomsupport/strategic/'+data.data[index].slug}">
                                                    <div class="card" style="border-radius: 16px;">
                                                        <img class="card-img-up" src="${uri+'/storage/'+data.data[index].thumbnail}"
                                                             alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-center">${data.data[index].nama}</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                `)
                }
            }else{
                $("#row-artikel-div").append(`
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
    var elementInit = document.getElementById("btn-dir-init");
    var elementStra = document.getElementById("btn-dir-stra");
    var elementImpl = document.getElementById("btn-dir-impl");
    elementInit.classList.remove("active");
    elementStra.classList.remove("active");
    elementImpl.classList.add("active");
    clearLayout()
    const urlPilot = `${getCookie('url_be')}api/get/implementation/all/publish/piloting?year=&month=&divisi=&sort=&search=${keywordParam}&page=1&direktorat=${splitLastPath[3]}`
    const urlRoll = `${getCookie('url_be')}api/get/implementation/all/publish/roll-out?year=&month=&divisi=&sort=&search=${keywordParam}&page=1&direktorat=${splitLastPath[3]}`
    const urlSosial = `${getCookie('url_be')}api/get/implementation/all/publish/sosialisasi?year=&month=&divisi=&sort=&search=${keywordParam}&page=1&direktorat=${splitLastPath[3]}`
    $.ajax({
        url: urlPilot,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-artikel-div").empty();
            $("#title-artikel-dir").empty();
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if (data.data.data !== undefined && data.data.data.length !== 0){
                $("#title-artikel-dir").append(`<h6>Piloting</h6>`)
                for (let index=0; index < data.data.data.length; index++) {
                    $("#row-artikel-div").append(`
                         <div class="container-fluid">
                            <div class="card d-flex w-100 p-2" style="border-radius: 16px; width: 30rem">
                                <a href="${uri+'/view/implementation/'+data.data.data[index].slug}">
                                    <div class="row">
                                    <div class="col-lg-2">
                                        <img class="card-img" style="height: auto;" src="${uri+'/storage/'+data.data.data[index].thumbnail}" alt="Card image cap">
                                    </div>
                                    <div class="col-lg-10">
                                        <h4>${data.data.data[index].title}</h4>
                                        <div style="background-color: #0a53be; border-radius: 10px;">
                                                <p class="text-white m-2">PILOTING</p>
                                        </div>
                                        <p>${data.data.data[index].desc_piloting.substring(0,200)}</p>
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
                </div>
                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlRoll,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-video-div").empty();
            $("#title-video-dir").empty();
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if (data.data.data !== undefined && data.data.data.length !== 0){
                $("#title-video-dir").append(`<h6>Roll-Out</h6>`)
                for (let index=0; index < data.data.data.length; index++) {
                    $("#row-video-div").append(`
                         <div class="container-fluid">
                            <div class="card d-flex w-100 p-2" style="border-radius: 16px; width: 30rem">
                                <a href="${uri+'/view/implementation/'+data.data.data[index].slug}">
                                    <div class="row">
                                    <div class="col-lg-2">
                                        <img class="card-img" style="height: auto;" src="${uri+'/storage/'+data.data.data[index].thumbnail}" alt="Card image cap">
                                    </div>
                                    <div class="col-lg-10">
                                        <h4>${data.data.data[index].title}</h4>
                                        <div style="background-color: #0a53be; border-radius: 10px;">
                                                <p class="text-white m-2">ROLL-OUT</p>
                                        </div>
                                        <p>${data.data.data[index].desc_piloting.substring(0,200)}</p>
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
                </div>
                `)
                }
            }
        },
        error : function(e){
            alert(e);
        }
    });
    $.ajax({
        url: urlSosial,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#row-logo-div").empty();
            $("#title-logo-dir").empty();
            $('#prev').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if (data.data.data !== undefined && data.data.data.length !== 0){
                $("#title-logo-dir").append(`<h6>Piloting</h6>`)
                for (let index=0; index < data.data.data.length; index++) {
                    $("#row-logo-div").append(`
                         <div class="container-fluid">
                            <div class="card d-flex w-100 p-2" style="border-radius: 16px; width: 30rem">
                                <a href="${uri+'/view/implementation/'+data.data.data[index].slug}">
                                    <div class="row">
                                    <div class="col-lg-2">
                                        <img class="card-img" style="height: auto;" src="${uri+'/storage/'+data.data.data[index].thumbnail}" alt="Card image cap">
                                    </div>
                                    <div class="col-lg-10">
                                        <h4>${data.data.data[index].title}</h4>
                                        <div style="background-color: #0a53be; border-radius: 10px;">
                                                <p class="text-white m-2">SOSIALISASI</p>
                                        </div>
                                        <p>${data.data.data[index].desc_piloting.substring(0,200)}</p>
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

function download(id) {
    window.location.href = uri+`/attach/download/content/${id}`;
}

function migrasi(pesan) {
    var kopi = document.getElementById("link");
    kopi.value = pesan
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

function searchCominitDir(){
    keywordParam = document.getElementById("searchCominitDir").value;
    var elementInit = document.getElementById("btn-dir-init");
    var elementStra = document.getElementById("btn-dir-stra");
    var elementImpl = document.getElementById("btn-dir-impl");
    if (elementInit.classList.contains('active')){
        getDataComsupDiv()
    }else if(elementStra.classList.contains('active')){
        getDataStraDiv()
    }else if (elementImpl.classList.contains('active')){
        getDataImpl()
    }
}

function openPreviewGo(slug, type) {
    window.location.href = `${uri}/mycomsupport/initiative/${type}?slug=${slug}`
}

function clearLayout(){
    $("#title-artikel-dir").empty();
    $("#row-artikel-div").empty();
    $("#title-logo-dir").empty();
    $("#row-logo-div").empty();
    $("#title-infographics-dir").empty();
    $("#row-infographics-div").empty();
    $("#title-instagram-dir").empty();
    $("#row-instagram-div").empty();
    $("#title-video-dir").empty();
    $("#row-video-div").empty();
    $("#title-podcast-dir").empty();
    $("#row-podcast-div").empty();
    $("#title-transformation-dir").empty();
    $("#row-transformation-div").empty();
}
