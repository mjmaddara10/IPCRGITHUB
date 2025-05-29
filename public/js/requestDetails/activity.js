// View details for activity ADD request including autofill individual/s responsible
$(document).off('click', '.viewAddActivityRequest').on('click', '.viewAddActivityRequest', function () {
    var activityId = $(this).data('activity-id');
    var programId = $(this).data('program-id');
    var activityName = $(this).data('activity-name');
    var activitySuccessIndicator = $(this).data('activity-success-indicator');
    var activityQuality = $(this).data('activity-quality');
    var activityEfficiency = $(this).data('activity-efficiency');
    var activityTimeliness = $(this).data('activity-timeliness');
    var activityRemarks = $(this).data('activity-remarks');
    var activityBudget = $(this).data('activity-budget');
    var employeeId = $(this).data('activity-employee-id');
    var requestor = $(this).data('activity-requestor');
    var employees = JSON.parse($(this).attr('data-activity-employees'));

    $('#addActivityIdRequest').val(activityId);
    $('#addActivityProgramId').val(programId);
    $('#deleteActivityIdAddRequest').val(activityId);
    $('#addActivityNameRequest').val(activityName);
    $('#addActivitySuccessIndicatorRequest').val(activitySuccessIndicator);
    $('#addActivityQualityRequest').val(activityQuality);
    $('#addActivityEfficiencyRequest').val(activityEfficiency);
    $('#addActivityTimelinessRequest').val(activityTimeliness);
    $('#addActivityRemarksRequest').val(activityRemarks);
    $('#addActivityBudgetRequest').val(activityBudget);
    $('#employeeView').val(employees);
    $('#employeeIdView').val(JSON.stringify(employeeId));
    $('#addActivityRequestor').val(requestor);

    // Clear old employees
    $('#employeeInputsContainer').empty();

    // Fetch employees via AJAX
    $.ajax({
        url: '/admin/activityRequests/' + activityId + '/employees',
        type: 'GET',
        success: function(employees) {
            if (employees.length > 0) {
                employees.forEach(function(employee) {
                    let middleInitial = employee.middleName 
                ? employee.middleName.charAt(0).toUpperCase() + '. ' 
                : '';

            let fullName = `${employee.firstName} ${middleInitial}${employee.lastName}`;

                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${fullName}" readonly>
                                 </div>`;
                    $('#employeeInputsContainer').append(input);
                });
            } else {
                $('#employeeInputsContainer').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#employeeInputsContainer').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });
});

// View details for activity EDIT request including autofill individual/s responsible
$(document).off('click', '.viewEditActivityRequest').on('click', '.viewEditActivityRequest', function () {
    var activityId = $(this).data('activity-id');
    var activityName = $(this).data('activity-name');
    var activitySuccessIndicator = $(this).data('activity-success-indicator');
    var activityQuality = $(this).data('activity-quality');
    var activityEfficiency = $(this).data('activity-efficiency');
    var activityTimeliness = $(this).data('activity-timeliness');
    var activityRemarks = $(this).data('activity-remarks');
    var activityBudget = $(this).data('activity-budget');
    var employeeId = $(this).data('activity-employee-id');
    var requestor = $(this).data('activity-requestor');
    var reference = $(this).data('reference-activity');
    var employees = JSON.parse($(this).attr('data-activity-employees'));

    $('#editActivityIdRequest').val(activityId);
    $('#deleteActivityIdEditRequest').val(activityId);
    $('#editActivityNameRequest').val(activityName);
    $('#editActivitySuccessIndicatorRequest').val(activitySuccessIndicator);
    $('#editActivityQualityRequest').val(activityQuality);
    $('#editActivityEfficiencyRequest').val(activityEfficiency);
    $('#editActivityTimelinessRequest').val(activityTimeliness);
    $('#editActivityRemarksRequest').val(activityRemarks);
    $('#editActivityBudgetRequest').val(activityBudget);
    $('#employeeViewEditActivity').val(employees);
    $('#editActivityRequestor').val(requestor);
    $('#editActivityReference').val(reference);
    $('#employeeIdViewEditActivity').val(JSON.stringify(employeeId));

    // Clear old employees
    $('#individualInputsContainerEditActivity').empty();
    $('#currentActivityIndividualContainer').empty();

    // Fetch employees via AJAX
    $.ajax({
        url: '/admin/activityRequests/' + activityId + '/employees',
        type: 'GET',
        success: function(employees) {
            
            if (employees.length > 0) {
                employees.forEach(function(employee) {
                    let middleInitial = employee.middleName 
                ? employee.middleName.charAt(0).toUpperCase() + '. ' 
                : '';

                let fullName = `${employee.firstName} ${middleInitial}${employee.lastName}`;
            

                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${fullName}" readonly>
                                 </div>`;
                    $('#individualInputsContainerEditActivity').append(input);
                });
            } else {
                $('#individualInputsContainerEditActivity').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#individualInputsContainerEditActivity').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });

    // Fetch reference employees
    $.ajax({
        url: '/admin/activity/' + reference + '/employees',
        type: 'GET',
        success: function(employees) {
            if (employees.length > 0) {
                employees.forEach(function(employee) {
                    let middleInitial = employee.middleName 
                ? employee.middleName.charAt(0).toUpperCase() + '. ' 
                : '';

                let fullName = `${employee.firstName} ${middleInitial}${employee.lastName}`;
            

                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${fullName}" readonly>
                                 </div>`;
                    $('#currentActivityIndividualContainer').append(input);
                });
            } else {
                $('#currentActivityIndividualContainer').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#currentActivityIndividualContainer').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });

    // Fetch reference activity details using the reference ID
    $.ajax({
        url: '/admin/fetchReferenceActivityDetails/' + reference,
        type: 'GET',
        success: function(activity) {
            $('#existingActivityName').val(activity.name);
            $('#existingActivitySuccessIndicator').val(activity.successIndicator);
            $('#existingActivityQuality').val(activity.quality);
            $('#existingActivityEfficiency').val(activity.efficiency);
            $('#existingActivityTimeliness').val(activity.timeliness);
            $('#existingActivityRemarks').val(activity.remarks);
            $('#existingActivityBudget').val(activity.budget);
        },
        error: function() {
            console.error('Failed to fetch existing activity data');
        }
    });
});

// View details for activity DELETE request including autofill division/s responsible
$(document).off('click', '.viewDeleteActivityRequest').on('click', '.viewDeleteActivityRequest', function () {
    var activityId = $(this).data('activity-id');
    var activityName = $(this).data('activity-name');
    var activitySuccessIndicator = $(this).data('activity-success-indicator');
    var activityQuality = $(this).data('activity-quality');
    var activityEfficiency = $(this).data('activity-efficiency');
    var activityTimeliness = $(this).data('activity-timeliness');
    var activityRemarks = $(this).data('activity-remarks');
    var activityBudget = $(this).data('activity-budget');
    var employeeId = $(this).data('activity-employee-id');
    var requestor = $(this).data('activity-requestor');
    var reference = $(this).data('reference-activity');
    var employees = JSON.parse($(this).attr('data-activity-employees'));

    $('#deleteActivityIdRequest').val(activityId);
    $('#deleteActivityIdDeleteRequest').val(activityId);
    $('#deleteActivityNameRequest').val(activityName);
    $('#deleteActivitySuccessIndicatorRequest').val(activitySuccessIndicator);
    $('#deleteActivityQualityRequest').val(activityQuality);
    $('#deleteActivityEfficiencyRequest').val(activityEfficiency);
    $('#deleteActivityTimelinessRequest').val(activityTimeliness);
    $('#deleteActivityRemarksRequest').val(activityRemarks);
    $('#deleteActivityBudgetRequest').val(activityBudget);
    $('#employeeViewDeleteActivity').val(employees);
    $('#deleteActivityRequestor').val(requestor);
    $('#deleteActivityReference').val(reference);
    $('#employeeIdViewDeleteActivity').val(JSON.stringify(employeeId));

    // Clear old employees
    $('#employeeInputsContainerDeleteActivity').empty();

    // Fetch employees
    $.ajax({
        url: '/admin/activity/' + reference + '/employees',
        type: 'GET',
        success: function(employees) {
            if (employees.length > 0) {
                employees.forEach(function(employee) {
                    let middleInitial = employee.middleName 
                ? employee.middleName.charAt(0).toUpperCase() + '. ' 
                : '';

                let fullName = `${employee.firstName} ${middleInitial}${employee.lastName}`;
            

                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${fullName}" readonly>
                                 </div>`;
                    $('#employeeInputsContainerDeleteActivity').append(input);
                });
            } else {
                $('#employeeInputsContainerDeleteActivity').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#employeeInputsContainerDeleteActivity').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });
});