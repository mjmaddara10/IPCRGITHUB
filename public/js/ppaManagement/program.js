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
                url: 'addProgram',
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
$(document).on('click', '.editProgramBtn', function() {
    // Get data from the button clicked
    var programId = $(this).data('program-id');
    var programName = $(this).data('program-name');
    var programSuccessIndicator = $(this).data('program-success');
    var programQuality = $(this).data('program-quality');
    var programEfficiency = $(this).data('program-efficiency');
    var programTimeliness = $(this).data('program-timeliness');
    var programRemarks = $(this).data('program-remarks');

    // Populate the modal fields with the data
    $('#editProgramId').val(programId);
    $('#editProgramName').val(programName);
    $('#editSuccessIndicator').val(programSuccessIndicator);
    $('#editQuality').val(programQuality);
    $('#editEfficiency').val(programEfficiency);
    $('#editTimeliness').val(programTimeliness);
    $('#editRemarks').val(programRemarks);
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
                url: 'updateProgram',  // Your update URL
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
$(document).on('click', '.deleteProgramBtn', function(e) {
    e.preventDefault();

    var programId = $(this).data('program-id');
    var deleteUrl  = $(this).data('url');
    console.log(programId);

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this program? All projects and activities under it will also be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, delete project"
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX request to delete the project
            $.ajax({
                url: deleteUrl,  // Your delete URL
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

// Adding more division responsible
/*document.getElementById('addDivisionBtn').addEventListener('click', function (e) {
    e.preventDefault();

    const selectGroupHTML = `
        <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
            <select class="form-select selectDivision" name="divisions[]">
                <option value="Permanent">Organizational Development Division</option>
                <option value="COS">Benefits and Welfare Division</option>
                <option value="Casual">Organizational Development Division</option>
                <option value="Casual">Personnel and Administrative Division</option>
            </select>
            <button type="button" class="btn btn-danger btn-sm removeDivisionBtn">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `;

    document.getElementById('divisionSelectContainer').insertAdjacentHTML('beforeend', selectGroupHTML);
});*/

document.getElementById('addDivisionBtn').addEventListener('click', function (e) {
    e.preventDefault();

    // Get the divisions data from the data attribute on the container
    const divisions = JSON.parse(document.getElementById('divisionSelectContainer').getAttribute('data-divisions'));

    // Start building the select options
    let optionsHTML = '<option value="all">All Divisions</option>';
    divisions.forEach(function (division) {
        optionsHTML += `<option value="${division.id}">${division.name}</option>`;
    });

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

    document.getElementById('divisionSelectContainer').insertAdjacentHTML('beforeend', selectGroupHTML);
});


// Delegate remove button event listener
document.getElementById('divisionSelectContainer').addEventListener('click', function (e) {
    if (e.target.closest('.removeDivisionBtn')) {
        e.preventDefault();
        e.target.closest('.division-select-group').remove();
    }
});

// Edit Program
document.addEventListener('DOMContentLoaded', function () {
    const editDivisionContainer = document.getElementById('editDivisionSelectContainer');
    const allDivisions = JSON.parse(editDivisionContainer.getAttribute('data-divisions'));
    
    document.getElementById('editAddDivisionBtn').addEventListener('click', function (e) {
        e.preventDefault();

        let optionsHTML = '';
        allDivisions.forEach(function (division) {
            optionsHTML += `<option value="${division.id}">${division.name}</option>`;
        });

        const selectGroupHTML = `
            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                <select class="form-select" name="divisions[]">${optionsHTML}</select>
                <button type="button" class="btn btn-danger btn-sm removeDivisionBtn">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;

        editDivisionContainer.insertAdjacentHTML('beforeend', selectGroupHTML);
    });

    // Delegate remove button functionality
    editDivisionContainer.addEventListener('click', function (e) {
        if (e.target.closest('.removeDivisionBtn')) {
            e.target.closest('.division-select-group').remove();
        }
    });
});

document.getElementById('divisionFilter').addEventListener('change', function () {
    const selectedDivisionId = this.value;

    // Loop through each program row
    document.querySelectorAll('.programRow').forEach(row => {
        const divisionIds = row.dataset.divisionIds.split(',');
        const programId = row.dataset.programId;

        const match = selectedDivisionId === '' || divisionIds.includes(selectedDivisionId);

        // Show/hide the program row and all related child rows
        row.style.display = match ? '' : 'none';

        document.querySelectorAll(`[data-program-id="${programId}"]`).forEach(childRow => {
            childRow.style.display = match ? '' : 'none';
        });
    });
});



// Division Filtering
/*document.getElementById('divisionFilter').addEventListener('change', function () {
    var selectedDivision = this.value;

    // Send AJAX request to fetch filtered programs
    fetch(`/filterProgram?division_id=${selectedDivision}`)
        .then(response => response.json())
        .then(data => {
            // Empty the current table content
            const tableBody = document.getElementById('programTableBody');
            tableBody.innerHTML = '';

            // Insert the filtered data into the table
            data.programs.forEach(program => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center">${program.name}</td>
                    <td class="text-center">${program.divisions.map(division => division.name).join(', ')}</td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));
    }
);*/