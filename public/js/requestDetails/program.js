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

    $('#addProgramIdRequest').val(programId);
    $('#addProgramNameRequest').val(programName);
    $('#addProgramSuccessIndicatorRequest').val(programSuccessIndicator);
    $('#addProgramQualityRequest').val(programQuality);
    $('#addProgramEfficiencyRequest').val(programEfficiency);
    $('#addProgramTimelinessRequest').val(programTimeliness);
    $('#addProgramRemarksRequest').val(programRemarks);
    $('#addProgramBudgetRequest').val(programBudget);

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