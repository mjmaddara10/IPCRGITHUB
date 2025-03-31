var tooltipElements = document.querySelectorAll('.buttonHover'); // Select all elements with this class
    tooltipElements.forEach(function (tooltipEl) {
      new bootstrap.Tooltip(tooltipEl, {
        trigger: 'hover', // Show tooltip on hover
      });
    });