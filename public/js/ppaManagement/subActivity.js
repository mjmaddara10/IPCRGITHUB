// Add Sub-Activity Fill Form
$(document).on('click', '.addSubActivityBtn', function() {
    // Get data from the button clicked
    var activityIdSub = $(this).data('activity-id');
    var activityNameSub = $(this).data('activity-name');
    var divisionIdsRaw = $(this).data('division-ids');
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

    // Populate the modal fields with the data
    $('#activityIdSub').val(activityIdSub);
    $('#activityNameSub').val(activityNameSub);

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
            $select.append(`<option value="${accountable.id}">${accountable.name} | ${accountable.position}</option>`);
        });
    });
}

// Add accountable person input
$('#addsAccountablePersonBtn').on('click', function () {
    const $container = $('#accountableSelectContainerSubAct');
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
                url: '/admin/addSubActivity',
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
let subActivityId; 

$(document).on('click', '.editSubActivityBtn', function() {
    // Get data from the button clicked
    subActivityId = $(this).data('sub-activity-id');
    var subActivityName = $(this).data('sub-activity-name');
    var successIndicator = $(this).data('success-indicator');
    var quality = $(this).data('quality');
    var efficiency = $(this).data('efficiency');
    var timeliness = $(this).data('timeliness');
    var remarks = $(this).data('remarks');

    // Populate the modal fields with the data
    $('#editActivityIdSub').val(subActivityId);
    $('#editActivityNameSub').val(subActivityName);
    $('#editSuccessIndicatorSub').val(successIndicator);
    $('#editQualitySub').val(quality);
    $('#editEfficiencySub').val(efficiency);
    $('#editTimelinessSub').val(timeliness);
    $('#editRemarksSub').val(remarks);

    // Clear previous selects
    const $editContainerSub = $('#editContainerSub');
    $editContainerSub.empty();

    $.ajax({
        url:  `/admin/subActivity/${subActivityId}/getSubActivityAccountables`,
        method: 'GET',
        success: function (response) {
            response.forEach(function (person, index) {
                const isFirst = index === 0;
                const selectGroup = `
                    <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                        <select class="form-select border-2 py-2 editAccountableSelect" name="editAccountableId[]" style="border-color: #03592c; background-color: #ffffff;">
                            <option value="${person.id}" selected>${person.name} | ${person.position}</option>
                        </select>
                        <button type="button" class="btn btn-danger btn-sm removeAccountableBtn" ${isFirst ? 'disabled' : ''}>
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>`;
                $editContainerSub.append(selectGroup);
            });
        },
        error: function () {
            console.error('Failed to fetch individuals responsible.');
        }
    });
});

$('#addAccountableEditSubBtn').on('click', function () {
    if (!subActivityId) return;

    $.ajax({
        url: `/admin/subActivity/${subActivityId}/fetchEmployeeSub`,
        method: 'GET',
        success: function (employees) {
            console.log(employees);
            let optionsHtml = employees.map(e =>
                `<option value="${e.id}">${e.name} | ${e.position}</option>`
            ).join('');

            const selectGroup = `
                <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                    <select class="form-select border-2 py-2 editAccountableSelect" name="editAccountableId[]" style="border-color: #03592c; background-color: #ffffff;">
                        ${optionsHtml}
                    </select>
                    <button type="button" class="btn btn-danger btn-sm removeAccountableBtn">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>`;

            $('#editContainerSub').append(selectGroup);
        },
        error: function () {
            console.error('Failed to fetch employees for program.');
        }
    });
});

$(document).on('click', '.removeAccountableBtn', function () {
    $(this).closest('.accountable-select-group').remove();
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

$(document).on('click', '.deleteSubActivityBtn', function(e) {
    e.preventDefault();

    var subActivityId = $(this).data('subActivity-id');
    var deleteUrl  = $(this).data('url');
    console.log(subActivityId);

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
            // Make an AJAX request to delete the activity
            $.ajax({
                url: deleteUrl,  // Your delete URL
                method: 'POST',
                data: {
                    subActivityId: subActivityId // Pass the activity ID
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