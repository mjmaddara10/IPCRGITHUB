// Add Program
$('#addProgramForm').on('submit', function(e) {
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
                url: '/admin/addProgram',
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

// Edit Program Fill Form
// Utility: Add a division select with optional selected value
function addDivisionSelect(selectedId = null) {
    let allDivisions = $('#editDivisionSelectContainer').data('divisions');
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

    $('#editDivisionSelectContainer').append(selectHtml);
}

// Utility: Disable first remove button
function updateRemoveButtons() {
    const removeBtns = $('#editDivisionSelectContainer .removeDivisionBtn');
    removeBtns.prop('disabled', false);
    removeBtns.first().prop('disabled', true);
}

// Utility: Disable already selected divisions
function updateDivisionOptions() {
    const $container = $('#editDivisionSelectContainer');
    const $selects = $container.find('select');

    $selects.each(function () {
        const $currentSelect = $(this);
        const currentVal = $currentSelect.val();

        const selectedValues = $selects
            .not($currentSelect)
            .map(function () {
                return $(this).val();
            })
            .get();

        $currentSelect.find('option').each(function () {
            const $option = $(this);
            const optionVal = $option.val();

            if (optionVal === 'all') {
                $option.prop('disabled', false);
                return;
            }

            $option.prop('disabled', selectedValues.includes(optionVal));
        });
    });
}

// Main click handler
$(document).off('click', '.editProgramBtnTarget').on('click', '.editProgramBtnTarget', function () {
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');
    var programBudget = $(this).data('program-budget');

    $('#editProgramId').val(programId);
    $('#editProgramName').val(programName);
    $('#editSuccessIndicator').val(programSuccessIndicator);
    $('#editQuality').val(programQuality);
    $('#editEfficiency').val(programEfficiency);
    $('#editTimeliness').val(programTimeliness);
    $('#editRemarks').val(programRemarks);
    $('#editBudget').val(programBudget);

    $('#editDivisionSelectContainer').empty();

    $.get(`/admin/programs/${programId}/getDivisionResponsible`, function (assignedDivisions) {
        assignedDivisions.forEach((assignedDiv) => {
            addDivisionSelect(assignedDiv.id);
        });

        if (assignedDivisions.length === 0) {
            addDivisionSelect();
        }

        updateRemoveButtons();
        updateDivisionOptions();
    });
});

// Add new select input
$(document).off('click', '#editAddDivisionBtn').on('click', '#editAddDivisionBtn', function () {
    addDivisionSelect();
    updateRemoveButtons();
    updateDivisionOptions();
    // handleAllDivisionsLogic();
});

// Remove division row
$(document).on('click', '.removeDivisionBtn', function () {
    $(this).closest('.division-select-group').remove();
    updateRemoveButtons();
    updateDivisionOptions();
    // handleAllDivisionsLogic();
});

// Change division selection
$(document).on('change', '#editDivisionSelectContainer select', function () {
    updateDivisionOptions();
    // handleAllDivisionsLogic();
});

// Edit Program
$('#editProgramForm').on('submit', function(e) {
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
                url: '/admin/updateProgram',  // Your update URL
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

// Delete Program
$(document).on('click', '.deleteProgramBtnTarget', function(e) {
    e.preventDefault();

    var programId = $(this).data('program-id');

    Swal.fire({
        title: "Are you sure?",
        html: "Do you want to delete this?<br><strong>All activities under it will also be deleted.</strong>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Confirm"
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX request to delete the project
            $.ajax({
                url: '/admin/deleteProgram',  // Your delete URL
                method: 'POST',
                data: {
                    programId: programId // Pass the project ID
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token in the headers
                },
                success: function(response) {
                    // Show success Swal alert
                    Swal.fire({
                        title: 'Project deleted',
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

// Add more division in adding program
document.addEventListener('DOMContentLoaded', function () {
    const divisionContainer = document.getElementById('divisionSelectContainer');
    const addDivisionBtn = document.getElementById('addDivisionBtn');
    const savedDivisionId = localStorage.getItem('selectedDivisionId');
    const select = document.getElementById('divisionFilter');

    if (savedDivisionId && select) {
        select.value = savedDivisionId;

        // Trigger the change event manually to reapply the filter
        const event = new Event('change');
        select.dispatchEvent(event);
    }

    // Check if "All Divisions" is selected in any select input
    function isAllDivisionsSelected() {
        return [...divisionContainer.querySelectorAll('.selectDivision')].some(select => select.value === 'all');
    }

    // Remove all select groups except the first
    function removeExtraSelects() {
        const allSelectGroups = divisionContainer.querySelectorAll('.division-select-group');
        allSelectGroups.forEach((group, index) => {
            if (index > 0) group.remove();
        });
    }

    // Reset to only one select if "All Divisions" is selected
    function resetToAllDivisions() {
        divisionContainer.innerHTML = ''; // Clear all
        const divisions = JSON.parse(divisionContainer.getAttribute('data-divisions'));

        let optionsHTML = '';
        divisions.forEach(function (division) {
            optionsHTML += `<option value="${division.id}">${division.name}</option>`;
        });
        optionsHTML += '<option value="all" selected>All Divisions</option>';

        const selectGroupHTML = `
            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                <select class="form-select selectDivision" name="divisions[]">
                    ${optionsHTML}
                </select>
                <button type="button" class="btn btn-danger btn-sm removeDivisionBtn" disabled title="Cannot remove when 'All Divisions' is selected">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;
        divisionContainer.insertAdjacentHTML('beforeend', selectGroupHTML);
        addDivisionBtn.disabled = true;
    }

    // Disable options that have been selected already in other select elements
    function updateDisabledOptions() {
        const allSelects = divisionContainer.querySelectorAll('.selectDivision');
        const selectedValues = [];

        allSelects.forEach(select => {
            if (select.value !== 'all') {
                selectedValues.push(select.value);
            }
        });

        allSelects.forEach(currentSelect => {
            const currentValue = currentSelect.value;

            // Enable all options first
            currentSelect.querySelectorAll('option').forEach(option => {
                option.disabled = false;
            });

            // Disable selected options in other selects
            selectedValues.forEach(value => {
                if (value !== currentValue) {
                    const optionToDisable = currentSelect.querySelector(`option[value="${value}"]`);
                    if (optionToDisable) optionToDisable.disabled = true;
                }
            });
        });
    }

    // Listen to changes in ANY select input
    divisionContainer.addEventListener('change', function (e) {
        if (e.target.classList.contains('selectDivision')) {
            if (e.target.value === 'all') {
                resetToAllDivisions(); // From earlier
            } else {
                addDivisionBtn.disabled = false;
            }
            updateDisabledOptions(); // Call to update disabled options
        }
    });

    // Add new select input
    addDivisionBtn.addEventListener('click', function (e) {
        e.preventDefault();

        if (isAllDivisionsSelected()) return;

        const divisions = JSON.parse(divisionContainer.getAttribute('data-divisions'));
        let optionsHTML = '<option value="all">Select Division</option>';
        divisions.forEach(function (division) {
            optionsHTML += `<option value="${division.id}">${division.name}</option>`;
        });
        optionsHTML += '<option value="all">All Divisions</option>';

        const selectGroupHTML = `
            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                <select class="form-select selectDivision" name="divisions[]">
                    ${optionsHTML}
                </select>
                <button type="button" class="btn btn-danger btn-sm removeDivisionBtn">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;

        divisionContainer.insertAdjacentHTML('beforeend', selectGroupHTML);
        updateDisabledOptions(); // Call to update disabled options
    });

    // Remove individual select input
    divisionContainer.addEventListener('click', function (e) {
        if (e.target.closest('.removeDivisionBtn')) {
            const group = e.target.closest('.division-select-group');
            group.remove();

            if (!isAllDivisionsSelected()) {
                addDivisionBtn.disabled = false;
            }
            updateDisabledOptions(); // Call to update disabled options after removal
        }
    });
});


// Delegate remove button event listener
document.getElementById('divisionSelectContainer').addEventListener('click', function (e) {
    if (e.target.closest('.removeDivisionBtn')) {
        e.preventDefault();
        e.target.closest('.division-select-group').remove();
    }
});

// Filtering thru Division
document.getElementById('divisionFilter').addEventListener('change', function () {
    const selectedDivisionId = this.value;
    localStorage.setItem('selectedDivisionId', selectedDivisionId); // ✅ Save it in localStorage

    // Apply filter
    document.querySelectorAll('.programRow').forEach(row => {
        const divisionIds = row.dataset.divisionIds.split(',');
        const programId = row.dataset.programId;
        const match = selectedDivisionId === '' || divisionIds.includes(selectedDivisionId);

        row.style.display = match ? '' : 'none';

        document.querySelectorAll(`[data-program-id="${programId}"]`).forEach(childRow => {
            childRow.style.display = match ? '' : 'none';
        });
    });
});

$(document).ready(function () {
    const savedDivisionId = sessionStorage.getItem('selectedDivisionId');
    if (savedDivisionId !== null) {
        $('#divisionFilter').val(savedDivisionId).trigger('change');
        sessionStorage.removeItem('selectedDivisionId'); // Clear after applying
    }
});