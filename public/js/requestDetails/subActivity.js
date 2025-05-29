// View details for sub-activity ADD request including autofill individual/s responsible
$(document).off('click', '.viewAddSubActivityRequest').on('click', '.viewAddSubActivityRequest', function () {
    var subActivityId = $(this).data('sub-activity-id');
    var activityId = $(this).data('activity-id');
    var subActivityName = $(this).data('sub-activity-name');
    var subActivitySuccessIndicator = $(this).data('sub-activity-success-indicator');
    var subActivityQuality = $(this).data('sub-activity-quality');
    var subActivityEfficiency = $(this).data('sub-activity-efficiency');
    var subActivityTimeliness = $(this).data('sub-activity-timeliness');
    var subActivityRemarks = $(this).data('sub-activity-remarks');
    var employeeId = $(this).data('sub-activity-employee-id');
    var requestor = $(this).data('sub-activity-requestor');
    var employees = JSON.parse($(this).attr('data-sub-activity-employees'));

    $('#addSubActivityIdRequest').val(subActivityId);
    $('#addParentActivityId').val(activityId);
    $('#deleteSubActivityIdAddRequest').val(subActivityId);
    $('#addSubActivityNameRequest').val(subActivityName);
    $('#addSubActivitySuccessIndicatorRequest').val(subActivitySuccessIndicator);
    $('#addSubActivityQualityRequest').val(subActivityQuality);
    $('#addSubActivityEfficiencyRequest').val(subActivityEfficiency);
    $('#addSubActivityTimelinessRequest').val(subActivityTimeliness);
    $('#addSubActivityRemarksRequest').val(subActivityRemarks);
    $('#employeeViewSub').val(employees);
    $('#employeeIdViewSub').val(JSON.stringify(employeeId));
    $('#addSubActivityRequestor').val(requestor);

    // Clear old employees
    $('#employeeInputsContainerSub').empty();

    // Fetch employees via AJAX
    $.ajax({
        url: '/admin/subActivityRequests/' + subActivityId + '/employees',
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
                    $('#employeeInputsContainerSub').append(input);
                });
            } else {
                $('#employeeInputsContainerSub').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#employeeInputsContainerSub').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });
});

// View details for sub-activity EDIT request including autofill individual/s responsible
$(document).off('click', '.viewEditSubActivityRequest').on('click', '.viewEditSubActivityRequest', function () {
    var subActivityId = $(this).data('sub-activity-id');
    var subActivityName = $(this).data('sub-activity-name');
    var subActivitySuccessIndicator = $(this).data('sub-activity-success-indicator');
    var subActivityQuality = $(this).data('sub-activity-quality');
    var subActivityEfficiency = $(this).data('sub-activity-efficiency');
    var subActivityTimeliness = $(this).data('sub-activity-timeliness');
    var subActivityRemarks = $(this).data('sub-activity-remarks');
    var subActivityBudget = $(this).data('sub-activity-budget');
    var employeeId = $(this).data('sub-activity-employee-id');
    var requestor = $(this).data('sub-activity-requestor');
    var reference = $(this).data('reference-sub-activity');
    var employees = JSON.parse($(this).attr('data-sub-activity-employees'));

    $('#editSubActivityIdRequest').val(subActivityId);
    $('#deleteSubActivityIdEditRequest').val(subActivityId);
    $('#editSubActivityNameRequest').val(subActivityName);
    $('#editSubActivitySuccessIndicatorRequest').val(subActivitySuccessIndicator);
    $('#editSubActivityQualityRequest').val(subActivityQuality);
    $('#editSubActivityEfficiencyRequest').val(subActivityEfficiency);
    $('#editSubActivityTimelinessRequest').val(subActivityTimeliness);
    $('#editSubActivityRemarksRequest').val(subActivityRemarks);
    $('#editSubActivityBudgetRequest').val(subActivityBudget);
    $('#employeeViewEditSubActivity').val(employees);
    $('#editSubActivityRequestor').val(requestor);
    $('#editSubActivityReference').val(reference);
    $('#employeeIdViewEditSubActivity').val(JSON.stringify(employeeId));

    // Clear old employees
    $('#individualInputsContainerEditSubActivity').empty();
    $('#currentSubActivityIndividualContainer').empty();

    // Fetch employees via AJAX
    $.ajax({
        url: '/admin/subActivityRequests/' + subActivityId + '/employees',
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
                    $('#individualInputsContainerEditSubActivity').append(input);
                });
            } else {
                $('#individualInputsContainerEditSubActivity').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#individualInputsContainerEditSubActivity').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });

    // Fetch reference employees
    $.ajax({
        url: '/admin/subActivity/' + reference + '/employees',
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
                    $('#currentSubActivityIndividualContainer').append(input);
                });
            } else {
                $('#currentSubActivityIndividualContainer').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#currentSubActivityIndividualContainer').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });

    // Fetch reference sub-activity details using the reference ID
    $.ajax({
        url: '/admin/fetchReferenceSubActivityDetails/' + reference,
        type: 'GET',
        success: function(subActivity) {
            $('#existingSubActivityName').val(subActivity.name);
            $('#existingSubActivitySuccessIndicator').val(subActivity.successIndicator);
            $('#existingSubActivityQuality').val(subActivity.quality);
            $('#existingSubActivityEfficiency').val(subActivity.efficiency);
            $('#existingSubActivityTimeliness').val(subActivity.timeliness);
            $('#existingSubActivityRemarks').val(subActivity.remarks);
            $('#existingSubActivityBudget').val(subActivity.budget);
        },
        error: function() {
            console.error('Failed to fetch existing sub-activity data');
        }
    });
});

