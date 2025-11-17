var existingdata = $("#existing-data").val();
if(typeof (existingdata) != "undefined"){
    var jsonArray = JSON.parse(existingdata);
    $.each(jsonArray, function(index, item) {
        addNewItem(item.name);
    });
}

function addNewItem(value="") {
    var counter = $("#description-counter").val();
    var newRow =
        '<div class="col-md-12 descriptionData align-items-center pr-0" id="descriptionRow' + counter + '">' +
        '<label>Content: ' +
        '<a onclick="deleteItem(' + counter + ');">' +
        '<i id="deleteoffer5rule' + counter + '" class="fa fa-trash icon-trash"></i>' +
        '</a>' +
        '</label>' +
        '<input class="form-control" id="name-' + counter + '" name="name' + counter + '" value="' + value + '" >' +
        '</div>';
    $("#append-here").append(newRow);
    var incrementedCounter = parseInt(counter) + 1;
    $("#description-counter").val(incrementedCounter);
}
function deleteItem(id) {
    $("#descriptionRow"+id).remove();
    $("#descriptiontechRow"+id).remove();
}

