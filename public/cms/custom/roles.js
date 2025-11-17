document.getElementById('selectAllPermissions').onclick = function() {
    let checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
};

$('#search-permissions').on('keyup', function () {
    var keyword = $(this).val().toLowerCase();
    $('#permissions-container .form-check').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1)
    });
});


