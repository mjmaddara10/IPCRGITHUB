var tooltipElements = document.querySelectorAll('.buttonHover'); // Select all elements with this class
    tooltipElements.forEach(function (tooltipEl) {
      new bootstrap.Tooltip(tooltipEl, {
        trigger: 'hover', // Show tooltip on hover
      });
    });

function applyAutoResize() {
    document.querySelectorAll('.auto-resize').forEach(textarea => {
        Object.assign(textarea.style, {
            overflow: 'hidden',
            resize: 'none',
            minHeight: '100px',
            paddingTop: '5px',
            boxSizing: 'border-box',
        });

        const resize = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };

        // Prevent multiple listeners
        textarea.removeEventListener('input', textarea._resizeListener);
        textarea._resizeListener = resize;
        textarea.addEventListener('input', resize);

        resize(); // Initial resize
    });
}

// On page load
document.addEventListener('DOMContentLoaded', applyAutoResize);

// Reuse for any modal with auto-resize textareas
function handleModalAutoResize(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.addEventListener('shown.bs.modal', () => {
            setTimeout(applyAutoResize, 1000);
        });
    }
}

// Attach to all your modals
['editProgramModal',
'editActivityModal',
'editSubActivityModal',
'viewAddProgramRequestModal',
'viewEditProgramRequestModal',
'viewDeleteProgramRequestModal',
'viewAddActivityRequestModal',
'viewDeleteActivityRequestModal',
'viewAddSubActivityRequestModal',
'viewSubEditActivityRequestModal',].forEach(handleModalAutoResize);