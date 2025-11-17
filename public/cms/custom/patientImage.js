document.addEventListener('DOMContentLoaded', function () {
    const addImageBtn = document.getElementById('addImageBtn');
    const imageInput = document.getElementById('imageInput');

    // 1. Trigger file input when "Add Images" is clicked
    addImageBtn.addEventListener('click', function () {
        imageInput.click();
    });

    // 2. Upload image when selected
    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('patient_id', patientId); // Defined in Blade <script>
        formData.append('title', ''); // Optional title

        fetch('/images/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(res => {
                if (!res.ok) throw new Error('Upload failed');
                return res.json();
            })
            .then(data => {
                // Success – reload the page or dynamically update the gallery
                location.reload();
            })
            .catch(err => {
                alert('Image upload failed.');
                console.error(err);
            });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    $('.delete-image-btn').on('click', function (e) {
        e.preventDefault();

        const imageId = $(this).data('image-id');
        const targetUrl = $(this).data('delete-url');

        swal({
            title: "Are you sure?",
            text: "This image will be permanently deleted.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: targetUrl,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        const msg = data.msg ?? "GO TO CONTROLLER AND ADD MSG TO YOUR RESPONSE";

                        if (data.code == 200) {
                            // Remove the card from DOM
                            $('#image-card-' + imageId).remove();
                            swal("Deleted", msg, "success");
                        } else if (data.code == 250) {
                            location.reload();
                        } else if (data.code == 600) {
                            swal("Warning", msg, "warning");
                        } else {
                            swal("Error", msg, "error");
                        }
                    },
                    error: function () {
                        swal("Error", "An error occurred. Please contact support.", "error");
                    }
                });
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function () {
    $('.preview-image-btn').on('click', function () {
        const imageSrc = $(this).data('image-src');
        $('#previewModalImage').attr('src', imageSrc);
        $('#imagePreviewModal').modal('show');
    });
});


const imgAfter = document.querySelector('.img-wrapper:nth-of-type(2)');
const line = document.getElementById('line');
const slider = document.getElementById('slider');

slider.addEventListener('input', () => {
    line.style.left = `${slider.value}%`;
    imgAfter.style.clipPath = `inset(0px 0px 0px ${slider.value}%)`;
});

// // Reset on double-click
slider.addEventListener('dblclick', () => {
    slider.value = 50;
    line.style.left = '50%';
    imgAfter.style.clipPath = 'inset(0px 0px 0px 50%';
});



document.addEventListener('DOMContentLoaded', function () {
    const beforeAfterBtn = document.getElementById('beforeAfterBtn');
    const checkboxes = document.querySelectorAll('.image-select-checkbox');

    // ✅ Enforce max 2 checked checkboxes
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            const checked = document.querySelectorAll('.image-select-checkbox:checked');
            if (checked.length > 2) {
                this.checked = false;
                swal('Before After', 'You can only select up to 2 images.', "warning");
            }
        });
    });

    // beforeAfterBtn.addEventListener('click', function () {
    //     const isActive = this.classList.contains('active');

    //     if (!isActive) {
    //         // Enter selection mode
    //         checkboxes.forEach(cb => cb.classList.remove('d-none'));
    //         this.classList.add('active');
    //         this.textContent = 'Done Selecting';
    //     } else {
    //         // Exit selection mode
    //         const selected = Array.from(checkboxes).filter(cb => cb.checked);

    //         if (selected.length !== 2) {
    //             swal('Before After', 'Please select 2 images.', "warning");
    //             return;
    //         }

    //         // Get image URLs from parent .image-card data attribute
    //         const imgUrls = selected.map(cb => {
    //             return cb.closest('.image-card').getAttribute('data-image-src');
    //         });

    //         // Inject images into modal
    //         const modalImages = document.querySelectorAll('#sliderModal .img-wrapper img');
    //         modalImages[0].src = imgUrls[0]; // Before
    //         modalImages[1].src = imgUrls[1]; // After

    //         // Reset slider position
    //         const slider = document.getElementById('slider');
    //         const line = document.getElementById('line');
    //         const imgAfter = document.querySelector('.img-wrapper:nth-of-type(2)');
    //         slider.value = 50;
    //         line.style.left = '50%';
    //         imgAfter.style.clipPath = 'inset(0px 0px 0px 50%)';

    //         // Open modal
    //         const modal = new bootstrap.Modal(document.getElementById('sliderModal'));
    //         modal.show();

    //         // Reset checkboxes
    //         checkboxes.forEach(cb => {
    //             cb.checked = false;
    //             cb.classList.add('d-none');
    //         });

    //         this.classList.remove('active');
    //         this.textContent = 'Before/After Creator';
    //     }
    // });

    let selectionOrder = [];

    beforeAfterBtn.addEventListener('click', function () {
        const isActive = this.classList.contains('active');

        if (!isActive) {
            // Enter selection mode
            selectionOrder = []; // reset tracking
            checkboxes.forEach(cb => {
                cb.classList.remove('d-none');
                cb.addEventListener('click', checkboxClickHandler);
            });
            this.classList.add('active');
            this.textContent = 'Done Selecting';
        } else {
            // Exit selection mode
            if (selectionOrder.length !== 2) {
                swal('Before After', 'Please select 2 images.', "warning");
                return;
            }

            // Get image URLs from parent .image-card data attribute
            const imgUrls = selectionOrder.map(cb => {
                return cb.closest('.image-card').getAttribute('data-image-src');
            });

            // Inject images into modal
            const modalImages = document.querySelectorAll('#sliderModal .img-wrapper img');
            modalImages[0].src = imgUrls[0]; // Before
            modalImages[1].src = imgUrls[1]; // After

            // Reset slider position
            const slider = document.getElementById('slider');
            const line = document.getElementById('line');
            const imgAfter = document.querySelector('.img-wrapper:nth-of-type(2)');
            slider.value = 50;
            line.style.left = '50%';
            imgAfter.style.clipPath = 'inset(0px 0px 0px 50%)';

            // Open modal
            const modal = new bootstrap.Modal(document.getElementById('sliderModal'));
            modal.show();

            // Reset checkboxes and selection state
            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.classList.add('d-none');
                cb.removeEventListener('click', checkboxClickHandler);
            });

            this.classList.remove('active');
            this.textContent = 'Before/After Creator';
        }
    });

    // Outside the main function
    function checkboxClickHandler(e) {
        const cb = e.target;
        if (cb.checked) {
            if (selectionOrder.length < 2 && !selectionOrder.includes(cb)) {
                selectionOrder.push(cb);
            } else if (selectionOrder.length === 2) {
                // Only allow 2 selections
                cb.checked = false;
            }
        } else {
            // Remove from order if unchecked
            selectionOrder = selectionOrder.filter(item => item !== cb);
        }
    }
});


