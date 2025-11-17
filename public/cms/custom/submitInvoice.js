function submitData(){
    var flag=true;
    var total= Number($('#balanceDue').attr("data-total"));
    if(total < 0){
        swal("Error", "Total should not be negative", "warning");
        flag=false;
        return;
    }

    var patientId = $("#patient").val();
    if(patientId==="na"){
        swal("Warning", "Please select a patient first.", "warning");
        flag=false;
        return;
    }
    var dueDate = $("#due_date").val();
    var invoice_date = $("#invoice_date").val();
    if(dueDate===''){
        swal("Warning", "Please fill due date", "warning");
        flag=false;
        return;
    }
    if(invoice_date===''){
        swal("Warning", "Please fill invoice date", "warning");
        flag=false;
        return;
    }

    const rows = $('.quotation-row');
    const data = [];
    let allValid = true;

    rows.each(function () {
        const $row = $(this);
        const desc = $row.find('.desc').val()?.trim();
        const qty = parseFloat($row.find('.qty').val());
        const price = parseFloat($row.find('.price').val());
        const nameId = $row.find('.price').attr('data-id')
        if (!desc || isNaN(qty) || qty <= 0 || isNaN(price) || price < 0) {
            allValid = false;
            return false;
        }
        data.push({
            desc: desc,
            quantity: qty,
            price: price,
            nameId: nameId
        });
    });

    if (!allValid) {
        swal("Missing Data", "Please fill all fields correctly in every row.", "warning");
        flag=false;
    }
    var discountValue = $("#discountValue").val();
    if(discountValue===""){
        discountValue=0;
    }

    var paymentValue = $("#downPayment").val();
    if(paymentValue===""){
        paymentValue=0;
    }

    if(data.length ==0){
        swal("Missing Data", "Please fill at least one row.", "warning");
        flag=false;
    }

    if(flag){
        $.ajax({
            url: $("#submitInvoice").val(),
            type: 'POST',
            data: {
                details: data,
                patientId: patientId,
                dueDate: dueDate,
                invoice_date: invoice_date,
                discountType: $("#discountType").val(),
                invoiceId: $("#invoiceId").val(),
                paymentValue: paymentValue,
                drId: $("#dr").val(),
                discountValue: discountValue,
                currencyId: $("#currency").val(),
                fromPatientDashboard: $("#fromPatientDashboard").val(),
                notes: $("#notes").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if(response.code==="200"){
                    swal('Success',response.message, "success");
                    setTimeout(function() {
                        window.location.href = response.route;
                    }, 2000);


                }
            },
            error: function (xhr) {
                swal('Error','An Error has occurred please contact BA Solutions', "error");
            }
        });
    }


}

function calculateTotal() {
    const exchangeRate = parseFloat($('#exchangeRate').val()) || 1;
    const currencyCode = $('#currency option:selected').data('code') || '';
    let subtotal = 0;
    $('#quotationTable tbody tr').each(function () {
        const qty = parseFloat($(this).find('.qty').val()) || 0;
        const priceInput = $(this).find('.price');
        const price = parseFloat(priceInput.val()) || 0;
        const lineTotal = price * qty;
        $(this).find('.line-total').text(`${currencyCode} ${lineTotal.toFixed(2)}`);
        subtotal += lineTotal;
    });

    const discountVal = parseFloat($('#discountValue').val()) || 0;
    const discountType = $('#discountType').val();
    let finalTotal = subtotal;
    if (discountType === 'percentage') {
        finalTotal -= subtotal * (discountVal / 100);
    } else {
        finalTotal -= discountVal;
    }

    $('#total').text(`${subtotal.toFixed(2)} ${currencyCode}`);
    $('#quotationTotal').text(`${finalTotal.toFixed(2)} ${currencyCode}`);
    const quickPayment = parseFloat($('#downPayment').val()) || 0;
    finalTotal -= quickPayment;
    $('#balanceDue').text(`${finalTotal.toFixed(2)} ${currencyCode}`);
    $('#balanceDue').attr("data-total",`${finalTotal.toFixed(2)}`);

}

$('#downPayment').on('input', calculateTotal);
