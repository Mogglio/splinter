$(document).ready(function () {
    if (document.getElementById('tags')) {
        $('#tags').tagsInput({
            'height': '150px',
            'width': '100%',
            'interactive': true,
            'defaultText': 'add a tag',
            'removeWithBackspace': true,
            'placeholderColor': '#666666'
        });
    }
});

$('.history-container .vm-container button').on('click', function (e) {
    console.log("coucou");
    var container = $(this).parent();
    container.hide();

    var vmName = $(container).find('li.vm-name').text();
    var idServer = $(container).find('li.id-server').text();

    ajaxRequest(vmName, idServer);
});

const ajaxRequest = function(vmName, idServer){

    var data = {};
    if(vmName){
        data = {
            "vmName" : vmName,
            "idServer" : idServer
        }
    }

    $.ajax({
        url: historyAjaxRouteName,
        type: "POST",
        dataType: "json",
        data: data,
        async: true,
        success: function () {
            console.log("success");
        },
        error: function (d) {
            console.log("error");
        }
    });
};

