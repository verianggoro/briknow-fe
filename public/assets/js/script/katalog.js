let uri;
let sort = '';
let csrf = '';
let sklt = `<div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div>`;

//  divisi
let filter_divisi   = [];
filter_divisi       = localStorage.getItem('fil_div')??[];
console.log(`filter_divisi : ${filter_divisi}`);
if (filter_divisi   ===  "" || typeof(filter_divisi) === null) {
    filter_divisi   =   [];
}else{
    try {
        filter_divisi = filter_divisi.split(',') === [""] ? [] : filter_divisi.split(',');
    } catch (error) {
        filter_divisi   =   [];
    }
}
if (filter_divisi.length > 0) {
    for (let index = 0; index < filter_divisi.length; index++) {
        $(`.fil_div[value="${filter_divisi[index]}"]`).prop('checked',true);
        $(`.fil_div_d[value="${filter_divisi[index]}"]`).prop('checked',true);
    }
}

//  konsultan
let filter_konsultant = [];
filter_konsultant = localStorage.getItem('fil_kon')??[];
console.log(`filter_konsultant : ${filter_konsultant}`);
if (filter_konsultant   ===  "" || typeof(filter_konsultant) === null) {
    filter_konsultant   =   [];
}else{
    try {
        filter_konsultant = filter_konsultant.split(',') === [""] ? [] : filter_konsultant.split(',');
    } catch (error) {
        filter_konsultant = [];
    }
}
if (filter_konsultant.length > 0) {
    for (let index = 0; index < filter_konsultant.length; index++) {
        $(`.fil_kon[value="${filter_konsultant[index]}"]`).prop('checked',true);
        $(`.fil_kon_d[value="${filter_konsultant[index]}"]`).prop('checked',true);
    }
}

//  Tahun
let filter_tahun = [];
filter_tahun = localStorage.getItem('fil_thn')??[];
console.log(`filter_tahun : ${filter_tahun}`);
if (filter_tahun   ===  "") {
    filter_tahun   =   [];
}else{
    try {
        filter_tahun = filter_tahun.split(',') === [""] ? [] : filter_tahun.split(',');
    } catch (error) {
        filter_tahun = [];
    }
}
if (filter_tahun.length > 0) {
    for (let index = 0; index < filter_tahun.length; index++) {
        $(`.fil_thn[value="${filter_tahun[index]}"]`).prop('checked',true);
        $(`.fil_thn_d[value="${filter_tahun[index]}"]`).prop('checked',true);
    }
}
// console.log(`filter Tahun : ${filter_tahun}`);

