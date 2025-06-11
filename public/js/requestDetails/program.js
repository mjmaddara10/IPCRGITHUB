// View details for program ADD request including autofill division/s responsible
$(document).off('click', '.viewAddProgramRequest').on('click', '.viewAddProgramRequest', function () {
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success-indicator');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');
    var programBudget = $(this).data('program-budget');
    var divisionId = $(this).data('program-division-id');
    var requestor = $(this).data('program-requestor');
    var divisions = JSON.parse($(this).attr('data-program-divisions'));

    $('#addProgramIdRequest').val(programId);
    $('#deleteProgramIdAddRequest').val(programId);
    $('#addProgramNameRequest').val(programName);
    $('#addProgramSuccessIndicatorRequest').val(programSuccessIndicator);
    $('#addProgramQualityRequest').val(programQuality);
    $('#addProgramEfficiencyRequest').val(programEfficiency);
    $('#addProgramTimelinessRequest').val(programTimeliness);
    $('#addProgramRemarksRequest').val(programRemarks);
    $('#addProgramBudgetRequest').val(programBudget);
    $('#divisionView').val(divisions);
    $('#divisionIdView').val(JSON.stringify(divisionId));
    $('#addProgramRequestor').val(requestor);

    // Clear old divisions
    $('#divisionInputsContainer').empty();

    // Fetch divisions via AJAX
    $.ajax({
        url: '/admin/programRequests/' + programId + '/divisions',
        type: 'GET',
        success: function(divisions) {
            if (divisions.length > 0) {
                divisions.forEach(function(division) {
                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${division.name}" readonly>
                                 </div>`;
                    $('#divisionInputsContainer').append(input);
                });
            } else {
                $('#divisionInputsContainer').append(`<p class="text-muted">No divisions assigned.</p>`);
            }
        },
        error: function() {
            $('#divisionInputsContainer').append(`<p class="text-danger">Failed to load divisions.</p>`);
        }
    });
});

// View details for program EDIT request including autofill division/s responsible
$(document).off('click', '.viewEditProgramRequest').on('click', '.viewEditProgramRequest', function () {
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success-indicator');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');
    var programBudget = $(this).data('program-budget');
    var divisionId = $(this).data('program-division-id');
    var requestor = $(this).data('program-requestor');
    var reference = $(this).data('reference-program');
    var divisions = JSON.parse($(this).attr('data-program-divisions'));

    $('#editProgramIdRequest').val(programId);
    $('#deleteProgramIdEditRequest').val(programId);
    $('#editProgramNameRequest').val(programName);
    $('#editProgramSuccessIndicatorRequest').val(programSuccessIndicator);
    $('#editProgramQualityRequest').val(programQuality);
    $('#editProgramEfficiencyRequest').val(programEfficiency);
    $('#editProgramTimelinessRequest').val(programTimeliness);
    $('#editProgramRemarksRequest').val(programRemarks);
    $('#editProgramBudgetRequest').val(programBudget);
    $('#divisionViewEditProgram').val(divisions);
    $('#editProgramRequestor').val(requestor);
    $('#editProgramReference').val(reference);
    $('#divisionIdViewEditProgram').val(JSON.stringify(divisionId));

    // Clear old divisions
    $('#divisionInputsContainerEditProgram').empty();
    $('#currentProgramDivisionsContainer').empty();

    // Fetch divisions via AJAX
    $.ajax({
        url: '/admin/programRequests/' + programId + '/divisions',
        type: 'GET',
        success: function(divisions) {
            if (divisions.length > 0) {
                divisions.forEach(function(division) {
                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${division.name}" readonly>
                                 </div>`;
                    $('#divisionInputsContainerEditProgram').append(input);
                });
            } else {
                $('#divisionInputsContainerEditProgram').append(`<p class="text-muted">No divisions assigned.</p>`);
            }
        },
        error: function() {
            $('#divisionInputsContainerEditProgram').append(`<p class="text-danger">Failed to load divisions.</p>`);
        }
    });

    // Fetch reference divisions
    $.ajax({
        url: '/admin/program/' + reference + '/divisions',
        type: 'GET',
        success: function(divisions) {
            if (divisions.length > 0) {
                divisions.forEach(function(division) {
                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${division.name}" readonly>
                                 </div>`;
                    $('#currentProgramDivisionsContainer').append(input);
                });
            } else {
                $('#currentProgramDivisionsContainer').append(`<p class="text-muted">No divisions assigned.</p>`);
            }
        },
        error: function() {
            $('#currentProgramDivisionsContainer').append(`<p class="text-danger">Failed to load divisions.</p>`);
        }
    });

    

    // Fetch reference program details using the reference ID
    $.ajax({
        url: '/admin/fetchReferenceProgramDetails/' + reference,
        type: 'GET',
        success: function(program) {
            $('#existingProgramName').val(program.name);
            $('#existingProgramSuccessIndicator').val(program.successIndicator);
            $('#existingProgramQuality').val(program.quality);
            $('#existingProgramEfficiency').val(program.efficiency);
            $('#existingProgramTimeliness').val(program.timeliness);
            $('#existingProgramRemarks').val(program.remarks);
            $('#existingProgramBudget').val(program.budget);
        },
        error: function() {
            console.error('Failed to fetch existing program data');
        }
    });
});

// View details for program DELETE request including autofill division/s responsible
$(document).off('click', '.viewDeleteProgramRequest').on('click', '.viewDeleteProgramRequest', function () {
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success-indicator');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');
    var programBudget = $(this).data('program-budget');
    var divisionId = $(this).data('program-division-id');
    var requestor = $(this).data('program-requestor');
    var reference = $(this).data('reference-program');
    var divisions = JSON.parse($(this).attr('data-program-divisions'));

    $('#deleteProgramIdRequest').val(programId);
    $('#deleteProgramIdDeleteRequest').val(programId);
    $('#deleteProgramNameRequest').val(programName);
    $('#deleteProgramSuccessIndicatorRequest').val(programSuccessIndicator);
    $('#deleteProgramQualityRequest').val(programQuality);
    $('#deleteProgramEfficiencyRequest').val(programEfficiency);
    $('#deleteProgramTimelinessRequest').val(programTimeliness);
    $('#deleteProgramRemarksRequest').val(programRemarks);
    $('#deleteProgramBudgetRequest').val(programBudget);
    $('#divisionViewDeleteProgram').val(divisions);
    $('#deleteProgramRequestor').val(requestor);
    $('#deleteProgramReference').val(reference);
    $('#divisionIdViewDeleteProgram').val(JSON.stringify(divisionId));

    // Clear old divisions
    $('#divisionInputsContainerDeleteProgram').empty();

    // Fetch divisions
    $.ajax({
        url: '/admin/program/' + reference + '/divisions',
        type: 'GET',
        success: function(divisions) {
            if (divisions.length > 0) {
                divisions.forEach(function(division) {
                    var input = `<div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control form-control-sm border-2" 
                                           style="border-color: #03592c; background-color: #ffffff; width: 30%;" 
                                           value="${division.name}" readonly>
                                 </div>`;
                    $('#divisionInputsContainerDeleteProgram').append(input);
                });
            } else {
                $('#divisionInputsContainerDeleteProgram').append(`<p class="text-muted">No divisions assigned.</p>`);
            }
        },
        error: function() {
            $('#divisionInputsContainerDeleteProgram').append(`<p class="text-danger">Failed to load divisions.</p>`);
        }
    });
});