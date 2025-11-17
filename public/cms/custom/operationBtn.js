
document.querySelector('.dropdown-button-teeth').addEventListener('click', function () {
    const menu = document.querySelector('.dropdown-menu-teeth');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', function (event) {
    const dropdown = document.querySelector('.dropdown-wrapper-teeth');
    if (!dropdown.contains(event.target)) {
        document.querySelector('.dropdown-menu-teeth').style.display = 'none';
    }
});
$('.dropdown-menu-teeth').on('keyup', '.suboperation-search', function () {
    const $input = $(this);
    const term = $input.val().toLowerCase();
    const $submenu = $input.closest('.sub-op-list');
    $submenu.find('.sub-operation-item').each(function () {
        const text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(term));
    });
});

$('.operation-search').on('keyup', function () {
    const searchTerm = $(this).val().toLowerCase();
    $('.operation-item').each(function () {
        const itemText = $(this).text().toLowerCase();
        if (itemText.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});
