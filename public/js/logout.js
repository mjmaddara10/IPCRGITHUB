// JavaScript for logout with SweetAlert confirmation
document.getElementById('adminLogoutBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default behavior

    // Display the SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, log me out!',
        cancelButtonText: 'No, stay logged in'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, send the logout request via AJAX
            logoutAdmin();
        }
    });
});

// Function to send logout request using AJAX
function logoutAdmin() {
    fetch('/', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (response.ok) {
            // Redirect to the login page after logout
            window.location.href = '/';
        } else {
            Swal.fire('Error!', 'Logout failed, please try again.', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error!', 'Logout failed, please try again.', 'error');
    });
}
