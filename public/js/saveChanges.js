
//admin Assign Save Changes
function confirmSave() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save these changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, save it!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Successfully Changed!',
                text: 'Your changes have been saved',
                icon: 'success',
                showConfirmButton: true,
                confirmButtonColor: "#03592c",
                confirmButtonText: "OK"
            }).then(() => {
                saveChanges();
            });
        }
    });
}

// add saving PPA'S
function confirmAddPpa() {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to add this PPA?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#03592c",
        cancelButtonColor: "#bc0c0c",
        confirmButtonText: "Yes, add it!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Successfully Added!',
                text: 'New PPA has been added',
                icon: 'success',
                showConfirmButton: true,
                confirmButtonColor: "#03592c",
                confirmButtonText: "OK"
            }).then(() => {
                document.getElementById('addPpaForm').submit();
                bootstrap.Modal.getInstance(document.getElementById('addPpaModal')).hide();
            });
        }
    });
}


