$(document).ready(function () {
    function toggleBranchDiv() {
        let selectedKey = $('#type_id option:selected').data('key');
        if (selectedKey === 'B') {
            $('#branch_div').removeClass('d-none');
        } else {
            $('#branch_div').addClass('d-none');
        }
    }
    $('#type_id').on('change', toggleBranchDiv);
    toggleBranchDiv();
});
