$(document).on("click", ".transform-quotation", function(event){
    var url =  $(this).attr("data-url");
    confirmTransformation(url);
});

function confirmTransformation(url) {
    swal({
        title: 'Transform Quotation',
        text: 'Are you sure you want to transform this quotation into an invoice?',
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
                text: 'Yes, transform it!',
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {
            $.ajax({
                type:'POST',
                url:url,
                data:{},
                success:function(data){
                    if(data.code==="200"){
                        swal('Created', data.message, "success");
                        setTimeout(function() {
                            window.location.href = data.route;
                        }, 2000);
                    }else{
                        swal('Error',data.message, "error");
                    }
                },
                error: function(response) {
                    swal('Error','An Error has occurred please contact BA Solutions', "error");
                }
            });
        } else {
            swal( 'Cancelled', 'This action is cancelled', "error");
        }
    });
}
