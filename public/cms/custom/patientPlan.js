function initializeAddOperationButton() {
    const OperationBtn = document.querySelector('#addOperationBtn');
    if (OperationBtn) {
        OperationBtn.addEventListener('click', function () {
            const table = $('#dynamic-inputs').DataTable();

            // Dynamically create options for sub-operation, tooth, priority, and status
            const subOperations = window.subOperations.map(op => `<option value="${op.id}" data-tooth="12" data-priority="1">${op.name} (${op.code})</option>`).join('');
            const toothOptions = window.teeth.map(t => `<option value="${t.id}">${t.number}</option>`).join('');
            const priorityOptions = window.operationPriorities.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
            const statusOptions = window.operationStatuses.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
            // Create new row
            const row = $('<tr>');

            row.append(`
                <td>
                    <select name="sub_operation_id[]" class="form-control sub-select select2" required>
                        ${subOperations}
                    </select>
                </td>
                <td>
                    <select class="form-control tooth-select select2" name="tooth[]" required>
                        ${toothOptions}
                    </select>
                </td>
                <td>
                    <select class="form-control priority-select" name="priority[]" required>
                        ${priorityOptions}
                    </select>
                </td>
                <td>
                    <input type="date" class="form-control flat-date" name="created_date[]" required placeholder="Start Date">
                </td>
                <td>
                    <textarea class="form-control auto-height" name="notes[]" placeholder="Notes" rows="1"></textarea>
                </td>
                <td>
                    <select name="operation_status_id[]" class="form-control status-select select2" required>
                        ${statusOptions}
                    </select>
                </td>
                <td class="w-10perc">
                    <button type="button" class="btn btn-danger btn-sm remove-row">x Remove</button>
                </td>
            `);

            // Add the new row to DataTable
            table.row.add(row).draw();

            // Apply select2 to dynamically added selects
            $(row).find('.sub-select, .tooth-select, .priority-select, .status-select').select2({ width: '100%' });
             $('.flat-date').flatpickr({
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    altInput: true,
                    altFormat: "Y-m-d",
                    clickOpens: true
                });

            // Auto-fill values when sub-operation changes
            row.find('select[name="sub_operation_id[]"]').on('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const toothInput = row.find('.tooth-select');
                const priorityInput = row.find('.priority-select');

                const toothVal = selectedOption.getAttribute('data-tooth');
                const priorityVal = selectedOption.getAttribute('data-priority');

                if (toothVal) $(toothInput).val(toothVal).trigger('change');
                if (priorityVal) $(priorityInput).val(priorityVal).trigger('change');
            });
        });

        $('#dynamic-inputs').on('click', '.remove-row', function () {
            const row = $(this).closest('tr');
            const table = $('#dynamic-inputs').DataTable();
            table.row(row).remove().draw();
        });
    }
}
$(document).ready(function () {
    $('#dynamic-inputs').DataTable({
        pageLength: 5,
        lengthChange: false,
        searching: true,
        ordering: true,
        language: {
            searchPlaceholder: "Search..."
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    initializeAddOperationButton();
});
function reinitializeDataTable() {

    $('#dynamic-inputs').DataTable({
        pageLength: 5,
        lengthChange: false,
        searching: true,
        ordering: true,
        language: {
            searchPlaceholder: "Search..."
        }
    });
}

$('#addPlanBtn').on('click', function () {
    const patientId = $('input[name="patient_id"]').val(); // Get patient_id from hidden field
    var newPlanName = 'New Plan';

    // Prevent adding another unsaved plan
    const hasUnsaved = $('#plansList .plan-item').filter(function () {
        return $(this).data('id') === undefined || $(this).data('id') === '';
    }).length > 0;

    if (hasUnsaved) {
        swal('Not Permitted', 'Please save the current new plan before adding another.', "warning");
        return;
    }

    // Remove 'active-plan' class and badge from all items
    $('#plansList .plan-item').removeClass('active-plan');

    const newPlanElement = $(`
        <a href="#"
           class="list-group-item list-group-item-action plan-item d-flex justify-content-between align-items-center active-plan"
           data-id="">
            <span>
                <i class="bi bi-file-earmark-medical me-2 text-primary"></i>
                ${newPlanName}
            </span>
        </a>
    `);

    var theurl = $("#new-patient-plan").val() + "/" + patientId
    $.ajax({
        url: theurl,
        method: 'GET',
        success: function (response) {
            $('.col-md-10').html(response.html);
            $('#plansList').append(newPlanElement);
            reinitializeDataTable();
            $('.select2').select2();
            initializeAddOperationButton();

        },
        error: function (xhr) {
            alert('Failed to load new treatment plan form.');
        }
    });
});


$(document).on('click', '.plan-item', function (e) {
    e.preventDefault();
    const $clickedItem = $(this);
    const planId = $clickedItem.data('id');
    $('#plansList .plan-item').removeClass('active-plan');
    const patientId = $('input[name="patient_id"]').val();
    const newPatientPlanRoute = $('input[name="newPatientPlan"]').val();
    const editPatientPlanRoute = $('input[name="editPatientPlan"]').val();


    if (!planId) {
        $.ajax({
            url: '/' + newPatientPlanRoute + '/' + patientId,
            method: 'GET',
            success: function (response) {
                $('.col-md-10').html(response.html);
                $clickedItem.addClass('active-plan');
                initializeAddOperationButton();
            },
            error: function () {
                swal('Failed to load new treatment plan form.');
            }
        });
        return; // Stop further execution
    }


    $.ajax({
        url: '/' + editPatientPlanRoute + '/' + planId,
        method: 'GET',
        success: function (response) {
            $('.col-md-10').html(response.html);
            $clickedItem.addClass('active-plan');
            reinitializeDataTable();
            initializeAddOperationButton();
            $(".select2").select2();
            $('.flat-date').flatpickr({
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    altInput: true,
                    altFormat: "Y-m-d",
                    clickOpens: true
                });

        },

        error: function (xhr) {
            swal('Failed to load the treatment plan.');
        }
    });

});



$(document).on('click', '#deletePlanBtn', function () {
    const planId = $(this).data('id');

    swal({
        title: "Are you sure?",
        text: "This will permanently delete the Patient plan.",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancel",
                visible: true,
                closeModal: true
            },
            confirm: {
                text: "Yes, delete it!",
                visible: true,
                closeModal: false // keep it open until deletion completes
            }
        },
        dangerMode: true,

    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: `/patient-plan/${planId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        // Remove from the list
                        const deletedItem = $(`#plansList .plan-item[data-id="${planId}"]`);
                        deletedItem.remove();

                        // Load next plan or empty panel
                        const nextPlan = $('#plansList .plan-item').first();
                        if (nextPlan.length) {
                            nextPlan.trigger('click');
                        } else {
                            $('.col-md-10').html('<div class="alert alert-info">No treatment plans available.</div>');
                        }

                        swal("Deleted!", response.msg, "success");
                    } else {
                        swal("Cannot Proceed!", response.msg, "warning");
                    }
                },
                error: function () {
                    swal("Error", "Failed to delete the treatment plan.", "error");
                }
            });
        }else{
            swal( 'Cancelled', 'Your row is safe', "error");
        }
    });
});
