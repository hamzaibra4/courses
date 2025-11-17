// This script is common
var counter = 1;
function addToLine(customerId = null, customerText = null, prefill = false) {
    var customer = customerText ?? $("#customerInfo").select2('data')[0].text;
    var customerId = customerId ?? $("#customerInfo").val();
    var priority = 'info';
    var title = 'Warning';
    var message = '';
    var flag = true;
    if (customerId==="na") {
        message = 'Please choose a customer';
        swal( title, message, priority);
        flag = false;
    }
    $(".dataitemrow").each(function () {
        var c = $(this).attr("data-id");
        var ir = $.trim($("#customerRef" + c).text());
        if (ir === customer) {
            flag = false;
            message = 'Customer already chosen';
            swal( title, message, priority);
        }
    });

    if (flag) {
        $("#appenditemhere").append(`
            <tr class='ordering dataitemrow' data-id='${counter}' id='rowdataof${counter}'>
                <td data-ref='${customerId}' id='customerRef${counter}'>${customer}</td>
                <td><a href='#' class='thequantity' data-title='Enter quantity' id='itemqty${counter}'>${counter}</a></td>
                <td><a href='javascript:removeitem(${counter})'><i class='la la-close'></i></a></td>
            </tr>
        `);

        $("#orderinfo").addClass("show");
        $("#itemqty" + counter).editable({
            type: 'text',
            name: 'quantity',
            title: 'Enter quantity',
            mode: 'inline',
            validate: function (value) {
                if ($.trim(value) === '') return 'This field is required';
                if (!$.isNumeric(value)) return 'Only numbers are allowed';
            }
        });
        counter++;
    }
}
function removeitem(id) {
    swal({
        title: 'Are you sure ?',
        text: 'You will not be able to recover this row',
        icon: "error",
        showCancelButton: true,
        buttons: {
            cancel: {
                text:  'No, cancel please!',
                value: null,
                visible: true,
                className: "",
                closeModal: false,
            },
            confirm: {
                text: 'Yes, delete it!',
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {
            $("#rowdataof" + id).remove();
            swal('Deleted', "The row is deleted successfully", "success");
        } else {
            swal( 'Cancelled', 'Your row is safe', "error");
        }
    });

}
function submitOrder() {
    $("#mybtn").attr("disabled",true);
    var block_ele = $(".itemcard");
    block_ele.block({
        message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
        overlayCSS: {
            backgroundColor: '#FFF',
            cursor: 'wait',
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none'
        }
    });
    var name = $("#name ").val();
    var description = $("#description ").val();
    var modelId = $("#modelId").val();
    var priority = 'error';
    var title = 'Error';
    var message;
    var items = [];
    var flag = true;
    if (name === '') {
        message = 'Please input a name';
        swal( title, message, priority);
        flag = false;
    }
    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var obj = {};
        obj['customerref'] =$.trim($("#customerRef" + id).attr("data-ref"));
        obj['item'] = $.trim($("#itemqty" + id).text());
        obj['state'] = "200";
        items.push(obj);
    });
    if (items.length <= 0) {
        message = 'Please add Customers';
        swal( title, message, priority);
        flag = false;
    }
    if (flag) {
        var formData = new FormData();
        formData.append('name', name);
        formData.append('description', description);
        formData.append('items', JSON.stringify(items));
        formData.append('modelId', modelId);
        $.ajax({
            url: $("#actionId").val(),
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                swal("Success", "Successfully saved!", "success");
                setTimeout(function () {
                    window.location.href = $("#goTo").val();
                }, 1000);
            },
            error: function (request, status, error) {
                swal("Error", "An error has occured please contact your administrator", "error");
            }
        });

    }else{
        $("#mybtn").attr("disabled",false);
    }
    block_ele.unblock();
}
