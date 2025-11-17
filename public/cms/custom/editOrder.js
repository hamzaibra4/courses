$(function () {
    $('.dbthequantity').editable({
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
})

function editToOrder(){
    var flag2=true;
    var item2 = $(".itemref ").val();
    $( ".dataitemrow" ).each(function( index ) {
        var c = $( this ).attr("data-id");
        var ir= $.trim($("#dbitemref"+c).text());
        if(ir===item2){
            flag2 = false;
            message = 'Item already choosen, please change quantity';
            swal( "Warning", message, "warning");
        }
    });
    if(flag2){
        addToOrder();
    }
}

function checktotal(){
    var total = 0;

    $(".dbordering").each(function () {
        var id = $(this).attr("data-id");
        var quanity  = $("#dbitemqty" + id).text().replace(/\s/g,'');
        var price = $("#dbitemprice" + id).text().replace(/\s/g,'');
        total= total+ (Number(quanity) * Number(price));
    });


    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var quanity = $("#itemqty" + id).text().replace(/\s/g,'');
        var price = $("#itemprice" + id).text().replace(/\s/g,'');
        total= total+ (Number(quanity) * Number(price));
    });
    $("#thetotal").removeClass("display-none");
    $("#thetotal").html("The Total Amount is: <a href='#'>" + total + "$</a>");


}

function checktotalLBP() {
    var total = 0;

    $(".dbordering").each(function () {
        var id = $(this).attr("data-id");
        var quanity  = $("#dbitemqty" + id).text().replace(/\s/g,'');
        var price = $("#dbitemprice" + id).text().replace(/\s/g,'');
        total= total+ (Number(quanity) * Number(price));
    });


    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var quanity = $("#itemqty" + id).text().replace(/\s/g,'');
        var price = $("#itemprice" + id).text().replace(/\s/g,'');
        total= total+ (Number(quanity) * Number(price));
    });

    var vatrate = Number($("#vat").val()) ?? 1.11;

    var totalperc = total * vatrate;
    var final = totalperc-total;
    var lbprate= $("#lbRate").val();
    final = Number(final) * lbprate;
    final = Number(final).toFixed(2);
    final = numberWithCommas(final);
    $("#thetotal2").removeClass("display-none");
    $("#thetotal2").html("The Total Amount is: <a href='#'>" + final + " LBP</a>");

}


function deleteitem(id) {

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
            $.ajax({
                url: $("#deleteItem").val(),
                type: 'post',
                data:{id, id},
                success: function(res){
                    $("#dbrowdataof" + id).remove();
                    swal("Deleted!", "Your order has been deleted!", "success");
                },
            });
        } else {
            swal( 'Cancelled', 'Your row is safe', "error");
        }
    });


}


function submitOrder() {
    var message;
    var items = [];
    var saveditems = [];
    var flag = true;
    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var obj = {};
        obj['itemref'] =$.trim($("#itemref" + id).text());
        obj['itemname'] = $.trim($("#itemdesc" + id).text());
        obj['itemq'] = $.trim($("#itemqty" + id).text());
        obj['state'] = "200";
        items.push(obj);
    });

    $(".dbordering").each(function () {
        var id = $(this).attr("data-id");
        var obj = {};
        obj['itemref'] =$.trim($("#dbitemref" + id).text());
        obj['itemname'] = $.trim($("#dbitemdesc" + id).text());
        obj['itemq'] = $.trim($("#dbitemqty" + id).text());
        obj['state'] = "200";
        saveditems.push(obj);
    });

    if (items.length <= 0 && saveditems.length <= 0 ) {
        message = 'Please fill items';
        swal( "Error", message, "error");
        flag = false;
    }

    if(flag){
        var branchval = $(".thebranch ").val();
        var formData = new FormData();
        formData.append('orderid', $("#orderId").val());
        formData.append('items', JSON.stringify(items));
        formData.append('dbitems', JSON.stringify(saveditems));
        var radioValue = $("input[name='deliveryby']:checked").val();
        formData.append('deliveryby', radioValue);
        formData.append('osbranchid', branchval);
        formData.append('deliverynote', $("#deliverynote").val());
        formData.append('ordernote', $("#ordernote").val());
        $.ajax({
            url: $("#postOrder").val(),
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                swal("Success", "Successfully saved!", "success");

            },
        });

    }
}
