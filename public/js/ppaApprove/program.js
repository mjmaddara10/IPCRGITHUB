$(document).on('submit', '.addProgramApproveForm', function(e) {
    e.preventDefault();

    const form = $(this);
    const programId = form.data('program-id');
    const programName = form.data('program-name');
    const programSuccessIndicator = form.data('program-success-indicator');
    const quality = form.data('program-quality');
    const efficiency = form.data('program-efficiency');
    const timeliness = form.data('program-timeliness');
    const remarks = form.data('program-remarks');
    const budget = form.data('program-budget');
    const divisions = JSON.parse(form.attr('data-program-divisions'));
    const token = $('input[name="_token"]').val();

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
                    _token: token,
                    addProgramId: programId,
                    addProgramName: programName,
                    addSuccessIndicator: programSuccessIndicator,
                    addQuality: quality,
                    addEfficiency: efficiency,
                    addTimeliness: timeliness,
                    addRemarks: remarks,
                    addBudget: budget,
                    divisions: divisions
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

$(document).off('click', '.rejectProgramAddRequest').on('click', '.rejectProgramAddRequest', function () {
    var programId = $(this).data('program-id');
    
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
                    programId: programId,
                    _token: $('meta[name="csrf-token"]').attr('content'),
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