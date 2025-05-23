$(document).ready(function() {
    $('#manageUserTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "pageLength": 10,
        order: [[0, 'desc']]
    });

    $('#auditTrailTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        order: [[0, 'desc']],
    });

    $('#requestTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        order: [[0, 'desc']],
        language: {
            emptyTable: "No request submitted at the moment.",
        }
    });
});