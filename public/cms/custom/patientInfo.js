$('#patient').on('change', function() {
    const selectedOption = $(this).find('option:selected');
    const patientDataJson = selectedOption.data('patient');
    const patientDetailsDisplay = $('#patient-details-display');
    patientDetailsDisplay.empty();
    if (patientDataJson && patientDataJson !== 'na') {
        const patient = patientDataJson;
        let htmlContent = '';
        if (patient.first_name || patient.last_name) {
            htmlContent += `<strong>${patient.first_name || ''} ${patient.last_name || ''}</strong><br>`;
        }
        if (patient.address) {
            htmlContent += `Address: ${patient.address}<br>`;
        }
        if (patient.dob) {
            htmlContent += `DOB: ${patient.dob}<br>`;
        }
        if (patient.email) {
            htmlContent += `Email: <a href="mailto:${patient.email}">${patient.email}</a> <br>`;
        }
        if (patient.telephone) {
            htmlContent += `Telephone: <a href="tel:${patient.telephone}">${patient.telephone}</a> <br>`;
        }

        patientDetailsDisplay.html(htmlContent);
    } else {
        patientDetailsDisplay.html('Please select a patient to view their details.');
    }
});
