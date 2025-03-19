<!-- Homepage + this will include the navbar section for admins -->
<!-- Extends the main layout template -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Admin Index')

<!-- Navigation Section -->
@section('navbar')
    @include('adminBlades.adminInclude')
@endsection

@section('content')
<div class="container-fluid text-center text-white p-0 hero-section">
    <!-- Main Title -->
    <h1 class="hero-title">INDIVIDUAL PERFORMANCE</h1>
    <!-- Subtitle -->
    <h2 class="hero-subtitle">COMMITMENT AND REVIEW (TARGETS)</h2>
    <!-- Location/Institution -->
    <h3 class="hero-text">PROVINCE OF NUEVA VIZCAYA</h3>
</div>

<!------------------------Modals------------------------------->

<!-- Admin Login Modal -->
<div class="modal fade" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="adminLoginModalLabel">
                    <i class="fas fa-user-shield me-2"></i>Admin Login
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form class="p-2" method="POST" action="{{ route('admin.index') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="adminUsername" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-control form-control-lg border-2" style="border-color: #03592c; background-color: #ffffff;" id="adminUsername" name="username" placeholder="Enter username" autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="adminPassword" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="password" class="form-control border-2" style="border-color: #03592c; background-color: #ffffff;" id="adminPassword" name="password" placeholder="Enter password">
                            <button class="btn btn-outline-secondary border-2" style="border-color: #03592c;" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-lg btn-hover px-4 nv-red" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-lg btn-hover px-4 nv-green" onclick="confirmAdminLogin()">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Employee Login Modal -->
<div class="modal fade" id="employeeLoginModalLabel" tabindex="-1" aria-labelledby="employeeLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="employeeLoginModalLabel">
                    <i class="fas fa-user-tie me-2"></i>Employee Login
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form class="p-2" id="employeeLoginForm" method="POST" action="{{ route('employee.index') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="employeeUsername" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-control form-control-lg border-2" style="border-color: #03592c; background-color: #ffffff;" id="employeeUsername" name="username" placeholder="Enter username">
                    </div>
                    <div class="mb-4">
                        <label for="employeePassword" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="password" class="form-control border-2" style="border-color: #03592c; background-color: #ffffff;" id="employeePassword" name="password" placeholder="Enter password">
                            <button class="btn btn-outline-secondary border-2" style="border-color: #03592c;" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-lg btn-hover px-4 nv-red" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-lg btn-hover px-4 nv-green" onclick="confirmLogin('Employee')">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </div>
        </div>
    </div>
</div>
@endsection