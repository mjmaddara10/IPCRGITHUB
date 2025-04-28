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
        const divisionName = selectedOption.data('division-name');
        const divisionId = selectedOption.data('division-id') || '';
    
        $('#empName').text(name);
        $('#empPosition').text(position);
        $('#empStatus').text(status);
        $('#empDivision').text(", " +divisionName);
    
        const chiefInfo = divisionChiefs[divisionId] || {
            name: '_________________________',
            position: '_________________________'
        };
    
        $('#reviewedByName').text(chiefInfo.name);
        $('#reviewedByPosition').text(chiefInfo.position);
    
        if (employeeId) {
            // 1. Get Employee Targets
            $.ajax({
                url: '/viewPpa/' + employeeId + '/getEmployeeTargets',
                type: 'GET',
                success: function (response) {
                    console.log('AJAX response:', response);
            
                    const assignments = response.targets;
                    const role = response.role;
            
                    if (!Array.isArray(assignments)) {
                        console.error("Expected array but got:", assignments);
                        return;
                    }
            
                    let tbody = $('#usersTable tbody');
                    tbody.empty();
            
                    const isDeptHead = (role === 'Department Head' || role === 'Assistant Department Head');
            
                    if (isDeptHead) {
                        $('#thead-default').addClass('d-none');
                        $('#thead-dept-head').removeClass('d-none');
                    } else {
                        $('#thead-default').removeClass('d-none');
                        $('#thead-dept-head').addClass('d-none');
                    }
            
                    let printedPrograms = new Set();
            
                    assignments.forEach(function (assignment) {
                        let row = '';
            
                        if (!printedPrograms.has(assignment.program_name)) {
                            printedPrograms.add(assignment.program_name);
            
                            if (isDeptHead) {
                                row += `
                                    <tr style="background-color: #03592c; color: white;">
                                        <td class="text-left border border-light" style="font-weight: bold; background-color: #03592c; color:#FFFFFF;">${assignment.program_name}</td>
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF;"><pre>${safeValue(assignment.program_success_indicator)}</pre></td>
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF;">${safeValue(assignment.program_quality)}</td>
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF;">${safeValue(assignment.program_efficiency)}</td>
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF;">${safeValue(assignment.program_timeliness)}</td>
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF;">${safeValue(assignment.program_remarks)}</td>
                                        <td class="text-center border border-light" style="background-color: #03592c; color:#FFFFFF; vertical-align: middle;">${safeValue(assignment.program_budget)}</td>
                                        <td class="text-center border border-light" style="background-color: #03592c; color:#FFFFFF; vertical-align: middle;">
                                            ${Array.isArray(assignment.program_division) ? assignment.program_division.join('<br><br>') : safeValue(assignment.program_division)}
                                        </td>
                                    </tr>
                                `;
                            } else {
                                row += `
                                    <tr style="background-color: #03592c; color: white;">
                                        <td class="text-left border border-light" colspan="6" style="font-weight: bold; background-color: #03592c; color:#FFFFFF;">${assignment.program_name}</td>
                                    </tr>
                                `;
                            }
                        }
            
                        // Activity row
                        if (isDeptHead) {
                            row += `
                                <tr>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_name).replace(/\n/g, '<br><br>')}
                                    </td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_success_indicator).replace(/\n/g, '<br><br>')}
                                    </td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_quality).replace(/\n/g, '<br><br>')}
                                    </td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_efficiency).replace(/\n/g, '<br><br>')}
                                    </td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_timeliness).replace(/\n/g, '<br><br>')}
                                    </td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_remarks).replace(/\n/g, '<br><br>')}
                                    </td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);"></td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);"></td>
                                </tr>
                            `;
                        } else {
                            row += `
                                <tr>
                                    <td colspan="6" class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_name).replace(/\n/g, '<br><br>')}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left ps-3 border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_name).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_success_indicator).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_quality).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_efficiency).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_timeliness).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_remarks).replace(/\n/g, '<br><br>')}</td>
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
    
            // 2. Get Employee Division to filter programs
            $.ajax({
                url: '/viewPpa/' + employeeId + '/getEmployeeDivision',
                type: 'GET',
                success: function (response) {
                    let divisionId = response.id;
    
                    $('.programRow').each(function () {
                        let divisionIds = $(this).data('division-ids').toString().split(',');
                        let programId = $(this).data('program-id');
    
                        if (divisionIds.includes(divisionId.toString())) {
                            $(this).show();
                            $('tr[data-program-id="' + programId + '"]').show();
                        } else {
                            $(this).hide();
                            $('tr[data-program-id="' + programId + '"]').hide();
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.log('Status:', status);
                    console.log('Error:', error);
                    console.log('Response:', xhr.responseText);
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

    // $('#exportBtn').on('click', function () {
    //     const assignments = response.targets;  // Your data
    //     const role = response.role;  // Your role data
    
    //     // Transfer assignments and role to hidden inputs
    //     $('#assignments').val(JSON.stringify(assignments));  // Convert to JSON string if necessary
    //     $('#role').val(role);
    
    //     // Submit the form to the route
    //     $('#pdfForm').submit();
    // });
});

