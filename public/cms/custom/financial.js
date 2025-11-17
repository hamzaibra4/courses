function resetFilters(formId){
    $("#"+formId+"_from_date").val('');
    $("#"+formId+"_to_date").val('');
    document.getElementById(formId).reset();
    $('#'+formId+' select').each(function () {
        $('#'+formId).find('.select2').val("na").trigger('change');
    });
}

$('#currency_id').on('change', getDetails);
function getDetails(){
    let selectedOption = $('#currency_id').find('option:selected');
    const cyCode = selectedOption.attr('data-code');
    var patientId= $("#fromPatientDashboard").val();
    var cyId=selectedOption.val()
    $.ajax({
        url: $("#getFinancial").val(),
        type: 'get',
        data: {
            patientId: patientId,
            currencyId: cyId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if(response.code==="200"){
                console.log(response);
                $("#total_invoices").text(cyCode + ' ' +  response.subtotalInvoices);
                $("#total_discount").text(cyCode + ' ' + response.totalInvoicesDiscount);
                $("#total_invoices_sum").text(cyCode + ' ' + response.totalInvoices);
                $("#last_payment_sum").text(cyCode + ' ' + response.lastPayment);
                $("#last_payment_date").text(response.lastPaymentDate);
                $("#total_payments").text(cyCode + ' ' + response.totalPayments);
                $("#on_balance").text(cyCode + ' ' + response.totalInvoices);
                $("#done_balance").text(cyCode + ' ' + response.totalPayments);
                $("#total_left").text(cyCode + ' ' + response.balanceDue);
            }
        },
        error: function (xhr) {
            swal('Error','An Error has occurred please contact BA Solutions', "error");
        }
    });
}
getDetails();
function globalFilter(e,formName) {
    e.preventDefault();
    var flag=true;
    var fromdate = $("#"+formName+"_from_date").val();
    var todate = $("#"+formName+"_to_date").val();
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
        var form = $("#"+formName);
        $.ajax({
            type: 'get',
            data: form.serialize(),
            contentType: "charset=utf-8",
            success: function (data) {
                $("#"+formName+"_data").replaceWith(data.viewdata);
                $('.select2').select2();
                $("."+formName).dataTable().fnDestroy();
                $("."+formName).DataTable({
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