//  Lesson learne
let filter_lessonlearn = [];
filter_lessonlearn = localStorage.getItem('fil_les')??[];
console.log(`filter_lessonlearn : ${filter_lessonlearn}`);
if (filter_lessonlearn   ===  "" || typeof(filter_lessonlearn) === null) {
    filter_lessonlearn   =   [];
}else{
    try {
        filter_lessonlearn = filter_lessonlearn.split(',') === [""] ? [] : filter_lessonlearn.split(',');
    } catch (error) {
        filter_lessonlearn = [];
    }
}
if (filter_lessonlearn.length > 0) {
    for (let index = 0; index < filter_lessonlearn.length; index++) {
        $(`.fil_les[value="${filter_lessonlearn[index]}"]`).prop('checked',true);
        $(`.fil_les_d[value="${filter_lessonlearn[index]}"]`).prop('checked',true);
    }
}

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
      uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "kunci") {
        search = metas[i].getAttribute('content');
        if (search !== '*') {
            search  =   `*${search}*`;
        }
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

// paginate
let from = 0;
let all = 0;
let data_inpage = 0;
let page_active = 0;
let per_page = 10;

// filter
let centang = `<svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
let centang2 = `<svg class="w-6 h-6 mr-2 centang2 float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;

// Logic Ascending
$("#az").click(function(e){
    from = 0;
    all = 0;
    data_inpage = 0;
    page_active = 0;
    $('.centang2').remove();
    if (sort == 'asc') {
        sort = '';
    }else{
        sort = 'asc';
        $('#az').append(centang2);
    }
    getData();
});
$("#za").click(function(e){
    from = 0;
    all = 0;
    data_inpage = 0;
    page_active = 0;
    $('.centang2').remove();
    if (sort == 'desc') {
        sort = '';
    }else{
        sort = 'desc';
        $('#za').append(centang2);
    }
    getData();
});

// paginator
const paginator = () =>{
    // let temp_pag = paginate_prev;
    let temp_pag = "";
    if (all > per_page) {
        // urutan pagination
        let page_urut=0;
        //  jangka jarak
        let jarak = page_active - 2;
        // awal
        if (jarak > 1) {
            temp_pag += `<li class="page-item"><a class="page-link" href="#" onclick='paging(0)'>${0+1}</a></li>`;
            temp_pag += `<li class="page-item disabled"><a class="page-link" href="#">..</a></li>`;
            page_urut = jarak;
            jarak *= 10;
        }else{
            jarak = 0;
        }
        // akhir
        let button_per_page = 2;
        let button_per_page_now = 0;
        let button_per_page_shuttle = 0;

        // looping
        for (let index = jarak; index < all; index+=per_page) {
            if (button_per_page_now <= button_per_page) {
                if (page_urut==page_active) {
                    temp_pag += `<li class="page-item active"><a class="page-link" href="#" onclick='paging(${page_urut})'>${page_urut+1}</a></li>`;
                }else{
                    temp_pag += `<li class="page-item"><a class="page-link" href="#" onclick='paging(${page_urut})'>${page_urut+1}</a></li>`;
                }
            }else{
                button_per_page_shuttle = page_urut;
            }
            
            page_urut++;
            if (page_urut > page_active) {
                button_per_page_now++;
            }
        }
    }else{
        temp_pag += '<li class="page-item active disabled"><a class="page-link" href="#">1</a></li>';
    }
    // akhir
    if (typeof button_per_page_shuttle !== 'undefined') {        
        if (button_per_page_shuttle > 0) {
            temp_pag += `<li class="page-item disabled"><a class="page-link" href="#">..</a></li>`;
            temp_pag += `<li class="page-item"><a class="page-link" href="#" onclick='paging(${button_per_page_shuttle})'>${button_per_page_shuttle+1}</a></li>`;
        }
    }

    // paginate
    $("#pagination").append(temp_pag);

    // result
    $("#first_number").text(from+1);
    let last_number = all - from;
    if (last_number < per_page) {
        $("#last_number").text(all);
    }else{
        $("#last_number").text(from+=10);
    }
}

const paging = (page_urut) =>{
    if (page_urut == 0) {
        from = 0;
    }else{
        from = page_urut * 10;
    }

    if (page_active > page_urut) {
        let jarak = page_active - page_urut;
        page_active -= jarak;
    }else if (page_active < page_urut){
        let jarak = page_urut - page_active;
        page_active += jarak;
    }
    getData();
}

function searchProject(){
    let keyParams = $("#search-form").val()
    localStorage.removeItem("key_search");

    if (keyParams.length > 0) {
        localStorage.setItem("key_search",keyParams);
    } else {
        localStorage.setItem("key_search", '');
    }
    getData()
}

// filter
// divisi
$(".fil_div_d").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_divisi.push(e.target.value);
        $(`.fil_div[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_divisi.indexOf(e.target.value);
        if (index > -1) {
            filter_divisi.splice(index, 1);
        }
        $(`.fil_div[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',false);
    }
    localStorage.setItem("fil_div",[]);
    localStorage.setItem("fil_div",filter_divisi);
    getData();
})

$(".fil_div").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_divisi.push(e.target.value);
        $(`.fil_div[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_divisi.indexOf(e.target.value);
        if (index > -1) {
            filter_divisi.splice(index, 1);
        }
        $(`.fil_div[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',false);
    }
})

$(".fil-div-res").click(function(e){
    $('.fil_div').prop('checked',false);
    $('.fil_div_d').prop('checked',false);
    localStorage.setItem("fil_div",[]);
    filter_divisi=[];
    getData();
})

$(".fil-div-app").click(function(e){
    localStorage.setItem("fil_div",[]);
    localStorage.setItem("fil_div",filter_divisi);
    getData();
})
// consultant
$(".fil_kon_d").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_konsultant.push(e.target.value);
        $(`.fil_kon[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_konsultant.indexOf(e.target.value);
        if (index > -1) {
            filter_konsultant.splice(index, 1);
        }
        $(`.fil_kon[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',false);
    }
    localStorage.setItem("fil_kon",[]);
    localStorage.setItem("fil_kon",filter_konsultant);
    getData();
})

$(".fil_kon").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_konsultant.push(e.target.value);
        $(`.fil_kon[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_konsultant.indexOf(e.target.value);
        if (index > -1) {
            filter_konsultant.splice(index, 1);
        }
        $(`.fil_kon[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',false);
    }
})

$(".fil-kon-res").click(function(e){
    $('.fil_kon').prop('checked',false);
    $('.fil_kon_d').prop('checked',false);
    localStorage.setItem("fil_kon",[]);
    filter_konsultant=[];
    getData();
})

$(".fil-kon-app").click(function(e){
    localStorage.setItem("fil_kon",[]);
    localStorage.setItem("fil_kon",filter_konsultant);
    getData();
})
// tahun
$(".fil_thn_d").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_tahun.push(e.target.value);
        $(`.fil_thn[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_tahun.indexOf(e.target.value);
        if (index > -1) {
            filter_tahun.splice(index, 1);
        }
        $(`.fil_thn[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',false);
    }
    localStorage.setItem("fil_thn",[]);
    localStorage.setItem("fil_thn",filter_tahun);
    getData();
})

