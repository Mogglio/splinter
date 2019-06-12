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