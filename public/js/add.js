//confirm add modal
/* add user manageUser Blade
function confirmAdd(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Add New User?',
        text: "Are you sure you want to add this user?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#03592c',
        cancelButtonColor: '#bc0c0c',
        confirmButtonText: 'Yes, add user',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('addUserForm').submit();
            Swal.fire(
                'Added!',
                'New user has been added successfully.',
                'success'
            );
        }
    });
}
    */
