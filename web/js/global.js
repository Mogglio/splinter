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

// $('#validate_os').on('click', function(){
//     var chosenOs = $('#image').val();
//     var generateButton = $('#generate_docker_file');
//     $.ajax({
//         url:'/validate_os',
//         type:'POST',
//         dataType:'json',
//         data: {
//             'chosen_os': chosenOs
//         },
//         async: true,
//         success: function (data)
//         {
//             var osSelector = document.getElementById("os_version");
//             var Content = '';
//             if (!osSelector) {
//                 Content = '<label for="os_version"><select id="os_version" name="os_version">';
//                 data.results.forEach(function (os_version) {
//                     Content += '<option value="' + os_version.name + '">' + os_version.name + '</option>';
//                 });
//                 Content += '</select></label>';
//                 $('#os_versions_block').append(Content);
//             } else {
//                 $(osSelector).remove();
//                 Content = '<select id="os_version" name="os_version">';
//                 Content += '<option value="latest">latest</option>';
//                 data.results.forEach(function (os_version) {
//                     Content += '<option value="' + os_version.name + '">' + os_version.name + '</option>';
//                 });
//                 Content += '</select>';
//                 $('#os_versions_block').append(Content);
//             }
//
//             generateButton.css('visibility', 'visible');
//             generateButton.prop("disabled", false);
//         }
//     })
// });
