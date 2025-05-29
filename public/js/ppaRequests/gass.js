// Edit GASS Program (Only the budget is editable)
$('#editGassRequestForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to edit this program?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, edit program"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/editGassRequest',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to edit program is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#editGassModal').modal('hide'); // Close the modal
                        location.reload(); // Optionally reload the page to see the new activity
                    });
                },
                error: function(xhr) {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'An error occurred while editing the program.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                    alert('Response: ' + JSON.stringify(xhr));
                }
            });
        }
    });    
});