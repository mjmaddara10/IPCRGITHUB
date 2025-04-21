// Add Activity Fill Form
$(document).on('click', '.addActivityInProgramBtn', function () {
    const programId = $(this).data('program-id');
    const programName = $(this).data('program-name');
    const divisionIdsRaw = $(this).data('division-ids');
    let divisionIds = [];

    if (Array.isArray(divisionIdsRaw)) {
        divisionIds = divisionIdsRaw;
    } else if (typeof divisionIdsRaw === 'string') {
        try {
            divisionIds = JSON.parse(divisionIdsRaw);
        } catch (e) {
            console.error('Invalid JSON in division-ids:', divisionIdsRaw);
        }
    }

    // Set program data in modal
    $('#programIdProg').val(programId);
    $('#programNameProg').val(programName);

    // Reset form: remove extra selects and clear first one
    const $container = $('#accountableSelectContainer');
    $container.find('.accountable-select-group:gt(0)').remove();
    $container.find('.accountable-select-group select').empty().append('<option value="">Select accountable person</option>');
    $container.find('.removeAccountableBtn').prop('disabled', true);

    // Fetch employees from server
    if (divisionIds.length > 0) {
        $.ajax({
            url: '/admin/getAccountableByIds',
            type: 'POST',
            data: {
                divisionIds: divisionIds,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                populateAccountableOptions(response);
            },
            error: function () {
                $('.accountableSelect').each(function () {
                    $(this).empty().append('<option value="">Error fetching data</option>');
                });
            }
        });
    }
});

// Helper to populate all select dropdowns with fetched employees
function populateAccountableOptions(accountables) {
    const $selects = $('.accountableSelect');
    $selects.each(function () {
        const $select = $(this);
        $select.empty();
        $select.append('<option value="">Select accountable person</option>');

        accountables.forEach(accountable => {
            $select.append(`<option value="${accountable.id}">${accountable.name} (${accountable.role})</option>`);
        });
    });
}

// Add accountable person input
$('#addAccountablePersonBtn').on('click', function () {
    const $container = $('#accountableSelectContainer');
    const $newGroup = $(`
        <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
            <select class="form-select border-2 py-2 accountableSelect" name="addAccountableId[]" style="border-color: #03592c; background-color: #ffffff;">
                <option value="">Loading...</option>
            </select>
            <button type="button" class="btn btn-danger btn-sm removeAccountableBtn">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `);
    
    $container.append($newGroup);

    // Populate newly added select with existing options
    const firstSelect = $('.accountableSelect').first();
    const newSelect = $newGroup.find('select');
    newSelect.html(firstSelect.html()); // Copy all options

    // Enable remove button if there's more than one
    updateAccountableRemoveButtons();
});

// Remove accountable person input
$(document).on('click', '.removeAccountableBtn', function () {
    $(this).closest('.accountable-select-group').remove();
    updateAccountableRemoveButtons();
});

// Disable first remove button if it's the only one left
function updateAccountableRemoveButtons() {
    const $buttons = $('.removeAccountableBtn');
    $buttons.prop('disabled', false);
    $buttons.first().prop('disabled', true);
}

// Populate accountable select inputs
function populateAccountableOptions(options) {
    const htmlOptions = options.map(person =>
        `<option value="${person.id}">${person.name} - ${person.position}</option>`
    ).join('');

    $('.accountableSelect').each(function () {
        $(this)
            .empty()
            .append('<option value="">Select accountable person</option>')
            .append(htmlOptions);
    });
}

// Add new accountable person input
// $('#addAccountablePersonBtn').on('click', function () {
//     const $container = $('#accountableSelectContainer');
//     const $firstGroup = $container.find('.accountable-select-group:first');
//     const $newGroup = $firstGroup.clone();

//     $newGroup.find('select').val('');
//     $newGroup.find('.removeAccountableBtn').prop('disabled', false);

//     $container.append($newGroup);
// });

// Remove a responsible person input
// $(document).on('click', '.removeAccountableBtn', function () {
//     const $groups = $('.accountable-select-group');
//     if ($groups.length > 1) {
//         $(this).closest('.accountable-select-group').remove();
//     }
// });


// Add Activity
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