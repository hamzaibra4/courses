$(document).on("click", ".opentruckmodal", function(event){
    event.preventDefault();
    let truckId = $(this).attr('data-id');
    $("#truck_status").attr("data-id",truckId);
});
function selectedTruckStatus(){
    var url =  $("#truck_status").attr("data-url");
    var truck =  $("#truck_status").attr("data-id");
    var value =$("#truck_status_id").val();
    var selectedText = $('#truck_status_id option:selected').text();
    $.ajax({
        type: 'POST',
        url: url,
        data: {truck_id: truck, status:value },
        dataType: 'json',

        success: function (data) {
            if (data.code === 200) {
                swal({
                    title: 'Success',
                    text: data.msg,
                    icon: "success",
                    showCancelButton: true,
                })
                $("#StatusOf"+truck).text(selectedText);
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


$(document).on("click", ".opencapacitymodal", function(event){
    event.preventDefault();
    let truckId = $(this).attr('data-id');
    $("#truck_capacity").attr("data-id",truckId);
});

function selectedTruckCapacity(){
    var url =  $("#truck_capacity").attr("data-url");
    var truck =  $("#truck_capacity").attr("data-id");
    var value =$("#capacity").val();
    var selectedText = $('#capacity').val();

    $.ajax({
        type: 'POST',
        url: url,
        data: {truck_id: truck, capacity:value },
        dataType: 'json',

        success: function (data) {
            if (data.code === 200) {
                swal({
                    title: 'Success',
                    text: data.msg,
                    icon: "success",
                    showCancelButton: true,
                })
                $("#CapacityOf"+truck).text(selectedText);
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
