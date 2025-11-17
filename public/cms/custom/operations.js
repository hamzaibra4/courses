document.getElementById('addRowBtn').addEventListener('click', function () {
    const table = document.getElementById('dynamic-inputs');  // Now a table instead of a div container
    const row = table.insertRow(-1);  // Insert row at the end of the table

    // Define the fields
    const fields = [
        { name: 'sub_name[]', label: 'Name' },
        { name: 'sub_code[]', label: 'Code' },
        { name: 'sub_description[]', label: 'Description' },
        { name: 'sub_note[]', label: 'Note' },
        { name: 'sub_price[]', label: 'Price' }
    ];

    // Loop through fields to create cells and inputs
    fields.forEach(field => {
        const cell = row.insertCell(-1);  // Insert a cell in the row

        let inputElement;

        if (field.name === 'sub_note[]') {
            // Note field as textarea
            inputElement = `<textarea class="form-control auto-height" name="${field.name}" placeholder="${field.label}" rows="1"></textarea>`;
        } else {
            const inputType = field.name === 'sub_price[]' ? 'number' : 'text';
            const isRequired = (field.name !== 'sub_description[]') ? 'required' : '';
            inputElement = `<input type="${inputType}" class="form-control" name="${field.name}" placeholder="${field.label}" ${isRequired}>`;
        }

        cell.innerHTML = `
            ${inputElement}
        `;
    });

    // Add Remove Button Cell
    const removeCell = row.insertCell(-1);  // Insert a cell for the remove button
    removeCell.innerHTML = `
        <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 remove-row">x Remove</button>
    `;

    // Re-initialize DataTables after adding the row (Refresh the table)
    $('#dynamic-inputs').DataTable().rows.add($(row)).draw();
});

// Event delegation to handle dynamically added remove buttons
document.getElementById('dynamic-inputs').addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();  // Use <tr> for table rows

        // Re-initialize DataTables after removing the row (Refresh the table)
        let table = $('#dynamic-inputs').DataTable();
        table.row(e.target.closest('tr')).remove().draw();
    }
});

// Initialize DataTable only once
$(document).ready(function () {
    let table = $('#dynamic-inputs').DataTable({
        pageLength: 5,
        lengthChange: false,
        searching: true,
        ordering: true,
        language: {
            searchPlaceholder: "Search Operations..."
        }
    });
});
