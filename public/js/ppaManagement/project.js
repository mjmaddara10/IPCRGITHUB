// Add Project Fill Form
$(document).on('click', '.addProjectBtn', function() {
    // Get data from the button clicked
    var programId = $(this).data('program-id');
    var projectName = $(this).data('program-name');

    // Populate the modal fields with the data
    $('#programId').val(programId);
    $('#programName').val(projectName);
});

// Add Project
$('#addProjectForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this project?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, add project"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'addProject',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Project added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addProjectModal').modal('hide'); // Close the modal
                        location.reload(); // Optionally reload the page to see the new activity
                    });
                },
                error: function(xhr) {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'An error occurred while adding the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });    
});

// Edit Project Fill Form
$(document).on('click', '.editProjectBtn', function() {
    // Get data from the button clicked
    var projectId = $(this).data('project-id');
    var projectName = $(this).data('project-name');

    // Populate the modal fields with the data
    $('#editProjectId').val(projectId);
    $('#editProjectName').val(projectName);
});

// Edit Project
$('#editProjectForm').on('submit', function(e) {
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
                url: 'updateProject',  // Your update URL
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

// Delete Project
$(document).on('click', '.deleteProjectBtn', function(e) {
    e.preventDefault();

    var projectId = $(this).data('project-id');
    var deleteUrl  = $(this).data('url');
    console.log(projectId);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this project? All sub-projects and activities under it will also be deleted.",
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
                    projectId: projectId // Pass the project ID
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