let operationTable = $('#operations-table').DataTable({
    pageLength: 10,
    lengthChange: false,
    language: {
        searchPlaceholder: "Search..."
    }
});

$('#all-operation-select').on('change', function () {
    getSelectedTeeth();
});


operationTable.on('draw', function () {
    $('#operations-table .select2').select2(); // Reinitialize visible Select2s
});

$('.tooth-wrapper img.tooth').on('click', function () {
    const $img = $(this);
    const $checkbox = $img.closest('.tooth-wrapper').find('.teeth-checkbox');
    $img.toggleClass('selected-teeth');
    if ($checkbox.length) {
        $checkbox.prop('checked', $img.hasClass('selected-teeth'));
    }
    getSelectedTeeth();
});

$('.tooth-wrapper .teeth-checkbox').on('change', function () {
    const $checkbox = $(this);
    const $img = $checkbox.closest('.tooth-wrapper').find('img.tooth');
    if ($checkbox.is(':checked')) {
        $img.addClass('selected-teeth');
        const allChecked = $('.teeth-checkbox').length === $('.teeth-checkbox:checked').length;
        if (allChecked) {
            $('#all_teeth').prop('checked', true)
        }

    } else {
        const isAllTeeth = $('#all_teeth').is(':checked');
        if(isAllTeeth){
            $('#all_teeth').prop('checked', false)
        }
        $img.removeClass('selected-teeth');
    }
    getSelectedTeeth();


});

$('#all_teeth').on('change', function () {
    const isChecked = $(this).is(':checked');
    $('.teeth-checkbox').prop('checked', isChecked);
    $('.tooth-wrapper img.tooth').each(function () {
        $(this).toggleClass('selected-teeth', isChecked);
    });
});



$(document).on('click', '.sub-operation-item', function () {
    $(".save-op-btn").removeClass("display-none");
    const subOpText = $(this).text().trim();
    const subOpId = $(this).data('id');
    const isAllTeeth = $('#all_teeth').is(':checked');
    const $template = $('#operation-row-template').html();

    let selectedTeeth = [];

    if (!isAllTeeth) {
        $('.teeth-checkbox:checked').each(function () {
            const toothId = $(this).val();
            selectedTeeth.push(toothId);
        });
    }

    if(selectedTeeth.length === 0 && !isAllTeeth){
        swal('Warning','Please choose at least one tooth.', "info");
        return;
    }

    if (isAllTeeth) {
        $all=$("#allTeethId").val();
        selectedTeeth = [$all];
    }
    let operations = [];

    var isValid = true;

    selectedTeeth.forEach(toothId => {
        const suboperationId = subOpId;
        const $row = $($('#operation-row-template').html());
        const priorityId = $row.find('.priority-select').val();
        const dentistId = $row.find('.doctor-select').val();

        if(dentistId==null){
            swal('Error','You must add a dentist in order to continue.', "error");
            isValid=false;
            return ;
        }
        const startDate = "";
        const note = "";
        const statusId = $row.find('.status-select').val();
        if(typeof suboperationId != "undefined"){
            operations.push({
                suboperation_id: suboperationId,
                tooth_id: toothId,
                priority_id: priorityId,
                dentist_id: dentistId,
                start_date: startDate,
                note: note,
                status_id: statusId
            });
        }
    });
    console.log(operations);

    if(isValid){
        if(operations.length > 0){
            $.ajax({
                url: $("#submitOperations").val(),
                type: 'POST',
                data: {
                    operations: operations,
                    patientId: $("#patientId").val(),
                    planId : $("#all-operation-select").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.code==="200"){
                        swal('Success',"Operations have been added successfully.", "success");
                        $("#operations-table-body").replaceWith(response.viewdata);
                        $('.select2').select2();
                        $("#operations-table").dataTable().fnDestroy();
                        $('#operations-table').DataTable({
                            pageLength: 10,
                            lengthChange: false,
                            language: {
                                searchPlaceholder: "Search..."
                            }
                        });

                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    swal('Error','An Error has occurred please contact BA Solutions', "error");
                }
            });
        }
        else{
            swal('Warning','Please choose at least one operation.', "info");
        }
    }



});

$(document).on('click', '.remove-row', function () {
    var table = $('#operations-table').DataTable();
    table.row($(this).closest('tr')).remove().draw();
});


function collectOperationRows() {
    let operations = [];
    $('.appended-data').each(function () {
        const $row = $(this);
        const suboperationId = $row.attr('data-suboperation-id');
        const toothId = $row.find('.tooth-select').val();
        const priorityId = $row.find('.priority-select').val();
        const dentistId = $row.find('.doctor-select').val();
        const startDate = $row.find('.start_date').val();
        const note = $row.find('.op_note').val();
        const statusId = $row.find('.status-select').val();
        if(typeof suboperationId != "undefined"){
            operations.push({
                suboperation_id: suboperationId,
                tooth_id: toothId,
                priority_id: priorityId,
                dentist_id: dentistId,
                start_date: startDate,
                note: note,
                status_id: statusId
            });
        }

    });
    if(operations.length > 0){
        $.ajax({
            url: $("#submitOperations").val(),
            type: 'POST',
            data: {
                operations: operations,
                patientId: $("#patientId").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if(response.code==="200"){
                    swal('Success',"Operations have been saved successfully.", "success");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                swal('Error','An Error has occurred please contact BA Solutions', "error");
            }
        });
    }else{
        swal('Warning','Please choose at least one operation.', "info");
    }
}

$(document).on('change', '.global-update', function () {
    let fieldName = $(this).attr("data-field-name")
    let newVal = $(this).val();
    let poId = $(this).attr("data-po-id");
    performUpdate(fieldName,newVal,poId);
});

$(document).on('blur', '.global-input', function () {
    let fieldName = $(this).attr("data-field-name")
    let newVal = $(this).val();
    let poId = $(this).attr("data-po-id");
    performUpdate(fieldName,newVal,poId);
});


function performUpdate(fieldName,newVal,poId){
    $.ajax({
        url: $("#globalUpdate").val(),
        type: 'POST',
        data: {
            field_name: fieldName,
            new_val: newVal,
            po_id:poId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

        },
        error: function (xhr) {
            console.error(xhr.responseText);
            swal('Error','An Error has occurred please contact BA Solutions', "error");
        }
    });
}
function getSelectedTeeth(){
    const isAllTeeth = $('#all_teeth').is(':checked');
    let selectedTeeth = [];
    if (!isAllTeeth) {
        $('.teeth-checkbox:checked').each(function () {
            const toothId = $(this).val();
            selectedTeeth.push(toothId);
        });
    }
    if (isAllTeeth || selectedTeeth.length === 0) {
        $all=$("#allTeethId").val();
        selectedTeeth = [$all];
    }
    $.ajax({
        type: 'get',
        data: {
            teeth: selectedTeeth,
            patientId: $("#patientId").val(),
            planId : $("#all-operation-select").val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if(response.code==="200"){
                $("#operations-table-body").replaceWith(response.viewdata);
                $('.select2').select2();
                $("#operations-table").dataTable().fnDestroy();
                $('#operations-table').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    language: {
                        searchPlaceholder: "Search..."
                    }
                });
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            swal('Error','An Error has occurred please contact BA Solutions', "error");
        }
    });
}
