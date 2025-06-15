// Add Program
$('#addProgramRequestForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this program?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, add program"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/addProgramRequest',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to add program is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addProgramModal').modal('hide'); // Close the modal
                        location.reload(); // Optionally reload the page to see the new activity
                    });
                },
                error: function(xhr) {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'An error occurred while adding the program.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                    alert('Response: ' + JSON.stringify(xhr));
                }
            });
        }
    });    
});

// Edit Program
$('#editProgramRequestForm').on('submit', function(e) {
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
                url: '/admin/editProgramRequest',
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
                        $('#editProgramModal').modal('hide'); // Close the modal
                        location.reload(); // Optionally reload the page to see the new activity
                    });
                },
                error: function(xhr) {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'An error occurred while editing the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                    alert('Response: ' + JSON.stringify(xhr));
                }
            });
        }
    });    
});

// Delete Program
$(document).on('click', '.deleteProgramRequestBtn', function(e) {
    e.preventDefault();

    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');
    var programBudget = $(this).data('program-budget');
    var gassId = $(this).data('gass-id');

    console.log("gass id:" + gassId);

    Swal.fire({
        title: "Are you sure?",
        html: "Do you want to delete this?<br><strong>All activities under it will also be deleted.</strong>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/deleteProgramRequest',
                method: 'POST',
                data: {
                    deleteProgramId: programId,
                    deleteProgramName: programName,
                    deleteProgramSuccessIndicator: programSuccessIndicator,
                    deleteProgramQuality: programQuality,
                    deleteProgramEfficiency: programEfficiency,
                    deleteProgramTimeliness: programTimeliness,
                    deleteProgramRemarks: programRemarks,
                    deleteProgramBudget: programBudget,
                    deleteProgramGassId: gassId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to delete program is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#editProgramModal').modal('hide');
                        location.reload();
                    });
                },
                error: function(response) {
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