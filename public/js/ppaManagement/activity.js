// Edit Activity Fill Form
$(document).on('click', '.editActivityBtn', function() {
    // Get data from the button clicked
    var activityId = $(this).data('activity-id');
    var activityName = $(this).data('activity-name');
    var successIndicator = $(this).data('success-indicator');
    var quality = $(this).data('quality');
    var efficiency = $(this).data('efficiency');
    var timeliness = $(this).data('timeliness');
    var remarks = $(this).data('remarks');

    // Populate the modal fields with the data
    $('#activityId').val(activityId);
    $('#editActivityName').val(activityName);
    $('#editSuccessIndicatorActivity').val(successIndicator);
    $('#editQualityActivity').val(quality);
    $('#editEfficiencyActivity').val(efficiency);
    $('#editTimelinessActivity').val(timeliness);
    $('#editRemarksActivity ').val(remarks);
});

// Edit Activity
$('#editActivityForm').on('submit', function(e) {
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
                url: 'updateActivity',  // Your update URL
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
                }
            });
        }
    });
});

// Add Activity Fill Form
$(document).on('click', '.addActivityBtn', function() {
    // Get data from the button clicked
    var projectId = $(this).data('project-id');
    var projectName = $(this).data('project-name');

    // Populate the modal fields with the data
    $('#projectId').val(projectId);
    $('#projectName').val(projectName);
});

// Add Activity
$('#addActivityForm').on('submit', function(e) {
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
                url: 'addActivity',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Activity added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addActivityModal').modal('hide'); // Close the modal
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

// Delete Activity
$(document).on('click', '.deleteActivityBtn', function(e) {
    e.preventDefault();

    var activityId = $(this).data('activity-id');
    var deleteUrl  = $(this).data('url');
    console.log(activityId);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, delete activity"
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX request to delete the activity
            $.ajax({
                url: deleteUrl,  // Your delete URL
                method: 'POST',
                data: {
                    activityId: activityId // Pass the activity ID
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token in the headers
                },
                success: function(response) {
                    // Show success Swal alert
                    Swal.fire({
                        title: 'Activity deleted',
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

// Add Activity in Sub-Project Fill Form
$(document).on('click', '.addActivityInSubBtn', function() {
    // Get data from the button clicked
    var subProjectId = $(this).data('subProject-id');
    var subProjectName = $(this).data('subProject-name');

    // Populate the modal fields with the data
    $('#subProjectId').val(subProjectId);
    $('#subProjectName').val(subProjectName);
});

// Add Activity in Sub-Project
$('#addActivityInSubForm').on('submit', function(e) {
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
                url: 'addActivityInSub',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Activity added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addActivityInSubModal').modal('hide'); // Close the modal
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

// Add Activity in Program Fill Form
$(document).on('click', '.addActivityInProgramBtn', function() {
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');

    $('#programIdProg').val(programId);
    $('#programNameProg').val(programName);

    var divisionNameRaw = $(this).data('division-name');
    let divisionNames = [];

    if (Array.isArray(divisionNameRaw)) {
        divisionNames = divisionNameRaw;
    } else if (typeof divisionNameRaw === 'string') {
        divisionNames = divisionNameRaw.split(',').map(name => name.trim());
    }

    var primaryDivisionName = divisionNames[0]; // or handle multiple if needed

    if (primaryDivisionName) {
        $.ajax({
            url: '/admin/getAccountable/' + encodeURIComponent(primaryDivisionName),
            type: 'GET',
            success: function (response) {
                const $select = $('#addAccountableId');
                $select.empty(); // clear previous options
                $select.append('<option value="">Select accountable person</option>');
            
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function(person) {
                        $select.append(`<option value="${person.id}">${person.name}</option>`);
                    });
            
                    // ✅ Bonus: Auto-select if only one option is returned
                    if (response.length === 1) {
                        $select.val(response[0].id);
                    }
            
                } else {
                    $select.append('<option value="">No accountable found</option>');
                }
            },
            error: function () {
                const $select = $('#addAccountableId');
                $select.empty().append('<option value="">Error fetching data</option>');
            }
        });
    }
});

// Add Activity in Program
$('#addActivityInProgramForm').on('submit', function(e) {
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
                url: 'addActivityInProgram',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Activity added successfully.',
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