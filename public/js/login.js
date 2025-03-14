// admin login confirmation
function confirmAdminLogin() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to login as Admin?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, login!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('adminLoginForm').submit();
        }
    });
}



// employee login confirmation
function confirmLogin(role) {
    Swal.fire({
        title: "Are you sure?",
        text: `Do you want to login as ${role}?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, login!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Add your login logic here
            document.getElementById(`${role.toLowerCase()}LoginForm`).submit();
        }
    });
}


/*
function confirmVerifierLogin() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to login as Verifier?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, login!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('verifierLoginForm').submit();
        }
    });
}
    */

/*
function confirmLogin(role) {
    Swal.fire({
        title: "Are you sure?",
        text: `Do you want to login as ${role}?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, login!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Add your login logic here
            document.getElementById(`${role.toLowerCase()}LoginForm`).submit();
        }
    });
} */
