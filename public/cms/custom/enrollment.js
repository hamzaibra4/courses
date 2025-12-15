function calculateTotal() {
    let total = 0;
    $('#course_id option:selected').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        total += price;
    });
    $('#amount').val(total.toFixed(2));
}

$('#course_id').on('change', function () {
    calculateTotal();
});
