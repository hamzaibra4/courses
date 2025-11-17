
$('form').submit(function(e) {
    if (!$(this).hasClass('keepSubmit')) {
        $(this).find(':input[type=submit]').prop('disabled', true);
    }
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on("click", ".deleteRow", function(event){
    var url =  $(this).attr("data-url");
    var rowid =  $(this).attr("data-id");
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
            DeleteAjaxCall(url,rowid);
        } else {
            swal( 'Cancelled', 'Your row is safe', "error");
        }
    });
});

function DeleteAjaxCall(targetUrl, id){
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
        type:'DELETE',
        url:targetUrl,
        data:{},
        success:function(data){
            var msg=data.msg;
            if (typeof msg === 'undefined') {
                msg="GO TO CONTROLLER AND ADD MSG TO YOUR RESPONSE";
            }
            if(data.code==200){
                var table = $('.file-export').DataTable();
                var removingRow= $("#row"+id);
                table.row(removingRow).remove().draw();
                swal('Deleted', msg, "success");
                try {
                    removingRow.remove();
                }
                catch(err) {
                }
            }else if(data.code==500){
                swal('Error', msg, "error");
            }
        },
        error: function(response) {
            swal('Error','An Error has occurred please contact BA Solutions', "error");
        }
    });

    block_ele.unblock();
}
