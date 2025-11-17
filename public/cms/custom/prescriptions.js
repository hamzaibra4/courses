const addDrugBtn = document.querySelector('#addDrugBtn');

if (addDrugBtn) {
    document.getElementById('addDrugBtn').addEventListener('click', function () {
        const container = document.getElementById('dynamic-inputs');
        const row = document.createElement('tr'); // Use <tr> for rows in DataTable, not <div>

        const fields = [
            { name: 'drug_name[]', label: 'Name', type: 'text' },
            { name: 'drug_quantity[]', label: 'Quantity', type: 'number' },
            { name: 'drug_unit[]', label: 'Unit', type: 'text' },
            { name: 'drug_duration[]', label: 'Duration', type: 'number' },
            { name: 'drug_frequency[]', label: 'Frequency', type: 'text' }
        ];

        fields.forEach(field => {
            const td = document.createElement('td');
            td.innerHTML = `<input type="${field.type}" class="form-control" required name="${field.name}" placeholder="${field.label}">`;
            row.appendChild(td);
        });

        // Add Remove Button in the last cell
        const removeBtnTd = document.createElement('td');
        removeBtnTd.classList.add('w-10perc');
        removeBtnTd.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 remove-row">x Remove</button>
        `;
        row.appendChild(removeBtnTd);

        // Add row to DataTable
        const table = $('#dynamic-inputs').DataTable();
        table.row.add($(row)).draw();
    });

    // Event delegation to handle dynamically added remove buttons
    document.getElementById('dynamic-inputs').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr'); // Using <tr> instead of <div>
            const table = $('#dynamic-inputs').DataTable();
            table.row(row).remove().draw(); // Remove row from DataTable
        }
    });
}

$(document).ready(function () {
    let table = $('#dynamic-inputs').DataTable({
        pageLength: 5,
        lengthChange: false,
        searching: true,
        ordering: true,
        language: {
            searchPlaceholder: "Search Prescription..."
        }
    });
});

$(document).ready(function () {
    $('select[name="patients[]"]').select2({
        placeholder: 'Select patients',
        allowClear: true
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const prescriptionNameInput = document.querySelector('input[name="name"]');
    const dynamicInputs = document.getElementById('dynamic-inputs');
    const loader = document.getElementById('favorite-loader');

    // let dataTable = $('#dynamic-inputs').DataTable(); // initialize once

    $('#favorite_prescription').on('change', function () {
        const prescriptionId = this.value;
        if (!prescriptionId) return;

        loader.style.display = 'inline'; // Show loader

        fetch(`/prescriptions/favorite/${prescriptionId}`)
            .then(response => response.json())
            .then(data => {
                loader.style.display = 'none';
                let dataTable = $('#dynamic-inputs').DataTable();
                // Set prescription name
                prescriptionNameInput.value = data.name;

                // Destroy the old DataTable and clear table body
                dataTable.destroy();
                $('#dynamic-inputs tbody').empty();

                // Add new drug rows
                data.drugs.forEach(drug => {
                    const row = `
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="drug_name[]" required value="${drug.name}" placeholder="Name">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="drug_quantity[]" required value="${drug.quantity}" placeholder="Quantity">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="drug_unit[]" required value="${drug.unit}" placeholder="Unit">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="drug_duration[]" required value="${drug.duration}" placeholder="Duration">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="drug_frequency[]" required value="${drug.frequency}" placeholder="Frequency">
                            </td>
                            <td class="w-10perc">
                                <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 remove-row">x Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#dynamic-inputs tbody').append(row);
                });

                // Reinitialize DataTable
                dataTable = $('#dynamic-inputs').DataTable();
            })
            .catch(error => {
                loader.style.display = 'none';
                console.error('Error fetching favorite prescription:', error);
            });
    });

    // Remove button for dynamically added drugs
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });
});

