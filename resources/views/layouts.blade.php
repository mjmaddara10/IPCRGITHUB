<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Dynamic Title using Laravel Blade -->
    <title>@yield('title', 'IPCR')</title>

    <link rel="icon" href="{{ asset('img/NVLogo.png') }}" type="image/png">

    <!-- External CSS Libraries -->
    <!-- Bootstrap CSS - For responsive layout and components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome - For icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Typography -->
    <!-- Primary Font: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Application Specific Styles -->
    <!-- Custom Admin Styles -->
    <link href="{{ asset('Admin/admin.css') }}" rel="stylesheet">

    <!-- Additional Font Weights -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Alert System -->
    <!-- SweetAlert2 Library for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <!-- Navigation Section -->
    @yield('navbar')

    <!-- Main Content Area -->
    @yield('content')

    <!-- JavaScript Dependencies -->
    <!-- Bootstrap Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom Scripts -->
    <!-- Delete Confirmation Alerts -->
    <script src="{{ asset('js/delete.js') }}"></script>
    <!-- logout Confirmation Alerts -->
    <script src="{{ asset('js/logout.js') }}"></script>
     <!-- update Confirmation Alerts -->
    <script src="{{ asset('js/edit.js') }}"></script>
     <!-- add Confirmation Alerts -->
    <script src="{{ asset('js/add.js') }}"></script>
     <!-- SaveChanges Confirmation Alerts -->
    <script src="{{ asset('js/SaveChanges.js') }}"></script>
     <!-- login Confirmation Alerts -->
     <script src="{{ asset('js/login.js') }}"></script>
     <!-- viewPassword -->
     <script src="{{ asset('js/viewPassword.js') }}"></script>

    <script>
        $('#adminLoginModal').on('shown.bs.modal', function () {
            $('#adminUsername').focus();
        });
    </script>
</body>

</html>
