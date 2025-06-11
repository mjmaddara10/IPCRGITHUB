$(document).on('submit', '.addSubActivityApproveForm', function(e) {
    e.preventDefault();

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
                url: '/admin/addSubActivity',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    activityIdSub: $('#addParentActivityId').val(), //For parent
                    addSubActivityId: $('#addSubActivityIdRequest').val(),
                    addSubActivityName: $('#addSubActivityNameRequest').val(),
                    addSuccessIndicator: $('#addSubActivitySuccessIndicatorRequest').val(),
                    addQuality: $('#addSubActivityQualityRequest').val(),
                    addEfficiency: $('#addSubActivityEfficiencyRequest').val(),
                    addTimeliness: $('#addSubActivityTimelinessRequest').val(),
                    addRemarks: $('#addSubActivityRemarksRequest').val(),
                    requestor: $('#addSubActivityRequestor').val(),
                    addAccountableId: JSON.parse($('#employeeIdViewSub').val()),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Sub-activity added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the sub-activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.addSubActivityDisapproveForm', function(e) {
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
                url: '/admin/rejectSubActivityRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    subActivityId: $('#deleteSubActivityIdAddRequest').val(),
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
                        text: xhr.responseJSON?.message || 'An error occurred while deleting the sub-activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.editSubActivityApproveForm', function(e) {
    e.preventDefault();

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
                url: '/admin/updateSubActivity',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    editActivityIdSub: $('#editSubActivityReference').val(),
                    editSubActivityId: $('#editSubActivityIdRequest').val(),
                    editActivityNameSub: $('#editSubActivityNameRequest').val(),
                    editSuccessIndicatorSub: $('#editSubActivitySuccessIndicatorRequest').val(),
                    editQualitySub: $('#editSubActivityQualityRequest').val(),
                    editEfficiencySub: $('#editSubActivityEfficiencyRequest').val(),
                    editTimelinessSub: $('#editSubActivityTimelinessRequest').val(),
                    editRemarksSub: $('#editSubActivityRemarksRequest').val(),
                    requestor: $('#editSubActivityRequestor').val(),
                    reference: $('#editSubActivityReference').val(),
                    editAccountableId: JSON.parse($('#employeeIdViewEditSubActivity').val()),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Sub-Activity updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while updating the sub-activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.editSubActivityDisapproveForm', function(e) {
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
                url: '/admin/rejectSubActivityRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    subActivityId: $('#deleteSubActivityIdEditRequest').val(),
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

$(document).on('submit', '.deleteSubActivityApproveForm', function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this sub-activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, delete activity"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/deleteSubActivity',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    deleteSubActivityId: $('#deleteSubActivityIdDeleteRequest').val(),
                    subActivityId: $('#deleteSubActivityReference').val(),
                    requestor: $('#deleteSubActivityRequestor').val(),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Sub-activity deleted.',
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

$(document).on('submit', '.deleteSubActivityDisapproveForm', function(e) {
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
                url: '/admin/rejectSubActivityRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    subActivityId: $('#deleteSubActivityIdDeleteRequest').val(),
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
                        text: xhr.responseJSON?.message || 'An error occurred while deleting the sub-activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});