$(document).ready(function () {

    // Retain collapse/expand state of programs
    $('.programRow').each(function () {
        const programId = $(this).data('program-id');
        const isCollapsed = localStorage.getItem('programCollapsed_' + programId);
    
        const collapseBtn = $(this).find('.programCollapseBtn');
        const childRows = $('tr').filter(function () {
            return $(this).data('program-id') === programId && !$(this).hasClass('programRow');
        });
    
        if (isCollapsed) {
            if (childRows.first().is(':visible')) childRows.hide();
    
            collapseBtn.attr('title', 'Expand');
            collapseBtn.find('i').removeClass('fa-inbox').addClass('fa-box-open');
            collapseBtn.removeClass('btn-warning').addClass('btn-orange');
        } else {
            if (!childRows.first().is(':visible')) childRows.show();
    
            collapseBtn.attr('title', 'Collapse');
            collapseBtn.find('i').removeClass('fa-box-open').addClass('fa-inbox');
            collapseBtn.removeClass('btn-orange').addClass('btn-warning');
        }
    });

    $('.activityRow').each(function () {
        const activityId = $(this).data('activity-id');
        const isCollapsed = localStorage.getItem('activityCollapsed_' + activityId);
    
        const collapseBtn = $(this).find('.activityCollapseBtn');
        const childRows = $('tr').filter(function () {
            return $(this).data('activity-id') === activityId && !$(this).hasClass('activityRow');
        });
    
        if (isCollapsed) {
            childRows.hide();
            collapseBtn.attr('title', 'Expand');
            collapseBtn.find('i').removeClass('fa-inbox').addClass('fa-box-open');
            collapseBtn.removeClass('btn-warning').addClass('btn-orange');
        } else {
            childRows.show();
            collapseBtn.attr('title', 'Collapse');
            collapseBtn.find('i').removeClass('fa-box-open').addClass('fa-inbox');
            collapseBtn.removeClass('btn-orange').addClass('btn-warning');
        }
    });

    $('.programCollapseBtn').on('click', function () {
        const programRow = $(this).closest('tr');
        const programId = programRow.data('program-id');

        const childRows = $('tr').filter(function () {
            return $(this).data('program-id') === programId && !$(this).hasClass('programRow');
        });

        const isVisible = childRows.first().is(':visible');

        if (isVisible) {
            childRows.slideUp(200); // animate collapse upwards
            $(this).attr('title', 'Expand');
            $(this).find('i').removeClass('fa-inbox').addClass('fa-box-open');
            $(this).removeClass('btn-warning').addClass('btn-orange');

            localStorage.setItem('programCollapsed_' + programId, 'true');
        } else {
            childRows.slideDown(200); // animate expand downwards
            $(this).attr('title', 'Collapse');
            $(this).find('i').removeClass('fa-box-open').addClass('fa-inbox');
            $(this).removeClass('btn-orange').addClass('btn-warning');

            localStorage.removeItem('programCollapsed_' + programId);
        }
    });

    $('.activityCollapseBtn').on('click', function () {
        const activityRow = $(this).closest('tr');
        const activityId = activityRow.data('activity-id');

        const childRows = $('tr').filter(function () {
            return $(this).data('activity-id') === activityId && !$(this).hasClass('activityRow');
        });

        const isVisible = childRows.first().is(':visible');

        if (isVisible) {
            childRows.slideUp(200); // animate collapse upwards
            $(this).attr('title', 'Expand');
            $(this).find('i').removeClass('fa-inbox').addClass('fa-box-open');
            $(this).removeClass('btn-warning').addClass('btn-orange');

            localStorage.setItem('activityCollapsed_' + activityId, 'true');
        } else {
            childRows.slideDown(200); // animate expand downwards
            $(this).attr('title', 'Collapse');
            $(this).find('i').removeClass('fa-box-open').addClass('fa-inbox');
            $(this).removeClass('btn-orange').addClass('btn-warning');

            localStorage.removeItem('activityCollapsed_' + activityId);
        }
    }); 
});

// Auto-scroll after PPA is moved
document.addEventListener('DOMContentLoaded', () => {
    const scrolledId = document.body.dataset.scrolledId;
    if (scrolledId) {
        const element = document.getElementById(scrolledId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => document.activeElement.blur(), 300);
        }
    }
});