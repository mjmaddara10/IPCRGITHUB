{{-- ==================== LAYOUT CONFIGURATION ==================== --}}
@extends('layouts')
@section('title', 'IPCR')

{{-- ==================== NAVBAR SECTION ==================== --}}
@section('navbar')
<nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom" style="height: 55px; width: 100%;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left-aligned Logo & Text -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="#">
            <img src="{{ asset('images/NVLogo.png') }}" alt="NV Logo" class="me-2"
                style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
            <span style="font-weight: 1000; font-size: 2.2rem; color: #03592c;">IPCR</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#loginModal">Login</a>
        </div>
    </div>
</nav>

<!-- Gold Line Separator -->
<div style="background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03); height: 10px; width: 100%;"></div>
@endsection

{{-- ==================== MAIN CONTENT SECTION ==================== --}}
@section('content')
<!-- Hero Section -->
<header class="hero-section">
    <div class="overlay"></div>
    <div class="container text-center text-white" style="padding: 10px;">
        <h1 style="font-size: 90px; margin-bottom: 0;">INDIVIDUAL PERFORMANCESwdwadawd</h1>
        <h1 style="font-size: 63px; margin-bottom: 0; line-height: 0.10;">COMMITMENT AND REVIEW (TARGETS)</h1>
        <p class="lead" style="font-size: 15px; font-weight: bold; margin-bottom: 0; line-height: 4; font-family: 'Montserrat';">
            <span style="display: inline-block; letter-spacing: 15px;">
                PROVINCE&nbsp;OF&nbsp;NUEVA&nbsp;VIZCAYA
            </span>
        </p>
    </div>
</header>

<!-- Login Modal Structure -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 350px;">
        <div class="modal-content" style="border-radius: 15px; margin-top: 18%;">
            <!-- Modal Header Tabs -->
            <div class="modal-header p-0" style="border-bottom: none; border-top-left-radius: 15px; border-top-right-radius: 15px; overflow: hidden;">
                <div class="row w-100 m-0">
                    <div id="userTab" class="col-6 text-center py-2" style="cursor: pointer; background-color: #03592c; color: white; font-weight: 900; font-family: 'Montserrat';">USER</div>
                    <div id="adminTab" class="col-6 text-center py-2" style="cursor: pointer; color: #03592c; font-weight: 900; font-family: 'Montserrat';">ADMIN</div>
                </div>
            </div>

            <!-- Modal Forms Container -->
            <div class="modal-body">
                <!-- User Login Form -->
                <div id="userForm">
                    <form>
                        <!-- Username Field -->
                        <div class="form-group" style="text-align: center; color: #03592c; font-weight: bold; font-family: 'Montserrat'">
                            <label for="User_UsernameLabel">Username</label>
                            <input type="text" id="User_UsernameLabel" class="form-control" style="border-color: #03592c; border-width: 3px; margin: 0 2px;">
                        </div>
                        <!-- Password Field -->
                        <div class="form-group text-center" style="color: #03592c; font-weight: bold; font-family: 'Montserrat'">
                            <label for="User_PasswordLabel">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" id="User_Password" class="form-control" style="border-color: #03592c; border-width: 3px; margin: 0 2px;">
                                <span class="input-group-text" onclick="toggleUserPassword()" style="cursor: pointer; background: white; border-color: #03592c;">
                                    <i id="userEyeIcon" class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <!-- Forgot Password Link -->
                        <p class="d-block mb-3" style="text-decoration: none; color: #07aa4d; text-decoration: underline; text-align: center;">
                            Forgot Your Password? Consult Your Administrator
                        </p>
                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 180px; border-radius: 5px; margin-right: 5px; background-color: #bc0c0c;">Cancel</button>
                            <button type="submit" class="btn btn-success" style="width: 180px; background-color: #03592c; border-radius: 5px;">Login</button>
                        </div>
                    </form>
                </div>

                <!-- Admin Login Form -->
                <div id="adminForm" style="display: none;">
                    <form>
                        <!-- Username Field -->
                        <div class="form-group" style="text-align: center; color: #03592c; font-weight: bold; font-family: 'Montserrat'">
                            <label for="Admin_UsernameLabel">Username</label>
                            <input type="text" class="form-control mb-3" style="border-color: #03592c; border-width: 3px; margin: 0 2px;">
                        </div>
                        <!-- Password Field -->
                        <div class="form-group text-center" style="color: #03592c; font-weight: bold; font-family: 'Montserrat'">
                            <label for="Admin_PasswordLabel">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="Admin_Password" style="border-color: #03592c; border-width: 3px; margin: 0 2px;">
                                <span class="input-group-text" onclick="toggleAdminPassword()" style="cursor: pointer; background: white; border-color: #03592c;">
                                    <i id="adminEyeIcon" class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <!-- Forgot Password Link -->
                        <p class="d-block mb-3" style="text-decoration: none; color: #07aa4d; text-decoration: underline; text-align: center;">
                            Forgot Your Password? Consult Your Administrator
                        </p>
                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 180px; border-radius: 5px; margin-right: 5px; background-color: #bc0c0c;">Cancel</button>
                            <button type="submit" class="btn btn-success" style="width: 180px; background-color: #03592c; border-radius: 5px;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ==================== JAVASCRIPT SECTION ==================== --}}
@section('scripts')
<!-- Tab Toggle Script -->
<script>
    $(document).ready(function () {
        $('#adminTab').click(function () {
            $('#adminTab').css({ 'background-color': '#03592c', 'color': 'white' });
            $('#userTab').css({ 'background-color': 'white', 'color': '#03592c' });
            $('#adminForm').show();
            $('#userForm').hide();
        });

        $('#userTab').click(function () {
            $('#userTab').css({ 'background-color': '#03592c', 'color': 'white' });
            $('#adminTab').css({ 'background-color': 'white', 'color': '#03592c' });
            $('#userForm').show();
            $('#adminForm').hide();
        });
    });
</script>

<!-- Password Toggle Scripts -->
<script>
    function toggleAdminPassword() {
        var passwordField = document.getElementById("Admin_Password");
        var eyeIcon = document.getElementById("adminEyeIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }

    function toggleUserPassword() {
        var passwordField = document.getElementById("User_Password");
        var eyeIcon = document.getElementById("userEyeIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
@endsection
