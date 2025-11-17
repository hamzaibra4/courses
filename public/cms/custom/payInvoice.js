function confirmPayment($id) {
    swal({
        title: 'Pay Invoice',
        text: 'Are you sure you want to mark this invoice as fully paid?',
        icon: "warning",
        buttons: {
            cancel: {
                text:  'No, cancel please!',
                value: null,
                visible: true,
                className: "",
                closeModal: false,
            },
            confirm: {
                text: 'Yes, pay it!',
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {
            $.ajax({
                url: $("#payInvoice").val(),
                type: 'POST',
                data: {
                    invoiceId: $id,
                    fromPatientDashboard: $("#fromPatientDashboard").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.code==="200"){
                        swal('Success',response.message, "success");
                        setTimeout(function() {
                            window.location.href = response.route;
                        }, 2000);
                    }else{
                        swal('Error',response.message, "error");
                    }
                },
                error: function (xhr) {
                    swal('Error','An Error has occurred please contact BA Solutions', "error");
                }
            });
        } else {
            swal( 'Cancelled', 'This action is cancelled', "error");
        }
    });
}
