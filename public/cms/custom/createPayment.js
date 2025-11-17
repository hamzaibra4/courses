
function renderThePatient(){
    var patientId =  $("#patient").val();
    var selectedCurrency = $('#currency_id').val();
    if(patientId !=="na"){
        $.ajax({
            type:'post',
            url: $("#patientInvoices").val(),
            data:{patient_id: patientId, currency_id:selectedCurrency, paymentId: $("#paymentId").val()},
            success:function(data){
                if(data.code==="200"){
                    $("#data").replaceWith(data.viewData);
                    if(data.missingCy == true){
                        swal('Warning',data.missingMsg, "warning");
                    }
                    // Save only the relevant parts globally
                    window.currencyTotals = {
                        base: data.totalByBaseCurrency,
                        invoice: data.totalsByCurrency,
                        transaction: data.totalsByTrxCurrency
                    };

                    renderCurrencyTable('base', window.currencyTotals);
                }
            },
            error: function(response) {
                swal('Error','An Error has occurred please contact BA Solutions', "error");
            }
        });
    }else{
        $("#data").empty();
        $("#invoiceDetails").addClass("display-none");
    }
}

$('#currency_id').on('change', function () {
    $("#payment_amount").val(0);
    $("#currencyView").val("base");
    clearCurrencyTable();
    renderThePatient();
});

$('#patient').on('change', function() {
    clearCurrencyTable();
    $("#invoiceDetails").removeClass("display-none");
    renderThePatient();
});

$('#payment_distribution').on('change', function () {
    applySmartDistribution();
});

$('#payment_amount').on('input', function () {
    applySmartDistribution();
    const payment = parseFloat($(this).val()) || 0;
    if (currentView === 'invoice') {
        updateInvoiceAfter();
    } else {
        renderCurrencyTable(currentView, window.currencyTotals);
    }
});
function applySmartDistribution() {
    if ($('#payment_distribution').is(':checked')){
    $('.payment').val('');
    let selectedCurrency = $('#currency_id').val();
    let selectedOption = $('#currency_id').find('option:selected');
    let isDefault = selectedOption.data('default') === true || selectedOption.data('default') === "true";
    let totalAmount = parseFloat($('#payment_amount').val());
    if (isNaN(totalAmount) || totalAmount <= 0) return;
    $('.payment').each(function () {
        if (totalAmount <= 0) return;
        let $input = $(this);
        let currencyId = $input.data('cy');
        let remaining = parseFloat($input.data('remaining')) || 0;
        if (currencyId == selectedCurrency && remaining > 0) {
            let assign = Math.min(remaining, totalAmount);
            $input.attr("data-cv",assign);
            $input.val(assign.toFixed(2));
            totalAmount -= assign;
        }
    });

    $('.payment').each(function () {
        if (totalAmount <= 0) return;
        let $input = $(this);
        let currencyId = $input.data('cy');
        let remaining = parseFloat($input.data('remaining')) || 0;
        let rate = parseFloat($input.data('rate')) || 1;
        let action = $input.data('action');
        if (currencyId != selectedCurrency && remaining > 0 && action) {
            let assign = 0;
            var cvAmount = 0;
            if (action === 'multiply') {
                assign = Math.min(remaining, totalAmount * rate);
                cvAmount= assign / rate;
                totalAmount -= assign / rate;
            } else if (action === 'divide') {
                assign = Math.min(remaining, totalAmount / rate);
                totalAmount -= assign * rate;
                cvAmount= assign * rate;
            }
            $input.val(assign.toFixed(2));
            $input.attr("data-cv",cvAmount);
        }
    });
    }
}
let currentView = 'base';
let invoiceData = [];

function getTransactionCurrencyId() {
    return $('#currency_id').val();
}

function renderCurrencyTable(view, totals) {
    const tbody = $('#currencyTable tbody');
    tbody.empty();
    currentView = view;

    if (view === 'base' || view === 'transaction') {
        $('#currencyTable thead tr').html(`
            <th>Currency</th><th>Before</th><th>After</th>
        `);

        const label = view === 'base' ? 'Base Currency' : 'Transaction Currency';
        const total = parseFloat(totals[view].total);
        const rate = parseFloat(totals[view].rate);
        const action = totals[view].action;
        const payment = parseFloat($('#payment_amount').val()) || 0;

        const after = calculateAfterValue(total, rate, action, payment);
        var defaultOption = "";
        if(view === 'base'){
            defaultOption = $('#currency_id option[data-default="true"]');
        }else{
            defaultOption = $('#currency_id option:selected');
        }
        const baseCurrency = defaultOption.attr("data-code");
        tbody.append(`
            <tr>
                <td>${baseCurrency}</td>
                <td>${total.toFixed(2)}</td>
                <td class="text-primary">${after.toFixed(2)}</td>
            </tr>
        `);
    }

    if (view === 'invoice') {
        $('#currencyTable thead tr').html(`
            <th>Currency</th><th>Before</th><th>After</th>
        `);

        invoiceData = totals.invoice.map(row => ({
            ...row,
            remaining: row.total
        }));

        // 🔁 Prioritize invoices matching selected transaction currency
        const trxCurrencyId = getTransactionCurrencyId();
        invoiceData.sort((a, b) => {
            if (a.currency_id === trxCurrencyId && b.currency_id !== trxCurrencyId) return -1;
            if (a.currency_id !== trxCurrencyId && b.currency_id === trxCurrencyId) return 1;
            return 0;
        });

        invoiceData.forEach(row => {
            $('#currencyTable tbody').append(`
                <tr>
                    <td>${row.currency_name}</td>
                    <td>${row.currency_code} ${row.total.toFixed(2)}</td>
                    <td class="after" data-currency="${row.currency_code}">${row.currency_code} ${row.total.toFixed(2)}</td>
                </tr>
            `);
        });

        updateInvoiceAfter(); // Initial call
    }
}

