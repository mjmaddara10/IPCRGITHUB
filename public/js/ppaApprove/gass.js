// Edit Gass
$(document).on('submit', '.editGassApproveForm', function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to edit this program?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/updateGass',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    editGassId: $('#editGassRequestId').val(),
                    editGassRequestId: $('#editGassRequestId').val(),
                    editGassBudget: $('#editGassBudget').val(),
                    requestorId: $('#editGassRequestor').val(),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'GASS updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while editing the program.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.editGassDisapproveForm', function(e) {
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
                url: '/admin/rejectGassRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    gassId: $('#editGassDisapproveRequestId').val(),
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
                        text: xhr.responseJSON?.message || 'An error occurred while editing GASS.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

// Add Critical Activity
$(document).on('submit', '.addGassCritApproveForm', function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this critical activity?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/addGassProgram',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    addProgramName: $('#AddGassCritNameRequest').val(),
                    addSuccessIndicator: $('#AddGassCritSuccessIndicatorRequest').val(),
                    addQuality: $('#AddGassCritQualityRequest').val(),
                    addEfficiency: $('#AddGassCritEfficiencyRequest').val(),
                    addTimeliness: $('#AddGassCritTimelinessRequest').val(),
                    addRemarks: $('#AddGassCritRemarksRequest').val(),
                    requestorId: $('#addGassCritRequestor').val(),
                    divisions: JSON.parse($('#divisionIdViewAddGassCrit').val()),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Critical ctivity added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the critical activity.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.addGassCritDisapproveForm', function(e) {
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
                url: '/admin/rejectProgramRequest',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    programId: $('#addGassCritRequestIdDisapprove').val(),
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
                        text: xhr.responseJSON?.message || 'An error occurred while editing GASS.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});