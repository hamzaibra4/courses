$('.clientdata').on('select2:select', function (e) {
    var ref = $(this).val();
    $(".referno").val(ref).change();
    $(".custref").val(ref).change();
    $(".custtel").val(ref).change();
    $(".custtel2").val(ref).change();
    getClientInfo(ref);
});
function getClientInfo(refno) {
    $("#appenditemhere").empty();
    $(".itemref ").val('na').change();
    $(".itemdesc").val('na').change();
    $("#data tr").remove();
    var block_ele = $(".clientcard");
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
    var id = refno;
    $.ajax({
        url: $("#getClientInfo").val(),
        type: 'post',
        data: {ref: id},
        success: function (res) {
            if(res.osbranch != 'NA'){
                $(".thebranch").val(res.osbranch).change();
            }else{
                $(".thebranch").val("na").change();
            }
            $("#address").text(res.ESAddress1);
            $("#emailid").text(res.ESEmail);
            $("#regionid").text(res.region);
            if(res.region=="NA"){
                swal( "Warning", "This client is not linked to a region yet. Please contact your administrator", "warning");
            }

            if(res.lineId=="NA"){
                swal( "Warning", "This client is not linked to a truck line. Please contact your administrator", "warning");
            }

            if (res.InOut === "01" || res.InOut === "1") {
                $("#inorout").text("In (" + res.InOut + ")");
            } else if (res.InOut === "02" || res.InOut === "2") {
                $("#inorout").text("Out (" + res.InOut + ")");
            }
            var openmodal = false;
            var activeorder = res.orders;
            $("#appendexistorder").html('');
            $.each(activeorder, function (key, item) {
                openmodal = true;
                var createdate = (item.created_at).split("T")[0];
                var editUrl = $("#editOrder").val() + "/" + item.id;
                $("#appendexistorder").append(
                    "<tr>" +
                    "<td><span class='colorlogo'>" + item.order_number + "</span></td>" +
                    "<td>" + createdate + "</td>" +
                    "<td>$" + item.total + "</td>" +
                    "<td><a class='colorlogo' href='" + editUrl + "'>Edit</a></td>" +
                    "</tr>"
                );
            });

            if (openmodal) {
                $("#clientOrders").removeClass("display-none");
            }else{
                $("#clientOrders").addClass("display-none");
            }

            $("#iteminfo").addClass("show");
            var openregionmodal = false;
            var regiondataor = res.regionOrderData;
            $("#regiondatatoappend").html('');
            $.each(regiondataor, function (key, item) {
                openregionmodal = true;
                $("#regiondatatoappend").append("<tr><td>" + item.item_reference + "</td> <td>" + item.numb + "</td></tr>")
            });

            block_ele.unblock();
            if (openregionmodal) {
                $("#regionmoda").removeClass("display-none");
            }else{
                $("#regionmoda").addClass("display-none");
            }
        },
        error: function (request, status, error) {
            swal("Error", "An error has occured please contact your administrator", "error");
            console.log("The request failed: " + request.responseText);
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
    var client = $(".referno ").val();
    var branchval = $(".thebranch ").val();
    var clientdesc = $(".custref ").select2('data')[0].text;
    var message;
    var items = [];
    var flag = true;
    if (client === 'na') {
        message = 'Please choose Client';
        swal( "Error", message, "error");
        flag = false;
    }
    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var obj = {};
        obj['itemref'] =$.trim($("#itemref" + id).text());
        obj['itemname'] = $.trim($("#itemdesc" + id).text());
        obj['itemq'] = $.trim($("#itemqty" + id).text());
        obj['state'] = "200";
        items.push(obj);
    });
    if (items.length <= 0) {
        message = 'Please fill items';
        swal( "Error", message, "error");
        flag = false;
    }
    if (flag) {
        var formData = new FormData();
        formData.append('clientref', client);
        formData.append('clientname', clientdesc);
        formData.append('items', JSON.stringify(items));
        formData.append('osbranchid', branchval);
        var radioValue = $("input[name='deliveryby']:checked").val();
        formData.append('deliveryby', radioValue);
        formData.append('deliverynote', $("#deliverynote").val());
        formData.append('ordernote', $("#ordernote").val());
        $.ajax({
            url: $("#postOrder").val(),
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                block_ele.unblock();
                swal("Success", "Successfully saved!", "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function (request, status, error) {
                swal("Error", "An error has occured please contact your administrator", "error");
            }
        });

    }
    block_ele.unblock();
    $("#mybtn").attr("disabled",false);
}

function checktotal() {
    var total = 0;
    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var quanity = $("#itemqty" + id).text().replace(/\s/g, '');
        var price = $("#itemprice" + id).text().replace(/\s/g, '');
        total = total + (Number(quanity) * Number(price));
    });
    $("#thetotal").removeClass("display-none");
    $("#thetotal").html("The Total Amount is: <a href='#'>" + total + "$</a>");


}
function checktotalLBP() {
    var total = 0;
    $(".ordering").each(function () {
        var id = $(this).attr("data-id");
        var quanity = $("#itemqty" + id).text().replace(/\s/g, '');
        var price = $("#itemprice" + id).text().replace(/\s/g, '');
        total = total + (Number(quanity) * Number(price));
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
