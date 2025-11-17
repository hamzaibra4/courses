$('#searchDoctor').on('input', function () {
    var search = $(this).val().toLowerCase();
    $('.doctor-item').each(function () {
        var name = $(this).data('name');
        $(this).toggle(name.includes(search));
    });
});
