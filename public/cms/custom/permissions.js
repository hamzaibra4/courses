$(document).ready(function() {
    // Select All / Deselect All
    $('#selectAllPermissions').click(function() {
        var checked = $(this).is(':checked');
        $('.permission-checkbox').prop('checked', checked);
    });

    $('select[name="user_id"]').on('change', function() {
        let userId = $(this).val();
        $('.permission-checkbox').prop('checked', false);
        $('#selectAllPermissions').prop('checked', false);

        if (userId) {
            fetch(`/users/${userId}/permissions`)
                .then(response => response.json())
                .then(assignedPermissions => {
                    let total = 0;
                    let checked = 0;

                    $('.permission-checkbox').each(function() {
                        total++;
                        let perm = $(this).val();
                        if (assignedPermissions.includes(perm)) {
                            $(this).prop('checked', true);
                            checked++;
                        }
                    });

                    if (total > 0 && total === checked) {
                        $('#selectAllPermissions').prop('checked', true);
                    }
                });
        }
    });

});

$('#search-permissions').on('keyup', function () {
    const keyword = $(this).val().toLowerCase();
    $('#permissions-container .form-check').each(function () {
        const text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(keyword));
    });
});

