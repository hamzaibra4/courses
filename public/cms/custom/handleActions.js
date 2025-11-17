window.onbeforeprint = function () {
    actionPerformed('print');
};
function actionPerformed(action){
    $.ajax({
        url: $("#actionName").val(),
        type: 'POST',
        data: {
            modelId: $("#modelId").val(),
            modelName: $("#modelName").val(),
            action: action,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
        },
        error: function (xhr) {
            swal('Error','An Error has occurred please contact BA Solutions', "error");
        }
    });
}
