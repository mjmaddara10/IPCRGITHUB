// Add Sub-Activity
$('#addSubActivityRequestForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this sub-activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, add sub-activity"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/addSubActivityRequest',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to add sub-activity is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addSubActivityInProgramModal').modal('hide'); // Close the modal
                        location.reload(); // Optionally reload the page to see the new activity
                    });
                },
                error: function(xhr) {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'An error occurred while adding the sub-activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                    alert('Response: ' + JSON.stringify(xhr));
                }
            });
        }
    });    
});

// Edit Sub-Activity
$('#editSubActivityRequestForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to edit this sub-activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, edit sub-activity"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/editSubActivityRequest',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to edit sub-activity is now pending. Please wait for the Department Head\'s approval',
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
                        text: xhr.responseJSON.message || 'An error occurred while editing the sub-activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                    alert('Response: ' + JSON.stringify(xhr));
                }
            });
        }
    });    
});

// Delete Sub-Activity
$(document).on('click', '.deleteSubActivityRequestBtn', function(e) {
    e.preventDefault();

    var subActivityId = $(this).data('sub-activity-id');
    var subActivityName = $(this).data('sub-activity-name');
    var subActivitySuccessIndicator = $(this).data('sub-activity-success');
    var subActivityQuality = $(this).data('sub-activity-quality');
    var subActivityEfficiency = $(this).data('sub-activity-efficiency');
    var subActivityTimeliness = $(this).data('sub-activity-timeliness');
    var subActivityRemarks = $(this).data('sub-activity-remarks');

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
                url: '/admin/deleteSubActivityRequest',
                method: 'POST',
                data: {
                    deleteSubActivityId: subActivityId,
                    deleteSubActivityName: subActivityName,
                    deleteSubActivitySuccessIndicator: subActivitySuccessIndicator,
                    deleteSubActivityQuality: subActivityQuality,
                    deleteSubActivityEfficiency: subActivityEfficiency,
                    deleteSubActivityTimeliness: subActivityTimeliness,
                    deleteSubActivityRemarks: subActivityRemarks,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request to delete sub-activity is now pending. Please wait for the Department Head\'s approval',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#deleteSubActivityModal').modal('hide');
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