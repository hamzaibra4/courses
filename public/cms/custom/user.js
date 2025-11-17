$('.resetPassword').on('click',function(){
    var url =  $(this).attr("data-url");
    var rowid =  $(this).attr("data-id");
    ResetPassword(url,rowid);
});



$('.changeStatus').on('click',function(){
    var url =  $(this).attr("data-url");
    var rowid =  $(this).attr("data-id");
    var status =  $(this).attr("data-status");
    swal({
        title: 'Are you sure ?',
        text: 'Are you sure you want to change the status of this user?',
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
                text: 'Yes, proceed!',
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {
            ChangeStatus(url,rowid,status);
        } else {
            swal( 'Cancelled', 'Your user is safe', "error");
        }
    });



});

function ChangeStatus(targetUrl, id,status){
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
        type:'POST',
        url:targetUrl,
        data:{id:id,status:status},
        success:function(data){
            if (data.code== "200") {
                var newval = status === "1"? 0 : 1;
                var newstate = status === "1"? "Deactivate" : "Activate";
                var newstatus = status === "1"? "fa-solid fa-user-times" : "fa-solid fa-user";
                $("#statuscode"+id).attr("data-status",newval);
                $("#statusicon"+id).attr("class",newstatus);
                $("#statusicon"+id).attr("data-original-title",newstate);
                swal({
                    title: 'Success',
                    text: 'The status of the user has been changed successfully!',
                    icon: "success",
                    showCancelButton: true,
                })
            }else if (content === "500") {
                swal("Error", "An Error has occured please contact BA Solutions", "error");
            }
        },
        error: function(response) {
            swal("Error", "An Error has occured please contact BA Solutions", "error");
        }
    });
    block_ele.unblock();
}

$(document).on("click",".no-close",function(event) {
    event.stopPropagation();
});
function ResetPassword(targetUrl, id){
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
        type:'GET',
        url:targetUrl,
        data:{id:id},
        success:function(data){
            if(data.code==200){
                var view = data.view;
                $('.popup').html(view).attr('data-toggle', 'modal').attr('data-target', '#exampleModalCenter');
                $('#exampleModalCenter').modal('show');
            }
            else{
                swal('bad');
            }
        },
        error: function(response) {
            swal("Error", "An Error has occured please contact BA Solutions", "error");
        }
    });
    block_ele.unblock();
}




var content = $("#message").val();
    if (content === "200") {
        swal({
            title: 'Success',
            text: 'Password changed successfully!',
            icon: "success",
            showCancelButton: true,
        })
    }else if (content === "500") {
        swal("Error", "An Error has occured please contact BA Solutions", "error");
    }
$(document).on("click","#submit-confirmation-form",function(event) {
    event.preventDefault();
    var password = $('#pass1').val();
    var confirmPassword = $('#pass2').val();
    if (password !== confirmPassword) {
        $("#pass1").addClass("error-border");
        $("#pass2").addClass("error-border");
    } else {
        $("#pass1").removeClass("error-border");
        $("#pass2").removeClass("error-border");
        $("#confirmation-form").submit();

    }
});


