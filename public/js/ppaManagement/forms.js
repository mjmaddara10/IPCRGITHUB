// Cancel Editing Form
$(document).on('click', '.closeEditModal', function(e) {
    e.preventDefault(); 

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to discard your changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, discard changes",
        cancelButtonText: "No, keep editing"
    }).then((result) => {
        if (result.isConfirmed) {
            // Close the modal if the user confirms
            $('#editActivityModal').modal('hide');
            $('#editProgramModal').modal('hide');
            $('#editProjectModal').modal('hide');
            $('#editSubProjectModal').modal('hide');
            $('#editSubActivityModal').modal('hide');
        }
    });
});

// Cancel Adding Form
$(document).on('click', '.closeAddModal', function(e) {
    e.preventDefault(); 

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to cancel?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, discard",
        cancelButtonText: "No, keep editing"
    }).then((result) => {
        if (result.isConfirmed) {
            // Close the modal if the user confirms
            $('#addProgramModal').modal('hide');
            $('#addProjectModal').modal('hide');
            $('#addActivityModal').modal('hide');
            $('#addActivityInSubModal').modal('hide');
            $('#addActivityInProgramModal').modal('hide');
            $('#addSubProjectModal').modal('hide');
            $('#addSubActivityModal').modal('hide');
        }
    });
});