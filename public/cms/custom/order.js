$('.itemdata').on('select2:select', function (e) {
    var ref = $(this).val();
    $(".itemref").val(ref).change();
    $(".itemdesc").val(ref).change();
    getItemInfo(ref);
});
function getItemInfo(refno) {
    var client = $(".referno ").val();
    var flag = true;
    var message = '';
    if (client === 'na') {
        message = 'Please choose Client';
        swal( "Error", message, "error");
        flag = false;
    }

    if (flag) {
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
        $.ajax({
            url: $("#getItemInfo").val(),
            type: 'post',
            data: {ref: refno, cust: client},
            success: function (res) {
                $("#data").replaceWith(res);
                block_ele.unblock();
            },
            error: function (request, status, error) {
                swal("Error", "An error has occured please contact your administrator", "error");
                console.log("The request failed: " + request.responseText);
            }
        });
    }


}


var counter = 0;
function addToOrder() {
    $("#thetotal").addClass("display-none");
    var quantity = $("#quantity").val();
    var item = $(".itemref ").val();
    var client = $(".referno ").val();
    var itemdesc = $(".itemdesc ").select2('data')[0].text;
    var price = $("#price").text();

    var message = '';
    var flag = true;
    if (quantity === '') {
        message = 'Please choose quantity';
        swal( "Error", message, "error");
        flag = false;
    }
    if (item === '') {
        message = 'Please choose Item';
        swal( "Error", message, "error");
        flag = false;
    }

    if (client === '') {
        message = 'Please choose Client';
        swal( "Error", message, "error");
        flag = false;
    }

    if(item==="na"){
        message = 'Please choose Item';
        swal( "Error", message, "error");
        flag = false;
    }

    $(".dataitemrow").each(function (index) {
        var c = $(this).attr("data-id");
        var ir = $.trim($("#itemref" + c).text());
        if (ir === item) {
            flag = false;
            message = 'Item already choosen, please change quantity';
            swal( "Warning", message, "warning");
        }

    });

    if (flag) {
        $("#appenditemhere").append("<tr class='ordering dataitemrow' data-id='" + counter + "' id='rowdataof" + counter + "'><td id='itemref" + counter + "'>" + item + "</td><td id=itemdesc" + counter + ">" + itemdesc + "</td> <td id='itemprice" + counter + "'>" + price + "</td><td><a href='#' class='thequantity' data-title='Enter quantity' id='itemqty" + counter + "'>" + quantity + "</a></td> <td><a href='javascript:removeitem(" + counter + ")'><i class='la la-close'></i><a/></td></tr>")
        $("#orderinfo").addClass("show");
        counter++;
        $("#quantity").val(null);
        $(".itemref ").val("na").change();
        $(".itemdesc").val("na").change();
        $('.thequantity').editable({
            type: 'text',
            name: 'username',
            title: 'Enter username',
            validate: function (value) {
                if ($.trim(value) === '') return 'This field is required';
                if ($.isNumeric(value) == '') {
                    return 'Only numbers are allowed';
                }
            }
        });
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

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}



