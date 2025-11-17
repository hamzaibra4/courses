
function getExistingOperationIds() {
    const ids = [];

    $('.opcode').each(function () {
        const id = $(this).data('id');
        if (id && id !== "0") {
            ids.push(id);
        }
    });

    return ids;
}
function addRow(name = "", nameId = 0, quant = 1, price = 0) {
    if (nameId !== 0) {
        const existingIds = getExistingOperationIds();
        if (existingIds.includes(nameId)) {
            swal("Warning", "This operation already exists.", "warning");
            return;
        }
    }
    const exchangeRate = parseFloat($('#exchangeRate').val()) || 1;
    const currencyCode = $('#currency option:selected').data('code') || '';
    const displayPrice = (nameId !== 0) ? price * exchangeRate : price;
    const lineTotal = displayPrice * quant;

    $('#quotationTable tbody').append(`
        <tr class="quotation-row">
          <td>
            <input name="desc" type="text" class="desc form-control opcode"
                   data-id="${nameId}" value="${name}"
                   placeholder="Description">
          </td>
          <td>
            <input name="number" type="number" class="qty form-control" value="${quant}" min="1">
          </td>
          <td>
            <input name="price" type="number"
                   class="price form-control"
                   value="${displayPrice.toFixed(2)}"
                    data-original-price="${price}"
                    data-id="${nameId}"
                   min="0">
          </td>
          <td class="line-total">${currencyCode} ${lineTotal.toFixed(2)}</td>
          <td>
            <button class="btn-remove btn btn-danger btn-sm mt-2 mb-2">
              <i class="ri-delete-bin-6-line"></i>
               Remove
            </button>
          </td>
        </tr>
    `);

    calculateTotal();
}
$(document).ready(function () {
    $('#quotationTable').on('input', '.qty', calculateTotal);
    $('#quotationTable').on('click', '.btn-remove', function () {
        $(this).closest('tr').remove();
        calculateTotal();
    });
    $('#discountValue, #discountType').on('input change', calculateTotal);
});
$(document).on('click', '.sub-operation-item', function () {
    const subOpText = $(this).text().trim();
    const subOpId = $(this).data('id');
    const subOpPrice = $(this).data('price');
    addRow(subOpText,subOpId,1,subOpPrice)
    const dropdown = document.querySelector('.dropdown-wrapper-teeth');
    document.querySelector('.dropdown-menu-teeth').style.display = 'none';

});
function relatedPlans(id) {
    $.ajax({
        type: 'GET',
        url: $("#patientPlans").val(),
        data: { patient_id: id },
        dataType: 'json',
        success: function (data) {
            if (data.code === "200") {
                $('#modaloperationTable').empty();
                var $selectOperations = $('#modal-plans');
                $selectOperations.empty();
                $.each(data.plans, function (index, plan) {
                    var name = plan.name;
                    var isSelected = false;
                    if (plan.is_active) {
                        name += " (active)";
                        isSelected = true;
                    }

                    $selectOperations.append($('<option>', {
                        value: plan.id,
                        text: name,
                        selected: isSelected
                    }));
                });

                const operations = data.operations;
                fetchOperations(operations);

            }
        },
        error: function () {
            swal("Error", "An error has occurred, please contact BA Solutions", "error");
        }
    });
}
function fetchOperations(operations){
    var hideImported = $('#hideImported').is(':checked');
    const existingIds = getExistingOperationIds();
    operations.forEach(operation => {
        const isImported = existingIds.includes(operation.id);
        if (hideImported && isImported) {
            return; // skip this row
        }
        const row = `
                                <tr>
                                    <td><input name="rowCheckbox" data-price="${operation.price}" data-id="${operation.id}" data-name="${operation.name}" type="checkbox" class="rowCheckbox"></td>
                                    <td>${operation.code}</td>
                                    <td>${operation.name}</td>
                                    <td>${operation.status}</td>
                                    <td>${operation.teeth}</td>
                                    <td>${operation.created_date}</td>
                                    <td>${operation.planed_date}</td>
                                </tr>
                            `;
        $('#modaloperationTable').append(row);
    });
}
function relatedOperations(planId,statusId) {
    $.ajax({
        type: 'GET',
        url: $("#relatedOperations").val(),
        data: { plan_id: planId, status_id : statusId  },
        dataType: 'json',
        success: function (data) {
            if (data.code === "200") {
                $('#modaloperationTable').empty();
                const operations = data.operations;
                fetchOperations(operations);
            }
        },
        error: function (response) {
            swal("Error", "An Error has occured please contact BA Solutions", "error");
        }

    });
}
$('#import-operations').on('show.bs.modal', function (e) {
    var patientId = $("#patient").val();
    if(patientId==="na"){
        swal("Warning", "Please select a patient first.", "warning");
        e.preventDefault();
    }else{
        relatedPlans(patientId);
    }

});
$('#modal-selectAll').on('change', function () {
    $('.rowCheckbox').prop('checked', this.checked);
});
$('#modalsearchBox').on('keyup', function () {
    var value = $(this).val().toLowerCase();
    $("#modaloperationTable tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
$(document).on('change', '#modal-plans', function () {
    var modalPlan = $("#modal-plans").val();
    var modalStatus = $("#modal-status").val();
    relatedOperations(modalPlan,modalStatus);

});
$(document).on('change', '#modal-status', function () {
    var modalPlan = $("#modal-plans").val();
    var modalStatus = $("#modal-status").val();
    relatedOperations(modalPlan,modalStatus);
});
$(document).on('change', '#hideImported', function () {
    var modalPlan = $("#modal-plans").val();
    var modalStatus = $("#modal-status").val();
    relatedOperations(modalPlan,modalStatus);
});
function importData(){
    $('.rowCheckbox:checked').each(function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = $(this).data('price');
        addRow(name,id,1,price)
        $('#import-operations').modal('hide');

    });
}
$(document).on('change', '#currency', function () {
    var cyId = $(this).val();
    var selectedOption = $(this).find('option:selected');
    const isDefault = selectedOption.attr('data-default');
    if(isDefault==="true"){
        $("#exchangeRate").val(1);
        updateCurrencyAndExchangeRate();
    }else{
        $.ajax({
            url: $("#getExchangeRate").val(),
            type: 'POST',
            data: {
                currency_id: cyId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const rate = Number(response.rate);
                $("#exchangeRate").val(rate);
                updateCurrencyAndExchangeRate();
                if(response.code==="500"){
                    swal('Error',response.message, "error");
                }
            },
            error: function (xhr) {
                swal('Error','An Error has occurred please contact BA Solutions', "error");
            }
        });
    }

});
function updateCurrencyAndExchangeRate() {
    const exchangeRate = parseFloat($('#exchangeRate').val()) || 1;
    const currencyCode = $('#currency option:selected').data('code') || '';
    $('#quotationTable tbody tr').each(function () {
        const qty = parseFloat($(this).find('.qty').val()) || 0;
        const priceInput = $(this).find('.price');
        const basePrice = parseFloat(priceInput.attr('data-original-price')) || 0;

        const nameId = priceInput.data('id');

        // const convertedPrice = nameId !== 0 ? basePrice * exchangeRate : basePrice;
        // const convertedLineTotal = convertedPrice * qty;
        // if (nameId !== 0) {
        //     priceInput.val(convertedPrice.toFixed(2));
        // }

        const convertedPrice = basePrice * exchangeRate ;
        const convertedLineTotal = convertedPrice * qty;
        priceInput.val(convertedPrice.toFixed(2));

        $(this).find('.line-total').text(`${currencyCode} ${convertedLineTotal.toFixed(2)}`);
    });
    calculateTotal();
}
$(document).on('change', '.price', function () {
    const priceInput = $(this);
    const currencyCode = $('#currency option:selected').data('code') || '';
    const isDefault = $('#currency option:selected').attr('data-default');
    const exchangeRate = parseFloat($('#exchangeRate').val()) || 1;
    const enteredPrice = parseFloat(priceInput.val()) || 0;
    if(isDefault==="true"){
        priceInput.attr('data-original-price', enteredPrice.toFixed(2));
    }else{
        const originalPrice = enteredPrice / exchangeRate;
        priceInput.attr('data-original-price', originalPrice.toFixed(2));
        const convertedPrice = originalPrice * exchangeRate;
        priceInput.val(convertedPrice.toFixed(2));
    }
    calculateTotal();

});
