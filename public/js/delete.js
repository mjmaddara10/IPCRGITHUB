//delete modal Settings
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete your account?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#03592c',
        cancelButtonColor: '#bc0c0c',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add your delete logic here
            Swal.fire(
                'Deleted!',
                'Your account has been deleted.',
                'success'
            );
        }
    });
}

//delete modal manageUsers
function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#03592c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add  delete logic here
            Swal.fire(
                'Deleted!',
                'User has been deleted.',
                'success'
            )
        }
    })
}

//delete PPA'S
function deletePpa(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this PPA? This cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Successfully Deleted!',
                text: 'PPA has been removed',
                icon: 'success',
                showConfirmButton: true,
                confirmButtonColor: "#03592c",
                confirmButtonText: "OK"
            }).then(() => {
            });
        }
    });
}
