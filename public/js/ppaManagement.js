$(document).on('click', '.editActivityBtn', function() {
    // Get data from the button clicked
    var activityId = $(this).data('activity-id');
    var activityName = $(this).data('activity-name');
    var successIndicator = $(this).data('success-indicator');
    var quality = $(this).data('quality');
    var efficiency = $(this).data('efficiency');
    var timeliness = $(this).data('timeliness');

    // Populate the modal fields with the data
    $('#activityId').val(activityId);
    $('#editActivityName').val(activityName);
    $('#editSuccessIndicator').val(successIndicator);
    $('#editQuality').val(quality);
    $('#editEfficiency').val(efficiency);
    $('#editTimeliness').val(timeliness);
});

// Edit Activity
$('#editActivityForm').on('submit', function(e) {
    e.preventDefault();
    
    // Get the form data
    var formData = $(this).serialize();

    // Make an AJAX request to update the activity
    $.ajax({
        url: 'updateActivity',  // Your update URL
        method: 'POST',
        data: formData,
        success: function(response) {
            // Handle the success response (e.g., reload the table or close the modal)
            $('#editActivityModal').modal('hide');
            location.reload(); // Reload the page to see the changes
        },
        error: function(response) {
            // Handle the error response
            alert(JSON.stringify(response)); 
            // alert('An error occurred. Please try again.');
        }
    });
});