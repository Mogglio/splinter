$(document).ready(function () {
    if (document.getElementById('tags')) {
        $('#tags').tagsInput({
            'height': '150px',
            'width': '100%',
            'interactive': true,
            'defaultText': 'add a tag',
            'removeWithBackspace': true,
            'placeholderColor': '#666666',
            'onAddTag':addTagFunction,
        });
    }
});

$('.history-container .vm-container button').on('click', function (e) {
    var container = $(this).parent();

    var vmName = $(container).find('li.vm-name').text();
    var idServer = $(container).find('li.id-server').text();

    ajaxRequest(vmName, idServer, container);
});

const ajaxRequest = function(vmName, idServer, container){

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
            container.hide();
        },
        error: function (d) {
            console.log("error");
        }
    });
};

function addTagFunction() {
    var tags_input = $('#tags').val();
    console.log(tags_input);
}


