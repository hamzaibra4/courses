
function selectedStatus(){
    var url =  $("#statusId").attr("data-url");
    var order =  $("#statusId").attr("data-id");
    var value =$("#modal_status_id").val();
    var selectedText = $('#modal_status_id option:selected').text();
    $.ajax({
        type: 'POST',
        url: url,
        data: {order_id: order, status:value },
        dataType: 'json',

        success: function (data) {
            if (data.code === 200) {
                swal({
                    title: 'Success',
                    text: data.msg,
                    icon: "success",
                    showCancelButton: true,
                })
                $("#StatusOf"+order).text(selectedText);
                $(".file-export2").dataTable().fnDestroy()
                $('.file-export2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
            }else{
                swal({
                    title: 'Error',
                    text: data.msg,
                    icon: "error",
                    showCancelButton: true,
                })
            }
            $('#status').modal('hide');
        },
        error: function (response) {
            swal("Error", "An Error has occured please contact BA Solutions", "error");
        }
    });

}
$(document).on("click", ".openmodal2", function(event){
    event.preventDefault();
    let orderId = $(this).attr('data-id');
    $("#statusId").attr("data-id",orderId);
});



function selectedBranch(){
    var url =  $("#branchId").attr("data-url");
    var order =  $("#branchId").attr("data-id");
    var value =$("#modal_branch_id").val();
    var selectedText = $('#modal_branch_id option:selected').text();
    $.ajax({
        type: 'POST',
        url: url,
        data: {order_id: order, branch:value },
        dataType: 'json',

        success: function (data) {
            if (data.code === 200) {
                swal({
                    title: 'Success',
                    text: data.msg,
                    icon: "success",
                    showCancelButton: true,
                })
                $("#BranchOf"+order).text(selectedText);
                $(".file-export2").dataTable().fnDestroy()
                $('.file-export2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
            }else{
                swal({
                    title: 'Error',
                    text: data.msg,
                    icon: "error",
                    showCancelButton: true,
                })
            }
            $('#branch').modal('hide');
        },
        error: function (response) {
            swal("Error", "An Error has occured please contact BA Solutions", "error");
        }
    });

}
$(document).on("click", ".openmodal3", function(event){
    event.preventDefault();
    let orderId = $(this).attr('data-id');
    $("#branchId").attr("data-id",orderId);
});









