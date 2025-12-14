$(document).ready(function() {
    $(document).on('click', '.delete-pdf-btn', function(e) {
        e.preventDefault();
        const pdfId = $(this).data('pdf-id');
        const deleteUrl = $(this).data('delete-url');
        const pdfItem = $(this).closest('.pdf-item');

        swal({
            title: 'Are you sure?',
            text: 'You will not be able to recover this PDF!',
            icon: "warning",
            buttons: {
                cancel: {
                    text: 'No, cancel please!',
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: 'Yes, delete it!',
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: false
                }
            },
            dangerMode: true
        }).then(isConfirm => {
            if (isConfirm) {
                // Block UI during deletion
                var block_ele = $(".card-body");
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
                    type: 'DELETE',
                    url: deleteUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        block_ele.unblock();
                        var msg = data.msg;
                        if (typeof msg === 'undefined') {
                            msg = "PDF deleted successfully";
                        }
                        if (data.code == 200) {
                            // Remove the PDF item from DOM
                            pdfItem.fadeOut(300, function() {
                                $(this).remove();
                                // Check if no PDFs remain, hide the section
                                if ($('#pdf-list .pdf-item').length === 0) {
                                    $('#pdf-list').closest('.row').fadeOut(300);
                                }
                            });
                            swal('Deleted!', msg, "success");
                        } else {
                            swal('Error', msg, "error");
                        }
                    },
                    error: function(response) {
                        block_ele.unblock();
                        var errorMsg = 'An error occurred. Please try again.';
                        if (response.responseJSON && response.responseJSON.msg) {
                            errorMsg = response.responseJSON.msg;
                        }
                        swal('Error', errorMsg, "error");
                    }
                });
            } else {
                swal('Cancelled', 'Your PDF is safe', "info");
            }
        });
    });
});
