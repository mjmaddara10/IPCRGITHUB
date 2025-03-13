// ... existing delete functions ...

// edit user manageUser blade
function confirmEdit(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Save Changes?',
        text: "Are you sure you want to save the edited account details?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#03592c',
        cancelButtonColor: '#bc0c0c',
        confirmButtonText: 'Yes, save changes',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editUserForm').submit();
            Swal.fire(
                'Saved!',
                'Account details have been updated.',
                'success'
            );
        }
    });
}

// edit PPA'S
function confirmEditPpa() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save these changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, save changes!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Successfully Updated!',
                text: 'PPA has been updated',
                icon: 'success',
                showConfirmButton: true,
                confirmButtonColor: "#03592c",
                confirmButtonText: "OK"
            }).then(() => {
                document.getElementById('editPpaForm').submit();
                bootstrap.Modal.getInstance(document.getElementById('editPpaModal')).hide();
            });
        }
    });
}