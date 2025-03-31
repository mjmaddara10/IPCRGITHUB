// Edit Program Fill Form
$(document).on('click', '.editProgramBtn', function() {
    // Get data from the button clicked
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');

    // Populate the modal fields with the data
    $('#editProgramId').val(programId);
    $('#editProgramName').val(programName);
});

// Edit Program
$('#editProgramForm').on('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save these changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, save changes!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Get the form data
            var formData = $(this).serialize();

            // Make an AJAX request to update the activity
            $.ajax({
                url: 'updateProgram',  // Your update URL
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Show success Swal alert
                    Swal.fire({
                        title: 'Successfully Updated!',
                        text: 'PPA has been updated',
                        icon: 'success',
                        confirmButtonColor: "#03592c",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Reload the page to see the changes
                    });
                },
                error: function(response) {
                    // Handle the error response
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonColor: "#bc0c0c"
                    });
                    alert('Response: ' + JSON.stringify(response));
                }
            });
        }
    });
});

// Delete Program
$(document).on('click', '.deleteProgramBtn', function(e) {
    e.preventDefault();

    var programId = $(this).data('program-id');
    var deleteUrl  = $(this).data('url');
    console.log(programId);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this program? All projects and activities under it will also be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, delete project"
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX request to delete the project
            $.ajax({
                url: deleteUrl,  // Your delete URL
                method: 'POST',
                data: {
                    programId: programId // Pass the project ID
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token in the headers
                },
                success: function(response) {
                    // Show success Swal alert
                    Swal.fire({
                        title: 'Project deleted',
                        text: 'PPA has been updated',
                        icon: 'success',
                        confirmButtonColor: "#03592c",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Reload the page to see the changes
                    });
                },
                error: function(response) {
                    // Handle the error response
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonColor: "#bc0c0c"
                    });
                    alert('Response: ' + JSON.stringify(response));
                }
            });
        }
    });
});