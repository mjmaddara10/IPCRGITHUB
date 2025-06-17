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
        $select.append(`<option value="">Select accountable person</option>`);

        accountables.forEach(accountable => {
            $select.append(`<option value="${accountable.id}">${accountable.name} | ${accountable.position}</option>`);
        });

        $select.append(`<option value="od">All Employees from Organizational Development</option>`);
    });
}

// Add accountable person input
$('#addAccountablePersonBtn').on('click', function () {
    const $container = $('#accountableSelectContainer');

    // Collect selected IDs
    const selectedIds = $('.accountableSelect').map(function () {
        return $(this).val();
    }).get();

    // Use the first select as the template for options
    const firstSelect = $('.accountableSelect').first();
    const $newGroup = $(
        `<div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
            <select class="form-select border-2 py-2 accountableSelect" name="addAccountableId[]" style="border-color: #03592c; background-color: #ffffff;">
            </select>
            <button type="button" class="btn btn-danger btn-sm removeAccountableBtn">
                <i class="fas fa-minus"></i>
            </button>
        </div>`
    );

    const $newSelect = $newGroup.find('select');
    
    // Rebuild the options, disabling already-selected ones
    firstSelect.find('option').each(function () {
        const value = $(this).val();
        const text = $(this).text();
        const isDisabled = selectedIds.includes(value) ? 'disabled' : '';
        $newSelect.append(`<option value="${value}" ${isDisabled}>${text}</option>`);
    });

    $container.append($newGroup);

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
                url: '/admin/addActivityInProgram',
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
let editActivityId;

$(document).on('click', '.editActivityBtn', function () {
    editActivityId = $(this).data('activity-id');

    // Existing autofill for other fields...
    $('#editActivityId').val(editActivityId);
    $('#editActivityName').val($(this).data('activity-name'));
    $('#editSuccessIndicatorActivity').val($(this).data('success-indicator'));
    $('#editQualityActivity').val($(this).data('quality'));
    $('#editEfficiencyActivity').val($(this).data('efficiency'));
    $('#editTimelinessActivity').val($(this).data('timeliness'));
    $('#editRemarksActivity').val($(this).data('remarks'));
    
    // Clear previous selects
    const $editContainer = $('#editContainer');
    $editContainer.empty();

    $.ajax({
        url:  `/admin/activity/${editActivityId}/getActivityAccountables`,
        method: 'GET',
        success: function (response) {
            response.forEach(function (person, index) {
                const isFirst = index === 0;
                const selectGroup = `
                    <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                        <select class="form-select border-2 py-2 editAccountableSelect" name="editAccountableId[]" style="border-color: #03592c; background-color: #ffffff;">
                            <option value="${person.id}" selected>${person.name} | ${person.position}</option>
                        </select>
                        <button type="button" class="btn btn-danger btn-sm removeAccountableBtn" >
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>`;
                $editContainer.append(selectGroup);
            });
        },
        error: function () {
            console.error('Failed to fetch individuals responsible.');
        }
    });
});

$('#addAccountableEditBtn').on('click', function () {
    if (!editActivityId) return;

    // Get all selected employee IDs
    const selectedIds = $('.editAccountableSelect').map(function () {
        return $(this).val();
    }).get();

    $.ajax({
        url: `/admin/activity/${editActivityId}/fetchEmployee`,
        method: 'GET',
        success: function (employees) {
            // Create options, disabling those already selected
            let optionsHtml = employees.map(e => {
                const isDisabled = selectedIds.includes(e.id.toString()) ? 'disabled' : '';
                return `<option value="${e.id}" ${isDisabled}>${e.name} | ${e.position}</option>`;
            }).join('');

            const selectGroup = `
                <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                    <select class="form-select border-2 py-2 editAccountableSelect" name="editAccountableId[]" style="border-color: #03592c; background-color: #ffffff;">
                        ${optionsHtml}
                    </select>
                    <button type="button" class="btn btn-danger btn-sm removeAccountableBtn">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>`;

            $('#editContainer').append(selectGroup);
        },
        error: function () {
            console.error('Failed to fetch employees for program.');
        }
    });
});

$(document).on('click', '.removeAccountableBtn', function () {
    $(this).closest('.accountable-select-group').remove();
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
                url: '/admin/updateActivity',  // Your update URL
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // 👈 this will show the server error
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