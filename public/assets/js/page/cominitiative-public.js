let selections = [];
var csrf = '';
let urlBE = "";

function getData(params){
    const types = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
    const url = `${uri}/api/get/communicationinitiative/publish/instagram`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(data){
            console.log("DATA GET"+data)
        },
        error : function(e){
            alert(e);
        }
    });


}

$(document).ready(function() {
    // getData("ig")
});
