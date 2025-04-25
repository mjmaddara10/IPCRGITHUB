var tooltipElements = document.querySelectorAll('.buttonHover'); // Select all elements with this class
    tooltipElements.forEach(function (tooltipEl) {
      new bootstrap.Tooltip(tooltipEl, {
        trigger: 'hover', // Show tooltip on hover
      });
    });

// Auto Resize in PPA crud
document.querySelectorAll('.auto-resize').forEach(textarea => {
    textarea.style.overflow = 'hidden';
    textarea.style.resize = 'none';
    textarea.style.minHeight = '100px';
    textarea.style.paddingTop = '5px';

    const resize = () => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    };
    textarea.addEventListener('input', resize);
    resize(); // Call once on load
});

// Edit Program Table Resize
function applyAutoResize() {
    document.querySelectorAll('.auto-resize').forEach(textarea => {
        textarea.style.overflow = 'hidden';
        textarea.style.resize = 'none';
        textarea.style.minHeight = '100px';
        textarea.style.paddingTop = '5px';
        textarea.style.boxSizing = 'border-box';

        const resize = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };

        textarea.removeEventListener('input', textarea._resizeListener);
        textarea._resizeListener = resize;
        textarea.addEventListener('input', resize);

        resize(); // Resize on load
    });
}

// Run on page load
document.addEventListener('DOMContentLoaded', applyAutoResize);

// Also run when modal opens (optional and useful)
const editModal = document.getElementById('editProgramModal');
if (editModal) {
    editModal.addEventListener('shown.bs.modal', () => {
        setTimeout(applyAutoResize, 100); // Ensure textarea is visible before measuring
    });
}

// Edit Activity Table Resize
function applyAutoResize() {
    document.querySelectorAll('.auto-resize').forEach(textarea => {
        textarea.style.overflow = 'hidden';
        textarea.style.resize = 'none';
        textarea.style.minHeight = '100px';
        textarea.style.paddingTop = '5px';
        textarea.style.boxSizing = 'border-box';

        const resize = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };

        textarea.removeEventListener('input', textarea._resizeListener);
        textarea._resizeListener = resize;
        textarea.addEventListener('input', resize);

        resize();
    });
}

document.addEventListener('DOMContentLoaded', applyAutoResize);

const editActivityModal = document.getElementById('editActivityModal');
if (editActivityModal) {
    editActivityModal.addEventListener('shown.bs.modal', () => {
        setTimeout(applyAutoResize, 100);
    });
}

// Edit Sub-Activity Table Resize
function applyAutoResize() {
    document.querySelectorAll('.auto-resize').forEach(textarea => {
        textarea.style.overflow = 'hidden';
        textarea.style.resize = 'none';
        textarea.style.minHeight = '100px';
        textarea.style.paddingTop = '5px';
        textarea.style.boxSizing = 'border-box';

        const resize = () => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        };

        textarea.removeEventListener('input', textarea._resizeListener);
        textarea._resizeListener = resize;
        textarea.addEventListener('input', resize);

        resize();
    });
}

document.addEventListener('DOMContentLoaded', applyAutoResize);

const editSubModal = document.getElementById('editSubActivityModal');
if (editSubModal) {
    editSubModal.addEventListener('shown.bs.modal', () => {
        setTimeout(applyAutoResize, 100);
    });
}