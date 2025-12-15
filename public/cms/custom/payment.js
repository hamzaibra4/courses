$(document).ready(function() {
    $('#student_id').on('change', function() {
        var studentId = $(this).val();
        var $enrollmentSelect = $('#enrollment_number');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $enrollmentSelect.empty();
        $enrollmentSelect.append('<option value="">Select Enrollment Number</option>');

        if (studentId) {
            $enrollmentSelect.prop('disabled', true);

            $.ajax({
                url: '/get-enrollment-status',
                type: 'POST',
                data: {
                    student_id: studentId,
                    _token: csrfToken
                },
                success: function(response) {
                    if (response.code === 200 && Array.isArray(response.enrollment_numbers) && response.enrollment_numbers.length > 0) {
                        $.each(response.enrollment_numbers, function(index, item) {
                            $enrollmentSelect.append('<option value="' + item.enrollment_number + '">' + item.enrollment_number + '</option>');
                        });

                        if ($enrollmentSelect.hasClass('select2')) {
                            $enrollmentSelect.select2();
                        }
                    } else {
                        $enrollmentSelect.append('<option value="">No enrollment numbers found</option>');
                    }
                    $enrollmentSelect.prop('disabled', false);
                },
                error: function(xhr) {
                    console.error('Error fetching enrollment numbers:', xhr);
                    $enrollmentSelect.append('<option value="">Error loading enrollment numbers</option>');
                    $enrollmentSelect.prop('disabled', false);
                }
            });
        } else {
            $enrollmentSelect.prop('disabled', false);
        }
    });
    if ($('#student_id').val()) {
        $('#student_id').trigger('change');
    }
});
