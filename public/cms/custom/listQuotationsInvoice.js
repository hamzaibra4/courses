$(document).on('change', '.change_quotation_status', function () {
    let statusId = $(this).val();
    let id = $(this).attr("data-id");
    performUpdate(id,statusId);
});

$(document).on('change', '.change_quotation_status2', function () {
    let statusId = $(this).val();
    let id = $(this).attr("data-id");
    performUpdate(id,statusId,false);
});

function performUpdate(id,status,flag=true){
    var url;
    if(flag){
        url = $("#changeStatus").val()
    }else{
        url = $("#changeQuotationStatus").val()
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            id: id,
            status_id: status,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if(response.code==="200"){
                swal('Success',response.message, "success");
            }else{
                swal('Error',response.message, "error");
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            swal('Error','An Error has occurred please contact BA Solutions', "error");
        }
    });
}


function filterData(e) {
    e.preventDefault();
    var flag=true;
    var fromdate = $("#from_date").val();
    var todate = $("#to_date").val();

    if(  (fromdate!=='' && todate==='') || (fromdate==='' && todate!=='')  ){
        flag = false;
        var message = 'Please provide both From and To date.';
        swal('Warning',message, "info");
    }
    if(fromdate!=='' && todate!==''){
        var x = new Date(fromdate);
        var y = new Date(todate);
        if (x > y) {
            flag = false;
            var message = 'From date should be less than to date';
            swal('Error',message, "error");
        }
    }
    if (flag){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var form = $("#filterform");
        $.ajax({
            type: 'get',
            data: form.serialize(),
            contentType: "charset=utf-8",
            success: function (data) {
                $("#data").replaceWith(data.viewdata);
                $('.select2').select2();
                $("#input-datatable").dataTable().fnDestroy();
                $('#input-datatable').DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    language: {
                        searchPlaceholder: "Search..."
                    }
                });
            },
            error: function (data) {
                swal('Error','An Error has occurred please contact BA Solutions', "error");
            }
        });
    }else{
        swal('Error',message, "error");
    }
}

$(document).on('click', '.resetFilterBtn', function () {
    $("#from_date").val('');
    $("#to_date").val('');
    document.getElementById("filterform").reset();
    $('#filterform select').each(function () {
        $('#filterform').find('.select2').val("na").trigger('change');
    });

});
