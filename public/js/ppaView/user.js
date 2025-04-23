function safeValue(val) {
    return val === null || val === undefined ? '' : val;
}

// Fill blue area
$(document).ready(function () {
    const selectedOption = $(this).find(':selected');

        const name = selectedOption.data('name') || '________';
        const position = selectedOption.data('position') || '________';
        const status = selectedOption.data('status') || '________';
        const divisionName = selectedOption.data('division-name') || '________';
        const divisionId = selectedOption.data('division-id') || '';

        $('#empName').text(name);
        $('#empPosition').text(position);
        $('#empStatus').text(status);
        $('#empDivision').text(divisionName);

        // console.log('Division ID:', divisionId);

        const chiefInfo = divisionChiefs[divisionId] || {
            name: '_________________________',
            position: '_________________________'
        };
        
        $('#reviewedByName').text(chiefInfo.name);
        $('#reviewedByPosition').text(chiefInfo.position);

    $('#employeeSelect').on('change', function () {
        let employeeId = $(this).val();
        const selectedOption = $(this).find(':selected');

        const name = selectedOption.data('name') || '________';
        const position = selectedOption.data('position') || '________';
        const status = selectedOption.data('status') || '________';
        const divisionName = selectedOption.data('division-name') || '________';
        const divisionId = selectedOption.data('division-id') || '';

        $('#empName').text(name);
        $('#empPosition').text(position);
        $('#empStatus').text(status);
        $('#empDivision').text(divisionName);

        // console.log('Division ID:', divisionId);

        const chiefInfo = divisionChiefs[divisionId] || {
            name: '_________________________',
            position: '_________________________'
        };
        
        $('#reviewedByName').text(chiefInfo.name);
        $('#reviewedByPosition').text(chiefInfo.position);

        // Table filling
        if (employeeId) {
            $.ajax({
                url: '/viewPpa/' + employeeId + '/getEmployeeTargets',
                type: 'GET',
                success: function (assignments) {
                    let tbody = $('#usersTable tbody');
                    tbody.empty();
                    
                    let lastProgramName = ''; // Variable to track the last displayed program name
                    
                    assignments.forEach(function (assignment) {
                        // Only display program name if it's different from the last one
                        let programRow = '';
                        if (assignment.program_name !== lastProgramName) {
                            lastProgramName = assignment.program_name;
                            programRow = `
                                <tr>
                                    <td class="text-left" style="color: #FFFFFF; background-color: #03592c;" colspan="6">${assignment.program_name}</td>
                                </tr>
                            `;
                        }
    
                        let row = `
                            ${programRow}
                            <tr>
                                <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">${safeValue(assignment.activity_name)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">${safeValue(assignment.activity_success_indicator)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">${safeValue(assignment.activity_quality)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">${safeValue(assignment.activity_efficiency)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">${safeValue(assignment.activity_timeliness)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">${safeValue(assignment.activity_remarks)}</td>
                            </tr>
                        `;

                        if (assignment.sub_activity_name) {
                            row += `
                            <tr>
                                <td class="text-left ps-3 border border-muted">${safeValue(assignment.sub_activity_name)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap;">${safeValue(assignment.sub_activity_success_indicator)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap;">${safeValue(assignment.sub_activity_quality)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap;">${safeValue(assignment.sub_activity_efficiency)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap;">${safeValue(assignment.sub_activity_timeliness)}</td>
                                <td class="text-left border border-muted" style="white-space: pre-wrap;">${safeValue(assignment.sub_activity_remarks)}</td>
                            </tr>
                            `;
                        }
                        tbody.append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching assignments:', error);
                }
            });
        }
    });

    const allEmployeeOptions = Array.from($('#employeeSelect option'));

    $('#divisionSelect').on('change', function () {
        const selectedDivisionId = $(this).val();

        // Filter employees
        $('#employeeSelect').empty(); // Clear current options

        // Append only employees from the selected division
        allEmployeeOptions.forEach(option => {
            if ($(option).data('division-id') == selectedDivisionId) {
                $('#employeeSelect').append(option);
            }
        });

        // Trigger change manually to update fields for first visible user
        $('#employeeSelect').trigger('change');
    });
});

$('#employeeSelect').on('change', function () {
    let employeeId = $(this).val();

    if (employeeId) {
        $.ajax({
            url: '/viewPpa/' + employeeId + '/getEmployeeDivision',
            type: 'GET',
            success: function (response) {
                let divisionId = response.id;

                // Show only programs that have this divisionId in their data-division-ids
                $('.programRow').each(function () {
                    let divisionIds = $(this).data('division-ids').toString().split(',');
                    if (divisionIds.includes(divisionId.toString())) {
                        $(this).show();

                        // Show associated child rows
                        let programId = $(this).data('program-id');
                        $('tr[data-program-id="' + programId + '"]').show();
                    } else {
                        $(this).hide();

                        // Hide associated child rows
                        let programId = $(this).data('program-id');
                        $('tr[data-program-id="' + programId + '"]').hide();
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log('Status:', status);
                console.log('Error:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    }
});