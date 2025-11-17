function filterData(e){
    e.preventDefault();
    var flag=true;
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    if( (fromdate !=='' && todate==='') || (fromdate ==='' && todate!=='') ) {
        var message = 'Please fill from and to date';

    }else if(fromdate !=='' && todate!==''){
        var x = new Date(fromdate);
        var y = new Date(todate);
        if (x > y) {
            flag = false;
            var message = 'From date cannot be greater than to date';

        }
    }
    if (flag){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var form = $("#filterform");
        $.ajax({
            type: 'get',
            data: form.serialize(),
            contentType: "charset=utf-8",
            success: function (data) {
                $("#data").replaceWith(data.viewdata);
                $(".file-export2").dataTable().fnDestroy() //name of the Table
                $('.file-export2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
            },
            error: function (data) {
                console.log("data");
            }
        });
    }else{
        swal('Error',message, "error");
    }
}

function clearFilters() {
    document.getElementById('filterform').reset();
    $('#filterform .select2').val('na').trigger('change');
    $('#fromdate, #todate').val('');
}
