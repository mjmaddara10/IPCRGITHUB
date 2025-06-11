<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Ajax -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic Title using Laravel Blade -->
    <title>@yield('title', 'IPCR')</title>

    <link rel="icon" href="{{ asset('img/NVLogo.png') }}" type="image/png">

    <!-- External CSS Libraries -->
    <!-- Bootstrap CSS - For responsive layout and components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome - For icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Typography -->
    <!-- Primary Font: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
     
    

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

    <!-- Custom Admin Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
</head>

<body>
    <!-- Navigation Section -->
    @yield('navbar')

    <!-- Main Content Area -->
    @yield('content')

    <!-- Logging out -->
    <form id="logoutForm" action="{{ route('userLogout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- JavaScript Dependencies -->
    <!-- Bootstrap Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom Scripts -->

    <!-- View Password -->
    <script src="{{ asset('js/viewPassword.js') }}"></script>

    <!-- Data Table -->
    <script src="{{ asset('js/dataTable.js') }}"></script>

    <!-- PPA Management -->
    <script src="{{ asset('js/ppaManagement/forms.js') }}"></script>
    <script src="{{ asset('js/ppaManagement/activity.js') }}"></script>
    <script src="{{ asset('js/ppaManagement/subActivity.js') }}"></script>
    <script src="{{ asset('js/ppaManagement/program.js') }}"></script>
    <script src="{{ asset('js/ppaManagement/sortCollapse.js') }}"></script>

    <!-- View Target -->
    <script src="{{ asset('js/ppaView/user.js') }}"></script>
    <script src="{{ asset('js/ppaView/program.js') }}"></script>
    <script src="{{ asset('js/ppaView/activity.js') }}"></script>
    <script src="{{ asset('js/ppaView/subActivity.js') }}"></script>

    <!-- Table Switching -->
    <script src="{{ asset('js/ppaManagement/manageTable.js') }}"></script>

    <!-- Hover on Button -->
    <script src="{{ asset('js/functionalities.js') }}"></script>

    <!-- GASS -->
    <script src="{{ asset('js/gassManagement/program.js') }}"></script>
    <script src="{{ asset('js/ppaView/gass.js') }}"></script>

    <!-- PPA Requests -->
    <script src="{{ asset('js/ppaRequests/program.js') }}"></script>
    <script src="{{ asset('js/ppaRequests/activity.js') }}"></script>
    <script src="{{ asset('js/ppaRequests/subActivity.js') }}"></script>
    <script src="{{ asset('js/ppaRequests/gass.js') }}"></script>

    <!-- PPA Approve -->
    <script src="{{ asset('js/ppaApprove/program.js') }}"></script>
    <script src="{{ asset('js/ppaApprove/activity.js') }}"></script>
    <script src="{{ asset('js/ppaApprove/subActivity.js') }}"></script>
    <script src="{{ asset('js/ppaApprove/gass.js') }}"></script>

    <!-- View Request Details -->
    <script src="{{ asset('js/requestDetails/program.js') }}"></script>
    <script src="{{ asset('js/requestDetails/activity.js') }}"></script>
    <script src="{{ asset('js/requestDetails/subActivity.js') }}"></script>
    <script src="{{ asset('js/requestDetails/gass.js') }}"></script>
</body>

</html>