$(".fil_thn").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_tahun.push(e.target.value);
        $(`.fil_thn[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_tahun.indexOf(e.target.value);
        if (index > -1) {
            filter_tahun.splice(index, 1);
        }
        $(`.fil_thn[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',false);
    }
})

$(".fil-thn-res").click(function(e){
    $('.fil_thn').prop('checked',false);
    $('.fil_thn_d').prop('checked',false);
    localStorage.setItem("fil_thn",[]);
    filter_tahun=[];
    getData();
})

$(".fil-thn-app").click(function(e){
    localStorage.setItem("fil_thn",[]);
    localStorage.setItem("fil_thn",filter_tahun);
    getData();
})
// lessonlearn
$(".fil_les_d").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_lessonlearn.push(e.target.value);
        $(`.fil_les[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_lessonlearn.indexOf(e.target.value);
        if (index > -1) {
            filter_lessonlearn.splice(index, 1);
        }
        $(`.fil_les[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',false);
    }
    localStorage.setItem("fil_les",[]);
    localStorage.setItem("fil_les",filter_lessonlearn);
    getData();
})

$(".fil_les").change(function(e){
    if ($(this).prop('checked')==true){ 
        // add item
        filter_lessonlearn.push(e.target.value);
        $(`.fil_les[value="${e.target.value}"]`).prop('checked',true);
        $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',true);
    }else{
        // remove item
        const index = filter_lessonlearn.indexOf(e.target.value);
        if (index > -1) {
            filter_lessonlearn.splice(index, 1);
        }
        $(`.fil_les[value="${e.target.value}"]`).prop('checked',false);
        $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',false);
    }
})

$(".fil-les-res").click(function(e){
    $('.fil_les').prop('checked',false);
    $('.fil_les_d').prop('checked',false);
    localStorage.setItem("fil_les",[]);
    filter_lessonlearn=[];
    getData();
})

$(".fil-les-app").click(function(e){
    localStorage.setItem("fil_les",[]);
    localStorage.setItem("fil_les",filter_lessonlearn);
    getData();
})

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

// get data
const getData = () =>{
    // filter
    let h_div="";
    for (let index = 0; index < filter_divisi.length; index++) {
        if (h_div   ==  "") {
            h_div   =  `${filter_divisi[index]}`;
        }else{
            h_div   +=  `-${filter_divisi[index]}`;
        }
    }
    let h_kon = "";
    for (let index = 0; index < filter_konsultant.length; index++) {
        if (h_kon   ==  "") {
            h_kon   =  `${filter_konsultant[index]}`;
        }else{
            h_kon   +=  `-${filter_konsultant[index]}`;
        }
    }
    let h_thn="";
    for (let index = 0; index < filter_tahun.length; index++) {
        if (h_thn   ==  "") {
            h_thn   =  `${filter_tahun[index]}`;
        }else{
            h_thn   +=  `-${filter_tahun[index]}`;
        }
    }
    let h_les="";
    for (let index = 0; index < filter_lessonlearn.length; index++) {
        if (h_les   ==  "") {
            h_les   =  `${filter_lessonlearn[index]}`;
        }else{
            h_les   +=  `-${filter_lessonlearn[index]}`;
        }
    }

    let key_search = localStorage.getItem('key_search') || '';

    let url;
    url = `${getCookie('url_be')}api/kat?search=${key_search}&tahap=${h_les}&divisi=${h_div}&consultant=${h_kon}&sort=${sort}`;
    console.log(url);
    // &tahun=${h_thn}&lesson=${h_les}

    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#result").html("");
            if (data.data.length !== 0){
                for (let i=0; i < data.data.length; i++) {
                    $("#result").append(`
                    <div class="col-lg-6 col-sm-12 data">
                        <a href="${uri+ '/project/'+data.data[i].slug}" class="text-decoration-none">
                            <div class="card border control list-project mb-2">
                                <div class="row px-3">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-center thumb-katalog">
                                        <div class="row d-flex justify-content-center">
                                            <img src="${uri+ '/storage/'+data.data[i].thumbnail}" width="120%" class="card-img-left border-0 rounded thumb">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1">
                                        <div class="card-body content-project">
                                            <span class="d-block text-dark header-list-project mb-1">${data.data[i].nama}</span>
                                            <small>
                                                ${data.data[i].consultant == '' ? 'Internal' : data.data[i].consultant[0].nama}
                                            </small>
                                            <small class="d-block">${data.data[i].project_managers.nama}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    `)
                }
            }else{
                $("#result").append(`
                <div class="p-2 w-100 pt-5 text-center">
                    <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                    <h5 class="font-weight-bold mt-5 mb-1">Oops.. Project tidak ditemukan</h5>
                    <p class="w-100 text-center font-weight-bold">Coba cari project lain</p>
                </div>    
                `)
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

getData();