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

    $("#region-select").change(function() {
        var val = $(this).val();
        if (val == "asia-east1") {
            $("#zone-select").html("<option value='asia-east1-a'>asia-east1-a</option><option value='asia-east1-b'>asia-east1-b</option><option value='asia-east1-c'>asia-east1-c</option>");
        } else if (val == "asia-east2") {
            $("#zone-select").html("<option value='asia-east2-a'>asia-east2-a</option><option value='asia-east2-b'>asia-east2-b</option><option value='asia-east2-c'>asia-east2-c</option>");
        } else if (val == "asia-northeast1") {
            $("#zone-select").html("<option value='asia-northeast1-a'>asia-northeast1-a</option><option value='asia-northeast1-b'>asia-northeast1-b</option><option value='asia-northeast1-c'>asia-northeast1-c</option>");
        } else if (val == "asia-south1") {
            $("#zone-select").html("<option value='asia-south1-a'>asia-south1-a</option><option value='asia-south1-b'>asia-south1-b</option><option value='asia-south1-c'>asia-south1-c</option>");
        } else if (val == "asia-southeast1") {
            $("#zone-select").html("<option value='asia-southeast1-a'>asia-southeast1-a</option><option value='asia-southeast1-b'>asia-southeast1-b</option><option value='asia-southeast1-c'>asia-southeast1-c</option>");
        } else if (val == "australia-southeast1") {
            $("#zone-select").html("<option value='australia-southeast1-a'>australia-southeast1-a</option><option value='australia-southeast1-b'>australia-southeast1-b</option><option value='australia-southeast1-c'>australia-southeast1-c</option>");
        } else if (val == "europe-north1") {
            $("#zone-select").html("<option value='europe-north1-a'>europe-north1-a</option><option value='europe-north1-b'>europe-north1-b</option><option value='europe-north1-c'>europe-north1-c</option>");
        } else if (val == "europe-west1") {
            $("#zone-select").html("<option value='europe-west1-b'>europe-west1-b</option><option value='europe-west1-c'>europe-west1-c</option><option value='europe-west1-d'>europe-west1-d</option>");
        } else if (val == "europe-west2") {
            $("#zone-select").html("<option value='europe-west2-a'>europe-west2-a</option><option value='europe-west2-b'>europe-west2-b</option><option value='europe-west2-c'>europe-west2-c</option>");
        } else if (val == "europe-west3") {
            $("#zone-select").html("<option value='europe-west3-a'>europe-west3-a</option><option value='europe-west3-b'>europe-west3-b</option><option value='europe-west3-c'>europe-west3-c</option>");
        } else if (val == "europe-west4") {
            $("#zone-select").html("<option value='europe-west4-a'>europe-west4-a</option><option value='europe-west4-b'>europe-west4-b</option><option value='europe-west4-c'>europe-west4-c</option>");
        } else if (val == "northamerica-northeast1") {
            $("#zone-select").html("<option value='northamerica-northeast1-a'>northamerica-northeast1-a</option><option value='northamerica-northeast1-b'>northamerica-northeast1-b</option><option value='northamerica-northeast1-c'>northamerica-northeast1-c</option>");
        } else if (val == "southamerica-east1") {
            $("#zone-select").html("<option value='southamerica-east1-a'>southamerica-east1-a</option><option value='southamerica-east1-b'>southamerica-east1-b</option><option value='southamerica-east1-c'>southamerica-east1-c</option>");
        } else if (val == "us-central1") {
            $("#zone-select").html("<option value='us-central1-a'>us-central1-a</option><option value='us-central1-b'>us-central1-b</option><option value='us-central1-c'>us-central1-c</option><option value='us-central1-f'>us-central1-f</option>");
        } else if (val == "us-east1") {
            $("#zone-select").html("<option value='us-east1-b'>us-east1-b</option><option value='us-east1-c'>us-east1-c</option><option value='us-east1-d'>us-east1-d</option>");
        } else if (val == "us-east4") {
            $("#zone-select").html("<option value='us-east4-a'>us-east4-a</option><option value='us-east4-b'>us-east4-b</option><option value='us-east4-c'>us-east4-c</option>");
        } else if (val == "us-west1") {
            $("#zone-select").html("<option value='us-west1-a'>us-west1-a</option><option value='us-west1-b'>us-west1-b</option><option value='us-west1-c'>us-west1-c</option>");
        } else if (val == "us-west2") {
            $("#zone-select").html("<option value='us-west2-a'>us-west2-a</option><option value='us-west2-b'>us-west2-b</option><option value='us-west2-c'>us-west2-c</option>");
        }
    });
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

