var existingRegionIds = [];

function addRegionToTable(regionId, regionName) {
    // Prevent duplicate in current selection
    if ($('#regionTable tbody').find(`tr[data-id="${regionId}"]`).length > 0) {
        swal({
            title: 'Warning',
            text: 'This region is already added.',
            icon: 'warning',
        });
        return;
    }

    // Just in case you reuse this for edit in future
    if (existingRegionIds.includes(parseInt(regionId))) {
        swal({
            title: 'Warning',
            text: 'This region is already assigned to this branch.',
            icon: 'warning',
        });
        return;
    }

    $('#regionTable').removeClass("d-none");
    $('#saveRegionBtnContainer').removeClass("d-none");

    $('#regionTable tbody').append(`
        <tr data-id="${regionId}">
            <td>
                ${regionName}
                <input type="hidden" name="regions[]" value="${regionId}">
            </td>
            <td>
                <a type="button" class="removeRegion"><i class="la la-close"></i> </a>
            </td>
        </tr>
    `);
}
$('#addRegion').on('click', function () {
    const selectedOption = $('#regionSelector option:selected');
    const regionId = selectedOption.val();
    const regionName = selectedOption.text();

    if (regionId === 'na') {
        swal({
            title: 'Error',
            text: 'Please select a valid region.',
            icon: 'error',
        });
        return;
    }

    addRegionToTable(regionId, regionName);
});
// Remove region row
$(document).on('click', '.removeRegion', function () {
    $(this).closest('tr').remove();
});
// Handle form submission via AJAX
$('#regionForm').on('submit', function (e) {
    e.preventDefault();
    const form = $(this);
    const actionUrl = form.attr('action');

    $.ajax({
        url: actionUrl,
        method: 'POST',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.status === 'success') {
                swal({
                    title: 'Success',
                    text: response.message,
                    icon: "success",
                }).then(() => {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                });
            }
        }
        ,
        error: function (xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors && errors.regions) {
                alert(errors.regions.join("\n"));
            } else {
                swal({
                    title: 'Error',
                    text: 'An error occurred while saving the branch regions. Please try again.',
                    icon: 'error',
                });
            }
        }
    });
});
