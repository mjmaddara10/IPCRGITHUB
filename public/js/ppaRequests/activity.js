// Add Activity
$('#addActivityRequestForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, add activity"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/addActivityRequest',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to add activity is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addActivityInProgramModal').modal('hide'); // Close the modal
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
                    alert('Response: ' + JSON.stringify(xhr));
                }
            });
        }
    });    
});

// Edit Activity
$('#editActivityRequestForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to edit this activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, edit activity"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/editActivityRequest',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to edit activity is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#editActivityModal').modal('hide'); // Close the modal
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

// Delete Activity
$(document).on('click', '.deleteActivityRequestBtn', function(e) {
    e.preventDefault();

    var activityId = $(this).data('activity-id');
    var activityName = $(this).data('activity-name');
    var activitySuccessIndicator = $(this).data('activity-success');
    var activityQuality = $(this).data('activity-quality');
    var activityEfficiency = $(this).data('activity-efficiency');
    var activityTimeliness = $(this).data('activity-timeliness');
    var activityRemarks = $(this).data('activity-remarks');
    var activityBudget = $(this).data('activity-budget');

    Swal.fire({
        title: "Are you sure?",
        html: "Do you want to delete this?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/deleteActivityRequest',
                method: 'POST',
                data: {
                    deleteActivityId: activityId,
                    deleteActivityName: activityName,
                    deleteActivitySuccessIndicator: activitySuccessIndicator,
                    deleteActivityQuality: activityQuality,
                    deleteActivityEfficiency: activityEfficiency,
                    deleteActivityTimeliness: activityTimeliness,
                    deleteActivityRemarks: activityRemarks,
                    deleteActivityBudget: activityBudget,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to delete activity is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#deleteActivityModal').modal('hide');
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