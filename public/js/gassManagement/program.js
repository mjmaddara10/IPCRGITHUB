// ============================Functionalities=========================//
// Utility: Add a division select with optional selected value
function handleAllDivisionsLogic() {
    const $container = $('#editGassDivisionSelectContainer');
    const $selects = $container.find('select');

    let hasAll = false;
    let $allSelectGroup = null;

    $selects.each(function () {
        if ($(this).val()?.toString() === 'all') {
            hasAll = true;
            $allSelectGroup = $(this).closest('.division-select-group');
            return false;
        }
    });

    if (hasAll) {
        $container.find('.division-select-group').each(function () {
            if (this !== $allSelectGroup.get(0)) {
                $(this).hide();
            }
        });
    } else {
        $container.find('.division-select-group').show();
    }
}

function addGassDivisionSelect(selectedId = null) {
    let allDivisions = $('#editGassDivisionSelectContainer').data('divisions');
    let selectHtml = `
    <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
        <select class="form-select border border-success" name="divisions[]">`;

    allDivisions.forEach(div => {
        const isSelected = div.id === selectedId ? 'selected' : '';
        selectHtml += `<option value="${div.id}" ${isSelected}>${div.name}</option>`;
    });

    const allSelected = selectedId === 'all' ? 'selected' : '';
    selectHtml += `<option value="all" ${allSelected}>All Divisions</option>`;

    selectHtml += `</select>
        <button type="button" class="btn btn-danger btn-sm removeDivisionBtn">
            <i class="fas fa-minus"></i>
        </button>
    </div>`;

    $('#editGassDivisionSelectContainer').append(selectHtml);
}

// Utility: Disable first remove button
function updateRemoveButtonsForGassDivisions() {
    const removeBtns = $('#editGassDivisionSelectContainer .removeDivisionBtn');
    removeBtns.prop('disabled', false);
    removeBtns.first().prop('disabled', true);
}

// Utility: Disable already selected divisions
function updateDivisionOptionsForGassDivisions() {
    const $container = $('#editGassDivisionSelectContainer');
    const $selects = $container.find('select');

    $selects.each(function () {
        const $currentSelect = $(this);
        const currentVal = $currentSelect.val();

        const selectedValues = $selects
            .not($currentSelect)
            .map(function () {
                return $(this).val()?.toString();
            })
            .get();

        $currentSelect.find('option').each(function () {
            const $option = $(this);
            const optionVal = $option.val()?.toString();

            if (optionVal === 'all') {
                $option.prop('disabled', false);
                return;
            }

            $option.prop('disabled', selectedValues.includes(optionVal));
        });
    });
}

// Add new select input
$(document).off('click', '#editGassAddDivisionBtn').on('click', '#editGassAddDivisionBtn', function () {
    addGassDivisionSelect();
    updateRemoveButtonsForGassDivisions();
    updateDivisionOptionsForGassDivisions();
    handleAllDivisionsLogic();
});

// Remove division row
$(document).on('click', '.removeDivisionBtn', function () {
    $(this).closest('.division-select-group').remove();
    updateRemoveButtonsForGassDivisions();
    updateDivisionOptionsForGassDivisions();
    handleAllDivisionsLogic();
});

// Change division selection
$(document).on('change', '#editGassDivisionSelectContainer select', function () {
    updateDivisionOptionsForGassDivisions();
    handleAllDivisionsLogic();
});
// ============================Functionalities=========================//

// Edit GASS Fill Form
$(document).off('click', '.editGassBtn').on('click', '.editGassBtn', function () {
    var gassId = $(this).data('gass-id');
    var gassName = $(this).data('gass-name');
    var gassBudget = $(this).data('gass-budget');

    $('#editGassId').val(gassId);
    $('#editGassName').val(gassName);
    $('#editGassBudget').val(gassBudget);
});

// Edit GASS
$('#editGassForm').on('submit', function(e) {
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
                url: '/admin/updateGass',  // Your update URL
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

// Edit GASS Program Fill Form
$(document).off('click', '.editGassProgramBtn').on('click', '.editGassProgramBtn', function () {
    var gassId = $(this).data('program-id');
    var gassName = $(this).data('program-name');
    var gassSuccessIndicator = $(this).data('program-success');
    var gassQuality = $(this).data('program-quality');
    var gassEfficiency = $(this).data('program-efficiency');
    var gassTimeliness = $(this).data('program-timeliness');
    var gassRemarks = $(this).data('program-remarks');

    $('#editGassProgramId').val(gassId);
    $('#editGassProgramName').val(gassName);
    $('#editGassProgramSuccessIndicator').val(gassSuccessIndicator);
    $('#editGassProgramQuality').val(gassQuality);
    $('#editGassProgramEfficiency').val(gassEfficiency);
    $('#editGassProgramTimeliness').val(gassTimeliness);
    $('#editGassProgramRemarks').val(gassRemarks);

    $('#editGassDivisionSelectContainer').empty();

    $.get(`/admin/programs/${gassId}/getDivisionResponsible`, function (assignedDivisions) {
        assignedDivisions.forEach((assignedDiv) => {
            addGassDivisionSelect(assignedDiv.id);
        });

        if (assignedDivisions.length === 0) {
            addGassDivisionSelect();
        }

        updateRemoveButtonsForGassDivisions();
        updateDivisionOptionsForGassDivisions();
    });
});

// Edit GASS Program
$('#editGassProgramForm').on('submit', function(e) {
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
                url: '/admin/updateGassProgram',  // Your update URL
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

// Add GASS Program
$('#addGassProgramForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

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
                url: '/admin/addGassProgram',
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Handle success response (close the modal and give feedback)
                    Swal.fire({
                        title: 'Success!',
                        text: 'Program added successfully.',
                        icon: 'success',
                        confirmButtonColor: '#03592c'
                    }).then(() => {
                        $('#addProgramModal').modal('hide'); // Close the modal
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