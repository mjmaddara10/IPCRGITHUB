$(document).on('submit', '.addProgramApproveForm', function(e) {
    e.preventDefault();

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
                url: '/admin/addProgram',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    addProgramId: $('#addProgramIdRequest').val(),
                    addProgramName: $('#addProgramNameRequest').val(),
                    addSuccessIndicator: $('#addProgramSuccessIndicatorRequest').val(),
                    addQuality: $('#addProgramQualityRequest').val(),
                    addEfficiency: $('#addProgramEfficiencyRequest').val(),
                    addTimeliness: $('#addProgramTimelinessRequest').val(),
                    addRemarks: $('#addProgramRemarksRequest').val(),
                    addBudget: $('#addProgramBudgetRequest').val(),
                    divisions: JSON.parse($('#divisionIdView').val()),
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Program added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        location.reload(); // Or update the DOM instead of reload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'An error occurred while adding the program.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});

$(document).on('submit', '.addProgramDisapproveForm', function(e) {
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
                    programId: $('#deleteProgramIdRequest').val(),
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
                        text: xhr.responseJSON?.message || 'An error occurred while adding the program.',
                        icon: 'error',
                        confirmButtonColor: '#bc0c0c'
                    });
                }
            });
        }
    });
});