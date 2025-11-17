$(document).ready(function () {
    const isEdit = true;
    $("#patient").trigger("change");
    if (isEdit) {
        $(document).one('ajaxStop', function () {
            if (Array.isArray(existingQuotationDetails)) {
                existingQuotationDetails.forEach(row => {

                    $(`input.collectPayment[data-invoice="${row.invoiceId}"]`).val(row.amount);
                    $prv = $(`input.collectPayment[data-invoice="${row.invoiceId}"]`).attr("data-remaining");
                    $rec = $(`input.collectPayment[data-invoice="${row.invoiceId}"]`).attr("data-received");
                    $new = (Number($prv) + Number(row.amount)).toFixed(2);
                    $(`input.collectPayment[data-invoice="${row.invoiceId}"]`).attr("data-remaining",$new);
                    $(`input.collectPayment[data-invoice="${row.invoiceId}"]`).attr("max",$new);
                    $cy = $(`input.collectPayment[data-invoice="${row.invoiceId}"]`).attr("data-cy-value");
                    $newrec = (Number($rec) - Number(row.amount)).toFixed(2);
                    $(`.theremaning[data-invoice="${row.invoiceId}"]`).text($cy +" " + $new);
                    $(`.thereceived[data-invoice="${row.invoiceId}"]`).text($cy +" " + $newrec);
                });
            }
        });
    }
});
