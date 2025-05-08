function safeValue(val) {
    return val === null || val === undefined ? '' : val;
}

let employeeId = null;
let chiefInfo = {};

// Fill blue area
$(document).ready(function () {
    const savedId = localStorage.getItem('selectedEmployeeId');

    if (savedId) {
        $('#employeeSelect').val(savedId).trigger('change');
    }
    
    const selectedOption = $(this).find(':selected');
    const divisionId = selectedOption.data('division-id') || '';

    chiefInfo = divisionChiefs[divisionId] || {
        name: '_________________________',
        position: '_________________________'
    };

    if (savedId) {
        // 1. Get Employee Targets
        $.ajax({
            url: '/viewPpa/' + savedId + '/getEmployeeTargets',
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
                let printedActivities = new Set(); // <-- NEW set for activities

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
                                    <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF; vertical-align: top;">${safeValue(assignment.program_budget)}</td>
                                    <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF; vertical-align: top;">
                                        ${Array.isArray(assignment.program_division) ? assignment.program_division.join('<br><br>') : safeValue(assignment.program_division)}
                                    </td>

                                    // Actions
                                    <td class="text-center" style= "color: #FFFFFF; background-color: #03592c;">
                                        <!-- Edit Program -->
                                        <button class="btn btn-sm editProgramBtnTarget buttonHover" title="Edit program name"
                                            data-program-id="${assignment.program_id}" 
                                            data-program-name="${assignment.program_name}"
                                            data-program-success="${assignment.program_success_indicator}"
                                            data-program-quality="${assignment.program_quality}"
                                            data-program-efficiency="${assignment.program_efficiency}"
                                            data-program-timeliness="${assignment.program_timeliness}"
                                            data-program-remarks="${assignment.program_remarks}"
                                            data-program-budget="${assignment.program_budget}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Program -->
                                        <button class="btn btn-sm deleteProgramBtnTarget buttonHover" title="Delete program"
                                            data-program-id="${assignment.program_id}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        } else {
                            row += `
                                <tr style="background-color: #03592c; color: white;">
                                    <td class="text-left border border-light" colspan="7" style="font-weight: bold; background-color: #03592c; color:#FFFFFF;">${assignment.program_name}</td>
                                </tr>
                            `;
                        }
                    }

                    if (isDeptHead) {
                        // Always print Activity row if Dept Head
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

                                // Actions
                                <td class="text-center" style="background-color:rgb(212, 212, 212);">
                                    <!-- Edit Activity -->
                                    <button class="btn btn-sm editActivityBtnTarget buttonHover" title="Edit activity name"
                                        data-activity-id="${assignment.activity_id}" 
                                        data-activity-name="${assignment.activity_name}"
                                        data-activity-success="${assignment.activity_success_indicator}"
                                        data-activity-quality="${assignment.activity_quality}"
                                        data-activity-efficiency="${assignment.activity_efficiency}"
                                        data-activity-timeliness="${assignment.activity_timeliness}"
                                        data-activity-remarks="${assignment.activity_remarks}" data-bs-toggle="modal" data-bs-target="#editActivityModal" style="color: #FFFFFF;background-color: rgb(144, 144, 144);"><i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Activity -->
                                    <button class="btn btn-sm deleteActivityBtnTarget buttonHover" title="Delete activity"
                                        data-activity-id="${assignment.activity_id}" style="color: #FFFFFF; background-color: rgb(144, 144, 144);"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    } else {
                        // Print activity row ONLY ONCE
                        if (!printedActivities.has(assignment.activity_name)) {
                            printedActivities.add(assignment.activity_name);
                            row += `
                                <tr>
                                    <td colspan="6" class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                        ${safeValue(assignment.activity_name).replace(/\n/g, '<br><br>')}
                                    </td>

                                    // Actions
                                    <td class="text-center" style="background-color:rgb(212, 212, 212);">
                                        <!-- Edit Activity -->
                                        <button class="btn btn-sm editActivityBtnTarget buttonHover" title="Edit activity name"
                                            data-activity-id="${assignment.activity_id}" 
                                            data-activity-name="${assignment.activity_name}"
                                            data-activity-success="${assignment.activity_success_indicator}"
                                            data-activity-quality="${assignment.activity_quality}"
                                            data-activity-efficiency="${assignment.activity_efficiency}"
                                            data-activity-timeliness="${assignment.activity_timeliness}"
                                            data-activity-remarks="${assignment.activity_remarks}" data-bs-toggle="modal" data-bs-target="#editActivityModal" style="color: #FFFFFF;background-color: rgb(144, 144, 144);"><i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Activity -->
                                        <button class="btn btn-sm deleteProgramBtn buttonHover" title="Delete activity"
                                            data-activity-id="${assignment.activity_id}" style="color: #FFFFFF; background-color: rgb(144, 144, 144);"><i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }

                        // Then print sub-activity always
                        row += `
                            <tr>
                                <td class="text-left ps-3 border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_name).replace(/\n/g, '<br><br>')}</td>
                                <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_success_indicator).replace(/\n/g, '<br><br>')}</td>
                                <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_quality).replace(/\n/g, '<br><br>')}</td>
                                <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_efficiency).replace(/\n/g, '<br><br>')}</td>
                                <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_timeliness).replace(/\n/g, '<br><br>')}</td>
                                <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_remarks).replace(/\n/g, '<br><br>')}</td>
                                
                                // Actions
                                <td class="text-center" style="background-color: #f8f8f8;">
                                    <!-- Edit Sub-Activity -->
                                    <button class="btn btn-sm editSubActivityBtnTarget buttonHover" title="Edit sub-activity name"
                                        data-sub-activity-id="${assignment.sub_activity_id}" 
                                        data-sub-activity-name="${assignment.sub_activity_name}"
                                        data-sub-activity-success="${assignment.sub_activity_success_indicator}"
                                        data-sub-activity-quality="${assignment.sub_activity_quality}"
                                        data-sub-activity-efficiency="${assignment.sub_activity_efficiency}"
                                        data-sub-activity-timeliness="${assignment.sub_activity_timeliness}"
                                        data-sub-activity-remarks="${assignment.sub_activity_remarks}" data-bs-toggle="modal" data-bs-target="#editSubActivityModal" style="color: #FFFFFF;background-color: rgb(144, 144, 144);"><i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Sub-Activity -->
                                    <button class="btn btn-sm deleteSubActivityBtnTarget buttonHover" title="Delete activity"
                                        data-sub-activity-id="${assignment.sub_activity_id}" style="color: #FFFFFF; background-color: rgb(144, 144, 144);"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
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
            url: '/viewPpa/' + savedId + '/getEmployeeDivision',
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

    $('#exportBtn').on('click', function() {
        if (savedId && chiefInfo) {
            window.open('/pdf/' + savedId + '/generatePdf?chiefInfo=' + encodeURIComponent(JSON.stringify(chiefInfo)), '_blank');
        } else {
            console.error('No employee selected or chief info available');
        }
    });

    $('#employeeSelect').on('change', function () {
        employeeId = $(this).val();

        localStorage.setItem('selectedEmployeeId', employeeId);
    
        const selectedOption = $(this).find(':selected');
        const divisionId = selectedOption.data('division-id') || '';
        
        const chiefInfo = divisionChiefs[divisionId] || {
            name: '_________________________',
            position: '_________________________'
        };
    
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
                    let printedActivities = new Set(); // <-- NEW set for activities

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
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF; vertical-align: top;">${safeValue(assignment.program_budget)}</td>
                                        <td class="text-left border border-light" style="background-color: #03592c; color:#FFFFFF; vertical-align: top;">
                                            ${Array.isArray(assignment.program_division) ? assignment.program_division.join('<br><br>') : safeValue(assignment.program_division)}
                                        </td>

                                        // Actions
                                        <td class="text-center" style= "color: #FFFFFF; background-color: #03592c;">
                                            <!-- Edit Program -->
                                            <button class="btn btn-sm editProgramBtnTarget buttonHover" title="Edit program name"
                                                data-program-id="${assignment.program_id}" 
                                                data-program-name="${assignment.program_name}"
                                                data-program-success="${assignment.program_success_indicator}"
                                                data-program-quality="${assignment.program_quality}"
                                                data-program-efficiency="${assignment.program_efficiency}"
                                                data-program-timeliness="${assignment.program_timeliness}"
                                                data-program-remarks="${assignment.program_remarks}"
                                                data-program-budget="${assignment.program_budget}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Delete Program -->
                                            <button class="btn btn-sm deleteProgramBtnTarget buttonHover" title="Delete program"
                                                data-program-id="${assignment.program_id}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            } else {
                                row += `
                                    <tr style="background-color: #03592c; color: white;">
                                        <td class="text-left border border-light" colspan="7" style="font-weight: bold; background-color: #03592c; color:#FFFFFF;">${assignment.program_name}</td>
                                    </tr>
                                `;
                            }
                        }

                        if (isDeptHead) {
                            // Always print Activity row if Dept Head
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

                                    // Actions
                                    <td class="text-center" style="background-color:rgb(212, 212, 212);">
                                        <!-- Edit Activity -->
                                        <button class="btn btn-sm editActivityBtnTarget buttonHover" title="Edit activity name"
                                            data-activity-id="${assignment.activity_id}" 
                                            data-activity-name="${assignment.activity_name}"
                                            data-activity-success="${assignment.activity_success_indicator}"
                                            data-activity-quality="${assignment.activity_quality}"
                                            data-activity-efficiency="${assignment.activity_efficiency}"
                                            data-activity-timeliness="${assignment.activity_timeliness}"
                                            data-activity-remarks="${assignment.activity_remarks}" data-bs-toggle="modal" data-bs-target="#editActivityModal" style="color: #FFFFFF;background-color: rgb(144, 144, 144);"><i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Activity -->
                                        <button class="btn btn-sm deleteActivityBtnTarget buttonHover" title="Delete activity"
                                            data-activity-id="${assignment.activity_id}" style="color: #FFFFFF; background-color: rgb(144, 144, 144);"><i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        } else {
                            // Print activity row ONLY ONCE
                            if (!printedActivities.has(assignment.activity_name)) {
                                printedActivities.add(assignment.activity_name);
                                row += `
                                    <tr>
                                        <td colspan="6" class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">
                                            ${safeValue(assignment.activity_name).replace(/\n/g, '<br><br>')}
                                        </td>

                                        // Actions
                                        <td class="text-center" style="background-color:rgb(212, 212, 212);">
                                            <!-- Edit Activity -->
                                            <button class="btn btn-sm editActivityBtnTarget buttonHover" title="Edit activity name"
                                                data-activity-id="${assignment.activity_id}" 
                                                data-activity-name="${assignment.activity_name}"
                                                data-activity-success="${assignment.activity_success_indicator}"
                                                data-activity-quality="${assignment.activity_quality}"
                                                data-activity-efficiency="${assignment.activity_efficiency}"
                                                data-activity-timeliness="${assignment.activity_timeliness}"
                                                data-activity-remarks="${assignment.activity_remarks}" data-bs-toggle="modal" data-bs-target="#editActivityModal" style="color: #FFFFFF;background-color: rgb(144, 144, 144);"><i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Delete Activity -->
                                            <button class="btn btn-sm deleteProgramBtn buttonHover" title="Delete activity"
                                                data-activity-id="${assignment.activity_id}" style="color: #FFFFFF; background-color: rgb(144, 144, 144);"><i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            }

                            // Then print sub-activity always
                            row += `
                                <tr>
                                    <td class="text-left ps-3 border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_name).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_success_indicator).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_quality).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_efficiency).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_timeliness).replace(/\n/g, '<br><br>')}</td>
                                    <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_remarks).replace(/\n/g, '<br><br>')}</td>
                                    
                                    // Actions
                                    <td class="text-center" style="background-color: #f8f8f8;">
                                        <!-- Edit Sub-Activity -->
                                        <button class="btn btn-sm editSubActivityBtnTarget buttonHover" title="Edit sub-activity name"
                                            data-sub-activity-id="${assignment.sub_activity_id}" 
                                            data-sub-activity-name="${assignment.sub_activity_name}"
                                            data-sub-activity-success="${assignment.sub_activity_success_indicator}"
                                            data-sub-activity-quality="${assignment.sub_activity_quality}"
                                            data-sub-activity-efficiency="${assignment.sub_activity_efficiency}"
                                            data-sub-activity-timeliness="${assignment.sub_activity_timeliness}"
                                            data-sub-activity-remarks="${assignment.sub_activity_remarks}" data-bs-toggle="modal" data-bs-target="#editSubActivityModal" style="color: #FFFFFF;background-color: rgb(144, 144, 144);"><i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Sub-Activity -->
                                        <button class="btn btn-sm deleteSubActivityBtnTarget buttonHover" title="Delete activity"
                                            data-sub-activity-id="${assignment.sub_activity_id}" style="color: #FFFFFF; background-color: rgb(144, 144, 144);"><i class="fas fa-trash"></i>
                                        </button>
                                    </td>
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

        $('#exportBtn').on('click', function() {
            if (employeeId && chiefInfo) {
                window.open('/pdf/' + employeeId + '/generatePdf?chiefInfo=' + encodeURIComponent(JSON.stringify(chiefInfo)), '_blank');
            } else {
                console.error('No employee selected or chief info available');
            }
        });
    });

    const allEmployeeOptions = Array.from($('#employeeSelect option'));

    $('#divisionSelect').on('change', function () {
        var divisionId = $(this).val();  // Get the selected division ID
        var employeeSelect = $('#employeeSelect');
        employeeSelect.html('<option>Select a User</option>'); // Reset employee options
    
        if (divisionId === "" || divisionId === "All Divisions") {
            // If "All Divisions" is selected, show all employees
            employees.forEach(employee => {
                employeeSelect.append('<option value="' + employee.id + '" ' +
                    'data-name="' + employee.firstName + ' ' + (employee.middleName ? employee.middleName.charAt(0) + '.' : '') + ' ' + employee.lastName + '" ' +
                    'data-position="' + employee.position + '" ' +
                    'data-status="' + employee.status + '" ' +
                    'data-division-id="' + (employee.division ? employee.division.id : '') + '" ' +
                    'data-division-name="' + (employee.division ? employee.division.name : '') + '">' +
                    employee.firstName + ' ' + (employee.middleName ? employee.middleName.charAt(0) + '.' : '') + ' ' + employee.lastName +
                    '</option>');
            });
        } else {
            // If a division is selected, filter employees by the selected division
            employees.forEach(employee => {
                if (employee.division && employee.division.id == divisionId) {
                    employeeSelect.append('<option value="' + employee.id + '" ' +
                        'data-name="' + employee.firstName + ' ' + (employee.middleName ? employee.middleName.charAt(0) + '.' : '') + ' ' + employee.lastName + '" ' +
                        'data-position="' + employee.position + '" ' +
                        'data-status="' + employee.status + '" ' +
                        'data-division-id="' + (employee.division ? employee.division.id : '') + '" ' +
                        'data-division-name="' + (employee.division ? employee.division.name : '') + '">' +
                        employee.firstName + ' ' + (employee.middleName ? employee.middleName.charAt(0) + '.' : '') + ' ' + employee.lastName +
                        '</option>');
                }
            });
        }
    });

    $('#exportBtnStaff').on('click', function() {
        var userId = $(this).data('user-id');
        var divisionId = $(this).data('user-division');

        const chiefInfo = divisionChiefs[divisionId] || {
            name: '_________________________',
            position: '_________________________'
        };

        if (userId && chiefInfo) {
            window.open('/pdf/' + userId + '/generatePdf?chiefInfo=' + encodeURIComponent(JSON.stringify(chiefInfo)), '_blank');
        } else {
            console.error('No employee selected or chief info available');
        }
    });
});

