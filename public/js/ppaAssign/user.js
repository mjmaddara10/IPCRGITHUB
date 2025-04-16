// Fill blue area
$(document).ready(function () {
    $('#employeeSelect').on('change', function () {
        const selectedOption = $(this).find(':selected');

        const name = selectedOption.data('name') || '________';
        const position = selectedOption.data('position') || '________';
        const status = selectedOption.data('status') || '________';
        const division = selectedOption.data('division') || '________';

        $('#empName').text(name);
        $('#empPosition').text(position);
        $('#empStatus').text(status);
        $('#empDivision').text(division);
    });
});

$('#employeeSelect').on('change', function () {
    let employeeId = $(this).val();

    if (employeeId) {
        $.ajax({
            url: '/admin/getEmployeeDivision/' + employeeId,
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