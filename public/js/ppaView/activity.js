// Edit Activity Fill Form
let editActivityIdTarget;

$(document).on('click', '.editActivityBtnTarget', function () {
    var activityId = $(this).data('activity-id');
    var activityName = $(this).data('activity-name');
    var activitySuccessIndicator = $(this).data('activity-success');
    var activityQuality = $(this).data('activity-quality');
    var activityEfficiency = $(this).data('activity-efficiency');
    var activityTimeliness = $(this).data('activity-timeliness');
    var activityRemarks = $(this).data('activity-remarks');

    editActivityIdTarget = activityId;

    // Existing autofill for other fields...
    $('#editActivityId').val(editActivityIdTarget);
    $('#editActivityName').val(activityName);
    $('#editSuccessIndicatorActivity').val(activitySuccessIndicator);
    $('#editQualityActivity').val(activityQuality);
    $('#editEfficiencyActivity').val(activityEfficiency);
    $('#editTimelinessActivity').val(activityTimeliness);
    $('#editRemarksActivity').val(activityRemarks);

    // Clear previous selects
    const $editContainer = $('#editContainer');
    $editContainer.empty();

    $.ajax({
        url:  `/admin/activity/${editActivityIdTarget}/getActivityAccountables`,
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
    if (!editActivityIdTarget) return;

    $.ajax({
        url: `/admin/activity/${editActivityIdTarget}/fetchEmployee`,
        method: 'GET',
        success: function (employees) {
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