document.getElementById('divisionFilter').addEventListener('change', function () {
    const selectedDivisionId = this.value;
    localStorage.setItem('selectedDivisionId', selectedDivisionId);

    document.querySelectorAll('.programRow').forEach(programRow => {
        const divisionIds = programRow.dataset.divisionIds.split(',');
        const programId = programRow.dataset.programId;
        const match = selectedDivisionId === '' || divisionIds.includes(selectedDivisionId);

        // Show/hide program row
        programRow.style.display = match ? '' : 'none';

        // Show/hide its children
        document.querySelectorAll(`tr.activityRow[data-program-id="${programId}"], tr.subActivityRow[data-program-id="${programId}"]`).forEach(childRow => {
            childRow.style.display = match ? '' : 'none';
        });
    });

    // 🔁 Re-apply collapse/expand state after filter
    setTimeout(updateCollapseStates, 50);
});

function updateCollapseStates() {
    $('.programRow').each(function () {
        const programId = $(this).data('program-id');
        const isCollapsed = localStorage.getItem('programCollapsed_' + programId);
        const collapseBtn = $(this).find('.programCollapseBtn');
        const childRows = $(`tr[data-program-id="${programId}"]`).not('.programRow');

        if ($(this).css('display') === 'none') {
            childRows.hide(); // hide child rows if parent is hidden
            return;
        }

        if (isCollapsed) {
            childRows.hide();
            collapseBtn.attr('title', 'Expand').find('i').removeClass('fa-inbox').addClass('fa-box-open');
            collapseBtn.removeClass('btn-warning').addClass('btn-orange');
        } else {
            childRows.show();
            collapseBtn.attr('title', 'Collapse').find('i').removeClass('fa-box-open').addClass('fa-inbox');
            collapseBtn.removeClass('btn-orange').addClass('btn-warning');
        }
    });

    $('.activityRow').each(function () {
        const activityId = $(this).data('activity-id');
        const isCollapsed = localStorage.getItem('activityCollapsed_' + activityId);
        const collapseBtn = $(this).find('.activityCollapseBtn');
        const childRows = $(`tr[data-activity-id="${activityId}"]`).not('.activityRow');

        if ($(this).css('display') === 'none') {
            childRows.hide();
            return;
        }

        if (isCollapsed) {
            childRows.hide();
            collapseBtn.attr('title', 'Expand').find('i').removeClass('fa-inbox').addClass('fa-box-open');
            collapseBtn.removeClass('btn-warning').addClass('btn-orange');
        } else {
            childRows.show();
            collapseBtn.attr('title', 'Collapse').find('i').removeClass('fa-box-open').addClass('fa-inbox');
            collapseBtn.removeClass('btn-orange').addClass('btn-warning');
        }
    });
}

$(document).ready(function () {
    // Restore previous division filter
    const savedDivisionId = sessionStorage.getItem('selectedDivisionId');
    if (savedDivisionId !== null) {
        $('#divisionFilter').val(savedDivisionId).trigger('change');
        sessionStorage.removeItem('selectedDivisionId');
    } else {
        updateCollapseStates(); // On first load
    }

    // Collapse/expand handlers
    $('.programCollapseBtn').on('click', function () {
        const programId = $(this).closest('tr').data('program-id');
        const childRows = $(`tr[data-program-id="${programId}"]`).not('.programRow');
        const isVisible = childRows.first().is(':visible');

        if (isVisible) {
            childRows.slideUp(200);
            $(this).attr('title', 'Expand').find('i').removeClass('fa-inbox').addClass('fa-box-open');
            $(this).removeClass('btn-warning').addClass('btn-orange');
            localStorage.setItem('programCollapsed_' + programId, 'true');
        } else {
            childRows.slideDown(200);
            $(this).attr('title', 'Collapse').find('i').removeClass('fa-box-open').addClass('fa-inbox');
            $(this).removeClass('btn-orange').addClass('btn-warning');
            localStorage.removeItem('programCollapsed_' + programId);
        }
    });

    $('.activityCollapseBtn').on('click', function () {
        const activityId = $(this).closest('tr').data('activity-id');
        const childRows = $(`tr[data-activity-id="${activityId}"]`).not('.activityRow');
        const isVisible = childRows.first().is(':visible');

        if (isVisible) {
            childRows.slideUp(200);
            $(this).attr('title', 'Expand').find('i').removeClass('fa-inbox').addClass('fa-box-open');
            $(this).removeClass('btn-warning').addClass('btn-orange');
            localStorage.setItem('activityCollapsed_' + activityId, 'true');
        } else {
            childRows.slideDown(200);
            $(this).attr('title', 'Collapse').find('i').removeClass('fa-box-open').addClass('fa-inbox');
            $(this).removeClass('btn-orange').addClass('btn-warning');
            localStorage.removeItem('activityCollapsed_' + activityId);
        }
    });
});