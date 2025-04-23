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
    textarea.style.paddingTop = '5px';  // Ensure padding for text alignment

    const resize = () => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    };
    textarea.addEventListener('input', resize);
    resize(); // Call once on load in case of pre-filled content
});