var tooltipElements = document.querySelectorAll('.buttonHover'); // Select all elements with this class
    tooltipElements.forEach(function (tooltipEl) {
      new bootstrap.Tooltip(tooltipEl, {
        trigger: 'hover', // Show tooltip on hover
      });
    });


// Form autofocus
/*const modals = [
  { modalId: 'adminLoginModal', inputId: 'adminUsername' },
  { modalId: 'employeeLoginModal', inputId: 'employeeUsername' },
  { modalId: 'editProgramModal', inputId: 'editProgramName' },
  { modalId: 'addProjectModal', inputId: 'addProjectName' },
  { modalId: 'editProjectModal', inputId: 'editProjectName' },
  { modalId: 'addActivityModal', inputId: 'addActivityName' },
  { modalId: 'editActivityModal', inputId: 'editActivityName' },
  { modalId: 'addSubProjectModal', inputId: 'addSubProjectTitle' },
  { modalId: 'editSubProjectModal', inputId: 'editSubProjectName' },
  { modalId: 'addActivityInSubModal', inputId: 'addActivityName' }
];

modals.forEach(({ modalId, inputId }) => {
  document.getElementById(modalId).addEventListener('shown.bs.modal', function () {
      document.getElementById(inputId).focus();
  });
});*/