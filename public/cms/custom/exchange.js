document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('dynamic-inputs');
    const currencies = JSON.parse(document.getElementById('currencies-json').textContent);

    // Init Select2 on page load (for static selects, if any)
    $('.select2-currency').select2();

    document.getElementById('addExBtn').addEventListener('click', function () {
        const row = document.createElement('div');
        row.classList.add('row', 'cust-form-input', 'mb-3', 'align-items-end');

        // Function to create currency select dropdown
        const createSelect = (name, label) => {
            const col = document.createElement('div');
            col.classList.add('form-group', 'col-md-3');

            let selectHTML = `<label>${label} </label><select name="${name}" class="form-control  select2-currency" required>`;
            for (const id in currencies) {
                selectHTML += `<option value="${id}">${currencies[id]}</option>`;
            }
            selectHTML += `</select>`;

            col.innerHTML = selectHTML;
            return col;
        };

        // Append From/To Currency and Amount fields
        row.appendChild(createSelect('from_currency_id[]', 'From Currency'));
        row.appendChild(createSelect('to_currency_id[]', 'To Currency'));

        const amountCol = document.createElement('div');
        amountCol.classList.add('form-group', 'col-md-3');
        amountCol.innerHTML = `
            <label>Amount <span class="is-required">*</span></label>
            <input type="number" class="form-control" required step="0.00001"  name="amount[]" placeholder="Amount">
        `;
        row.appendChild(amountCol);

        // Remove button
        const removeBtnCol = document.createElement('div');
        removeBtnCol.classList.add('form-group', 'col-md-2');
        removeBtnCol.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 remove-row">x Remove</button>
        `;
        row.appendChild(removeBtnCol);

        // Append to container
        container.appendChild(row);

        // Initialize Select2 for new selects
        $(row).find('.select2-currency').select2();

    });

    // Remove row when remove button is clicked
    container.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('.row').remove();
        }
    });
});
