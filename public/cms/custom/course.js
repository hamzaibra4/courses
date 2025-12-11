function getNextIndex() {
    var v = parseInt($("#description-counter").val(), 10);
    if (isNaN(v) || v < $("#append-here .descriptionData").length) {
        v = $("#append-here .descriptionData").length;
    }
    return v;
}

function bumpCounter() {
    $("#description-counter").val($("#append-here .descriptionData").length);
}

// Load existing data on edit
var existingdataRaw = $("#existing-data").val();
if (typeof existingdataRaw !== "undefined" && existingdataRaw.trim() !== "") {
    try {
        var jsonArray = JSON.parse(existingdataRaw);
        // Reset counter before loading existing data
        $("#description-counter").val(0);
        $.each(jsonArray, function(index, item) {
            // Simply get the title directly from the item
            var title = item.title || "";
            if (title.trim() !== "") {
                addNewItem2(title);
            }
        });
        bumpCounter();
    } catch (e) {
        console.warn("Invalid existing-data JSON", e);
    }
}

function addNewItem(title = "") {
    var counter = getNextIndex();
    var newRow = `
    <div class="col-md-12 descriptionData align-items-center pr-0" id="descriptionRow${counter}">
      <label>Title:
        <a onclick="deleteItem(${counter});">
          <i id="deleteoffer5rule${counter}" class="fa fa-trash icon-trash"></i>
        </a>
      </label>
      <input class="form-control" required id="title_details-${counter}" placeholder="Enter your title" name="title_details[${counter}]" value="${title}">
    </div>`;
    $("#append-here").append(newRow);
    bumpCounter();
    if (typeof clearAppendWarning === "function") {
        clearAppendWarning();
    }
    window.afterAppendChange && window.afterAppendChange();
}

function addNewItem2(title = "") {
    addNewItem(title);
}

function deleteItem(id) {
    $("#descriptionRow" + id).remove();
    $("#descriptiontechRow" + id).remove();
    bumpCounter();
    window.afterAppendChange && window.afterAppendChange();
}

// Optional warning clearer used by other modules
function clearAppendWarning() {
    $('#append-required-msg').remove();
}

// Require at least one appended detail before form submit
$(function () {
    const $form = $('form');
    const $submit = $('button[type="submit"]');

    function hasDetail() {
        return $("#append-here .descriptionData").length > 0;
    }

    function showReq() {
        $('#append-required-msg').remove();
        $("#description-counter").after(
            '<span id="append-required-msg" class="text-danger ml-2">You must add at least one detail before saving.</span>'
        );
    }

    function clearReq() {
        $('#append-required-msg').remove();
    }

    // Reindex form inputs before submit to ensure sequential array indices
    function reindexInputs() {
        var index = 0;
        $("#append-here .descriptionData").each(function() {
            var $input = $(this).find('input[name^="title_details"]');
            var oldName = $input.attr('name');
            var newName = 'title_details[' + index + ']';
            $input.attr('name', newName);
            $input.attr('id', 'title_details-' + index);
            index++;
        });
        $("#description-counter").val(index);
    }

    $form.off('submit.validateAppend').on('submit.validateAppend', function (e) {
        if (!hasDetail()) {
            e.preventDefault();
            showReq();
            $submit.prop('disabled', false);
            return false;
        }
        // Reindex inputs before submit to ensure sequential array
        reindexInputs();
        clearReq();
    });

    window.afterAppendChange = function () {
        if (hasDetail()) {
            clearReq();
            $submit.prop('disabled', false);
        } else {
            $submit.prop('disabled', false);
        }
    };
});
