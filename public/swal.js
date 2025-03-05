document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logoutBtn");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent immediate navigation

            Swal.fire({
                title: "Logout?",
                text: "Are you sure you want to logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#bc0c0c", // Red for confirm
                cancelButtonColor: "#404040", // Gray for cancel
                confirmButtonText: "Yes, Logout",
                cancelButtonText: "Cancel",
                reverseButtons: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timerProgressBar: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Logging Out...",
                        text: "Please wait...",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.href = "/"; // Redirect after animation
                        }
                    });
                }
            });
        });
    }
});

// Define logout URL dynamically
const logoutUrl = "{{ url('/') }}";