function calculateAfterValue(total, rate, action, payment) {
    let deduction = 0;
    if (action === 'multiply') {
        deduction = payment * rate;
    } else if (action === 'divide') {
        deduction = payment / rate;
    } else {
        deduction = payment;
    }
    return Math.max(total - deduction, 0);
}

function updateInvoiceAfter() {
    let remainingPayment = parseFloat($('#payment_amount').val()) || 0;
    invoiceData.forEach(row => {
        const rate = parseFloat(row.rate);
        const total = parseFloat(row.total);
        const action = row.action;
        let converted = 0;
        if (action === 'multiply') {
            converted = Math.min(remainingPayment * rate, total);
        } else if (action === 'divide') {
            converted = Math.min(remainingPayment / rate, total);
        } else {
            converted = Math.min(remainingPayment, total);
        }
        const after = total - converted;
        $(`td.after[data-currency="${row.currency_code}"]`).text(`${row.currency_code} ${after.toFixed(2)}`);
        // Deduct from remaining base amount
        if (action === 'multiply') {
            remainingPayment -= converted / rate;
        } else if (action === 'divide') {
            remainingPayment -= converted * rate;
        } else {
            remainingPayment -= converted;
        }
    });
}

// Events

$('#currencyView').on('change', function () {
    const selected = $(this).val();
    renderCurrencyTable(selected, window.currencyTotals);
});

function clearCurrencyTable() {
    $('#currencyTable tbody').empty();
}

function submitData(){
    var flag=true;
    var patientId = $("#patient").val();
    if(patientId==="na"){
        swal("Warning", "Please select a patient first.", "warning");
        flag=false;
    }
    var paymentDate = $("#payment_date").val();
    var currencyId = $("#currency_id").val();
    var paymentAmount = $("#payment_amount").val();

    var paymentDistribution = 'true';
    if (!$('#payment_distribution').is(':checked')){
        paymentDistribution='false';
    }

    if(paymentAmount <=0){
        swal("Warning", "Please enter a valid amount", "warning");
        flag=false;
    }


    if(paymentDate===''){
        swal("Warning", "Please fill due date", "warning");
        flag=false;
    }

    var enterTotal = 0;
    if (!$('#payment_distribution').is(':checked')){

        $('.collectPayment').each(function () {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) {
                enterTotal += val;
            }
        });
    }else{
        $('.collectPayment').each(function () {
            let val = parseFloat($(this).attr("data-cv"));
            if (!isNaN(val) && $(this).val() !='') {
                enterTotal += val;
            }
        });
        enterTotal = parseFloat(enterTotal.toFixed(2));
    }



    if(enterTotal != paymentAmount){
        swal("Warning", "Payment amount is not equal to the distribution", "warning");
        flag=false;
    }




    const rows = $('.collectPayment');
    if(rows.length === 0){
        swal("Warning", "This customer has no pending invoices.", "warning");
        flag=false;
    }
    const data = [];
    let allValid = true;
    rows.each(function () {
        const $row = $(this);
        var amount = parseFloat($row.val());
        if(isNaN(amount)){
            amount=0;
        }
        const invoiceId= $row.attr("data-invoice");
        const rate= $row.attr("data-rate");
        const action= $row.attr("data-action");
        data.push({
            amount: amount,
            invoiceId: invoiceId,
            rate: rate,
            action: action
        });
    });

    if(flag){
        $.ajax({
            url: $("#submitPayment").val(),
            type: 'POST',
            data: {
                details: data,
                patientId: patientId,
                paymentDate: paymentDate,
                currencyId: currencyId,
                paymentAmount: paymentAmount,
                paymentDistribution:paymentDistribution,
                notes: $("#notes").val(),
                fromPatientDashboard: $("#fromPatientDashboard").val(),
                paymentId: $("#paymentId").val(),
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


function checktotal(){
        let total = 0;
        $('.collectPayment').each(function () {
            let val = parseFloat($(this).attr("data-cv"));
            if (!isNaN(val) && $(this).val() !='') {
                total += val;
            }
        });
        total = parseFloat(total.toFixed(2));
        $("#payment_amount").val(total);
}


$(document).on('input', '.collectPayment', function () {
    const max = parseFloat($(this).attr('max'));
    let value = parseFloat($(this).val());

    if (value > max) {
        $(this).val(max);
    }
});

$(document).on('change', '.collectPayment', function () {
    let value = parseFloat($(this).val());
    const rate = parseFloat($(this).attr('data-rate'));
    const action = $(this).attr("data-action");
    var cvAmount=0;
    if (action === 'multiply') {
        cvAmount= value / rate;
    } else if (action === 'divide') {
        cvAmount= value * rate;
    }
    cvAmount = parseFloat(cvAmount.toFixed(2));
    $(this).attr("data-cv",cvAmount);
    checktotal();
});
