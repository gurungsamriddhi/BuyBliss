$(document).ready(function () {
    $('.delete-btn').click(function (e) {
        e.preventDefault(); // prevent default button action
        let form = $(this).closest('form'); // get the related form

        Swal.fire({
            title: "Are you sure?",
            text: "This item will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // submit the form normally
            }
        });
    });
});

