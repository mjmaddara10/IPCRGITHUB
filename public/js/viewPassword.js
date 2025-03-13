// Get all password toggle buttons
const toggleButtons = document.querySelectorAll('#togglePassword');

function togglePasswordVisibility(passwordInput, icon) {
    const isHidden = passwordInput.type === 'password';
    
    passwordInput.type = isHidden ? 'text' : 'password';
    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
}

toggleButtons.forEach(button => {
    button.addEventListener('click', function() {
        const passwordInput = this.closest('.input-group').querySelector('input[type="password"], input[type="text"]');
        const icon = this.querySelector('i');
        togglePasswordVisibility(passwordInput, icon);
    });
});