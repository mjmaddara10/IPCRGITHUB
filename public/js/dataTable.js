$(document).ready(function() {
    $('#manageUserTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "pageLength": 10,
        order: [[0, 'desc']]
    });

    $('#auditTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "pageLength": 10,
        order: [[0, 'desc']]
    });
});