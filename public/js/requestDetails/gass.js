// View details for GASS EDIT request
$(document).off('click', '.viewGassRequest').on('click', '.viewGassRequest', function () {
    var requestId = $(this).data('request-id');
    var gassBudget = $(this).data('gass-budget');
    var requestor = $(this).data('gass-requestor');
    var referenceId = $(this).data('reference-id');
    var referenceName = $(this).data('reference-name');
    var referenceBudget = $(this).data('reference-budget');

    $('#editGassName').val(referenceName);
    $('#existingGassBudget').val(referenceBudget);
    $('#editGassBudget').val(gassBudget);
    $('#editGassRequestor').val(requestor);
    $('#editGassRequestId').val(requestId);
    $('#editGassDisapproveRequestId').val(requestId);
    $('#editGassReferenceId').val(referenceId);
});

// View details for GASS Critical Activity ADD request including autofill division/s responsible
$(document).off('click', '.viewAddGassCritRequest').on('click', '.viewAddGassCritRequest', function () {
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success-indicator');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');
    var divisionId = $(this).data('program-division-id');
    var requestor = $(this).data('program-requestor');
    var divisions = JSON.parse($(this).attr('data-program-divisions'));

    $('#addGassCritRequestId').val(programId);
    $('#addGassCritRequestIdDisapprove').val(programId);
    $('#AddGassCritNameRequest').val(programName);
    $('#AddGassCritSuccessIndicatorRequest').val(programSuccessIndicator);
    $('#AddGassCritQualityRequest').val(programQuality);
    $('#AddGassCritEfficiencyRequest').val(programEfficiency);
    $('#AddGassCritTimelinessRequest').val(programTimeliness);
    $('#AddGassCritRemarksRequest').val(programRemarks);
    $('#divisionViewAddGassCrit').val(divisions);
    $('#divisionIdViewAddGassCrit').val(JSON.stringify(divisionId));
    $('#addGassCritRequestor').val(requestor);

    // Clear old divisions
    $('#divisionInputsContainerAddGassCrit').empty();

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
                    $('#divisionInputsContainerAddGassCrit').append(input);
                });
            } else {
                $('#divisionInputsContainerAddGassCrit').append(`<p class="text-muted">No divisions assigned.</p>`);
            }
        },
        error: function() {
            $('#divisionInputsContainerAddGassCrit').append(`<p class="text-danger">Failed to load divisions.</p>`);
        }
    });
});