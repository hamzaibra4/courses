$(document).ready(function () {
    if (Array.isArray(existingQuotationDetails)) {
        existingQuotationDetails.forEach(row => {
            addRow(row.name, row.nameId, row.quantity, row.price);
        });
    }
    $("#patient").trigger("change");
});
