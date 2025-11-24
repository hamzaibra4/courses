var url = $("#resolver").val();
$(".topchangeLang").click(function(){
    var lang = $(this).attr('data-value');
    window.location.href = url + "?lang="+lang;
});
// $('form').submit(function(){
//     $(this).find(':input[type=submit]').prop('disabled', true);
//     var block_ele = $(".itemcard");
//     block_ele.block({
//         message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
//         overlayCSS: {
//             backgroundColor: '#FFF',
//             cursor: 'wait',
//         },
//         css: {
//             border: 0,
//             padding: 0,
//             backgroundColor: 'none'
//         }
//     });
// });



$('.pickdate_month').pickadate({
    format:  'mm',
    formatSubmit: 'mm',
    selectMonths: true,
    selectYears: false,
    viewMode: 'years',
});


$('.pickdate_year').pickadate({
    format:  'yyyy',
    formatSubmit: 'yyyy',
    selectMonths: false,
    selectYears: true
});
$('.pickdate_date').pickadate({
    format:  'yyyy-mm-dd',
    formatSubmit: 'yyyy-mm-dd',
    selectMonths: true,
    selectYears: true,
    viewMode: 'years',
});


$('.dobpickdate_year').pickadate({
    format: 'yyyy-mm-dd',
    formatSubmit: 'yyyy-mm-dd',
    selectMonths: true,
    selectYears: 200,   // show 200 years in the dropdown
    min: new Date(1900, 0, 1),
    max: new Date()
});



$('.pickdate_date2').pickadate({
    format: 'yyyy-mm-dd',
    formatSubmit: 'yyyy-mm-dd',
    selectMonths: true,
    selectYears: true,
    viewMode: 'years',
    min: true  // Disables past dates
});



$('img[data-enlargable]').addClass('img-enlargable').click(function(){
    var src = $(this).attr('src');
    $('<div>').css({
        background: 'RGBA(0,0,0,.5) url('+src+') no-repeat center',
        backgroundSize: 'contain',
        width:'100%', height:'100%',
        position:'fixed',
        zIndex:'10000',
        top:'0', left:'0',
        cursor: 'zoom-out'
    }).click(function(){
        $(this).remove();
    }).appendTo('body');
});
function previewFile(input, id) {
    var file = input.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            $("#" + id).show();
            $("#" + id).attr("src", reader.result);
        };
        reader.readAsDataURL(file);
    }
}


function previewFiles(input, containerId) {
    var files = input.files;
    var container = $("#" + containerId);
    container.empty();
    if (files) {
        Array.from(files).forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = $("<img>"); // Create a new image element
                img.attr("src", reader.result);
                img.attr("class","img  img-enlargable width200")
                container.append(img); // Append the image to the container
            };
            reader.readAsDataURL(file); // Read the file as Data URL
        });
    }
}


// this script should be removed when applying arabic lang
$('.bas-arabic').find('*').removeAttr('required');

$(function () {
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editableform.buttons =
        '<button  class="btn btn-success btn-sm editable-submit">' +
        '<i class="la la-fw la-check"></i>' +
        '</button>' +
        '<button type="button" class="btn btn-warning btn-sm editable-cancel">' +
        '<i class="la la-fw la-times"></i>' +
        '</button>';
})

// Handle Reset Password button click
$(document).on('click', '.resetPassword', function(e) {
    e.preventDefault();
    var userId = $(this).data('id');
    // Set the user_id in the hidden input field
    $('#exampleModalCenter input[name="user_id"]').val(userId);
    // Show the modal
    $('#exampleModalCenter').modal('show');
});
