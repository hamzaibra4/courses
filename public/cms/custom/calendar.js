"use strict";

if (document.querySelectorAll('#calendar1').length) {
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar1');

        let calendar1 = new FullCalendar.Calendar(calendarEl, {
            selectable: true,
            plugins: ["timeGrid", "dayGrid", "list", "interaction"],
            timeZone: "UTC",
            defaultView: "dayGridMonth",
            contentHeight: "auto",
            eventLimit: true,
            dayMaxEvents: 4,
            header: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
            },
            events: window.appointmentsData,
        });

        calendar1.render();

        $('#appointmentFilterForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    calendar1.removeAllEvents();
                    calendar1.addEventSource(response);
                    $('#calendar-filter-btn').prop('disabled', false);

                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });

        $('#resetFilterBtn').on('click', function () {
            $('#appointmentFilterForm')[0].reset();

            $('#appointmentType').val('').trigger('change');
            $('#doctorSelect').val('').trigger('change');

            const submitButton = $('#appointmentFilterForm').find('button[type="submit"]');
            submitButton.prop('disabled', true);

            $.ajax({
                url: $('#appointmentFilterForm').attr('action'),
                method: 'POST',
                data: $('#appointmentFilterForm').serialize(),
                success: function (response) {
                    calendar1.removeAllEvents();
                    calendar1.addEventSource(response);

                    submitButton.prop('disabled', false);
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    submitButton.prop('disabled', false);
                }
            });
        });



        $('#add-appointment-form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            const appointmentStoreUrl = $('#appointment-store').val();
            const submitButton = $('#submmit-appointment');

            $.ajax({
                url: appointmentStoreUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    swal('Success', 'Appointment created successfully!', 'success')
                        .then(() => {
                            $('#new-appointment-modal').modal('hide');
                            calendar1.removeAllEvents();
                            calendar1.addEventSource(response);
                            $('#add-appointment-form')[0].reset();
                            $('#sms-message-wrapper').hide();
                            $('#patient-phone-wrapper').hide();
                            $('#new-event').modal('hide');
                            submitButton.prop('disabled', false);
                        });
                    submitButton.prop('disabled', false);
                },
                error: function (xhr) {
                    submitButton.prop('disabled', false);

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        for (const [inputName, messages] of Object.entries(errors)) {
                            const input = $(`[id="${inputName}"]`);

                            input.addClass('is-invalid');

                            if (input.next('.invalid-feedback').length === 0) {
                                input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                            }
                        }

                        const firstInvalidInput = $('.is-invalid').first();
                        const tabPane = firstInvalidInput.closest('.tab-pane');
                        if (tabPane.length && !tabPane.hasClass('show')) {
                            const tabId = tabPane.attr('id');
                            $(`button[data-bs-target="#${tabId}"]`).tab('show');
                        }
                    } else {
                        swal({
                            title: "Error",
                            text: 'Something went wrong. Please try again.',
                            icon: "error",
                            button: "OK"
                        });
                    }
                }

            });
        });


        $('#add-appointment-form').on('input change', 'input, select, textarea', function () {
            $(this).removeClass('is-invalid');
            if ($(this).next().hasClass('invalid-feedback')) {
                $(this).next().remove();
            }
        });

    });
}

$('#patient_id').on('change', function () {
    const patientId = $(this).val();
    const routeTemplate = $('#patient-phone-url').val();
    const url = routeTemplate.replace('__ID__', patientId);

    if (patientId) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                $('#patient-phone').val(data.telephone || 'N/A');
                $('#patient-email').val(data.email || 'N/A');
                $('#patient-phone-wrapper').show();
                $('#patient-email-wrapper').show();
                $('#has_reminder_sms').prop('checked', false);
                $('#sms-message-wrapper').hide();
            },
            error: function () {
                $('#patient-phone').val('');
                $('#patient-phone-wrapper').hide();
                $('#patient-email').val('');
                $('#patient-email-wrapper').hide();
            }
        });
    } else {
        $('#patient-phone-wrapper').hide();
        $('#patient-email-wrapper').hide();

    }
});
$('#has_reminder_sms').click(function () {
    if ($(this).is(':checked')) {
        loadDefaultMessage();
        $('#sms-message-wrapper').show();
    } else {
        $('#sms-message-wrapper').hide();
    }
});

$('#has_reminder_email').click(function () {
    if ($(this).is(':checked')) {
        loadDefaultMessage();
        $('#email-message-wrapper').show();
    } else {
        $('#email-message-wrapper').hide();
    }
});

const DefaultRoute = $('#sms-default-route').val();


function loadDefaultMessage() {
    $.ajax({
        url: DefaultRoute,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                let message = response.message;
                $('#sms-message').val(message);
                $('#email-message').val(message);
            } else {
                alert('No default SMS message found.');
            }
        },
        error: function () {
            alert('Failed to load default SMS message.');
        }
    });
}

$('#sms-template-select').on('change', function () {
    let content = $(this).val();
    if (-1 == content) {
        loadDefaultMessage();
    }
    else {
        $('#sms-message').val(content);
    }
});

$('#email-template-select').on('change', function () {
    let content = $(this).val();
    if (-1 == content) {
        loadDefaultMessage();
    }
    else {
        $('#email-message').val(content);
    }
});

$('#new-event').on('shown.bs.modal', function () {
    $(this).find('select').select2({
        dropdownParent: $('#new-event'),
        width: '100%'
    });
});
