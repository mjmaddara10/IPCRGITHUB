$(document).on('submit', '.addActivityApproveForm', function(e) {
    e.preventDefault();

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
                url: '/admin/addActivityInProgram',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    programIdProg: $('#addActivityProgramId').val(), //For parent
                    addActivityId: $('#addActivityIdRequest').val(),
                    addActivityName: $('#addActivityNameRequest').val(),
                    addSuccessIndicator: $('#addActivitySuccessIndicatorRequest').val(),
                    addQuality: $('#addActivityQualityRequest').val(),
                    addEfficiency: $('#addActivityEfficiencyRequest').val(),
                    addTimeliness: $('#addActivityTimelinessRequest').val(),
                    addRemarks: $('#addActivityRemarksRequest').val(),
                    requestor: $('#addActivityRequestor').val(),
                    addAccountableId: JSON.parse($('#employeeIdView').val()),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Activity added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.addActivityDisapproveForm', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: "Are you sure?",
        text: "This request will be disapproved and deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/rejectActivityRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    activityId: $('#deleteActivityIdAddRequest').val(),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request disapproved',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.editActivityApproveForm', function(e) {
    e.preventDefault();

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
                url: '/admin/updateActivity',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    editActivityId: $('#editActivityIdRequest').val(),
                    editActivityName: $('#editActivityNameRequest').val(),
                    editSuccessIndicatorActivity: $('#editActivitySuccessIndicatorRequest').val(),
                    editQualityActivity: $('#editActivityQualityRequest').val(),
                    editEfficiencyActivity: $('#editActivityEfficiencyRequest').val(),
                    editTimelinessActivity: $('#editActivityTimelinessRequest').val(),
                    editRemarksActivity: $('#editActivityRemarksRequest').val(),
                    editBudgetActivity: $('#editActivityBudgetRequest').val(),
                    requestor: $('#editActivityRequestor').val(),
                    reference: $('#editActivityReference').val(),
                    editAccountableId: JSON.parse($('#employeeIdViewEditActivity').val()),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Activity updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while updating the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.editActivityDisapproveForm', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: "Are you sure?",
        text: "This request will be disapproved and deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/rejectActivityRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    activityId: $('#deleteActivityIdEditRequest').val(),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request disapproved',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.deleteActivityApproveForm', function(e) {
    e.preventDefault();

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
            $.ajax({
                url: '/admin/deleteActivity',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    deleteActivityId: $('#deleteActivityIdDeleteRequest').val(),
                    referenceId: $('#deleteActivityReference').val(),
                    requestor: $('#deleteActivityRequestor').val(),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Activity deleted.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while deleting the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.deleteActivityDisapproveForm', function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: "This request will be disapproved and deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/rejectActivityRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    activityId: $('#deleteActivityIdDeleteRequest').val(),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Request disapproved',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});