$(document).ready(function () {
    $('.select2').select2();
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input.flat-date").forEach((input) => {
        if (input.dataset.flatpickrWrapped) return;
        const wrapper = document.createElement("div");
        wrapper.className = "input-group";

        const clonedInput = input.cloneNode(true);
        clonedInput.dataset.flatpickrWrapped = "true";

        const iconSpan = document.createElement("span");
        iconSpan.className = "input-group-text";
        iconSpan.innerHTML = `<i class="bi bi-calendar3"></i>`;

        input.replaceWith(wrapper);
        wrapper.appendChild(clonedInput);
        wrapper.appendChild(iconSpan);

        const picker = flatpickr(clonedInput, {
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "Y-m-d",
            clickOpens: true,
        });
        iconSpan.addEventListener("click", () => picker.open());
    });
});
