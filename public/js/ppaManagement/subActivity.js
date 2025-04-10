// Add Sub-Activity Fill Form
$(document).on('click', '.addSubActivityBtn', function() {
    // Get data from the button clicked
    var activityIdSub = $(this).data('activity-id');
    var activityNameSub = $(this).data('activity-name');

    // Populate the modal fields with the data
    $('#activityIdSub').val(activityIdSub);
    $('#activityNameSub').val(activityNameSub);
});

// Add Sub-Activity
$('#addSubActivityForm').on('submit', function(e) {
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
                url: 'addSubActivity',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Sub-activity added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addSubActivityModal').modal('hide'); // Close the modal
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
                }
            });
        }
    });    
});

// Edit Sub-Activity Fill Form
$(document).on('click', '.editSubActivityBtn', function() {
    // Get data from the button clicked
    var subActivityId = $(this).data('sub-activity-id');
    var subActivityName = $(this).data('sub-activity-name');
    var successIndicator = $(this).data('success-indicator');
    var quality = $(this).data('quality');
    var efficiency = $(this).data('efficiency');
    var timeliness = $(this).data('timeliness');
    var remarks = $(this).data('remarks');
    var accountable = $(this).data('accountable');

    // Populate the modal fields with the data
    $('#editActivityIdSub').val(subActivityId);
    $('#editActivityNameSub').val(subActivityName);
    $('#editSuccessIndicatorSub').val(successIndicator);
    $('#editQualitySub').val(quality);
    $('#editEfficiencySub').val(efficiency);
    $('#editTimelinessSub').val(timeliness);
    $('#editRemarksSub').val(remarks);
    $('#editAccountableSub').val(accountable);
});

// Edit Sub-Activity
$('#editSubActivityForm').on('submit', function(e) {
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
                url: 'updateSubActivity',  // Your update URL
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