// View details for sub-activity DELETE request including autofill division/s responsible
$(document).off('click', '.viewDeleteSubActivityRequest').on('click', '.viewDeleteSubActivityRequest', function () {
    var subActivityId = $(this).data('sub-activity-id');
    var subActivityName = $(this).data('sub-activity-name');
    var subActivitySuccessIndicator = $(this).data('sub-activity-success-indicator');
    var subActivityQuality = $(this).data('sub-activity-quality');
    var subActivityEfficiency = $(this).data('sub-activity-efficiency');
    var subActivityTimeliness = $(this).data('sub-activity-timeliness');
    var subActivityRemarks = $(this).data('sub-activity-remarks');
    var employeeId = $(this).data('sub-activity-employee-id');
    var requestor = $(this).data('sub-activity-requestor');
    var reference = $(this).data('reference-sub-activity');
    var employees = JSON.parse($(this).attr('data-sub-activity-employees'));

    console.log(employees);

    $('#deleteSubActivityIdRequest').val(subActivityId);
    $('#deleteSubActivityIdDeleteRequest').val(subActivityId);
    $('#deleteSubActivityNameRequest').val(subActivityName);
    $('#deleteSubActivitySuccessIndicatorRequest').val(subActivitySuccessIndicator);
    $('#deleteSubActivityQualityRequest').val(subActivityQuality);
    $('#deleteSubActivityEfficiencyRequest').val(subActivityEfficiency);
    $('#deleteSubActivityTimelinessRequest').val(subActivityTimeliness);
    $('#deleteSubActivityRemarksRequest').val(subActivityRemarks);
    $('#employeeViewDeleteSubActivity').val(employees);
    $('#deleteSubActivityRequestor').val(requestor);
    $('#deleteSubActivityReference').val(reference);
    $('#employeeIdViewDeleteSubActivity').val(JSON.stringify(employeeId));

    // Clear old employees
    $('#employeeInputsContainerDeleteSubActivity').empty();

    // Fetch employees
    $.ajax({
        url: '/admin/subActivity/' + reference + '/employees',
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
                    $('#employeeInputsContainerDeleteSubActivity').append(input);
                });
            } else {
                $('#employeeInputsContainerDeleteSubActivity').append(`<p class="text-muted">No employees assigned.</p>`);
            }
        },
        error: function() {
            $('#employeeInputsContainerDeleteSubActivity').append(`<p class="text-danger">Failed to load employees.</p>`);
        }
    });
});