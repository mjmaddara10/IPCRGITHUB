<!-- Extends the main layout template -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Admin Dashboard')

<!-- Navigation Section -->
@section('navbar')
<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-sm navbar-light border-bottom" style="height: 55px; width: 100%; background-color: #FFFFFF;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo and Brand Name -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center">
            <!-- Provincial Logo -->
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2"
                style="height: 40px; width: auto;">
            <!-- System Name -->
            <span class="brand-text">IPCR</span>
        </a>
        <!-- Authentication Button Section -->
        <div class="d-flex align-items-center">
            <!-- Login Button -->
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#loginAccountModal">Login</a>
        </div>
    </div>
</nav>
<!-- Decorative Gold Gradient Bar -->
<div style="background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03); height: 10px; width: 100%;"></div>

<!-- Hero Section - Main Header -->
<div class="container-fluid text-center text-white p-0 hero-section">
    <!-- Main Title -->
    <h1 class="hero-title">INDIVIDUAL PERFORMANCE</h1>
    <!-- Subtitle -->
    <h2 class="hero-subtitle">COMMITMENT AND REVIEW (TARGETS)</h2>
    <!-- Location/Institution -->
    <h3 class="hero-text">PROVINCE OF NUEVA VIZCAYA</h3>
</div>

@endsection
<!-- Main Content Section -->
<div class="modal fade" id="loginAccountModal" tabindex="-1" aria-labelledby="loginAccountModal"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header nv-green">
                <h5 class="modal-title" id="loginAccountModal">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
                    <div class="mb-3 row align-items-center">
                        <label for="createUsername"
                            class="col-sm-3 form-label text-end mb-0 modal-form-label">Username:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="createUsername" placeholder="Enter username">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="createPassword"
                            class="col-sm-3 form-label text-end mb-0 modal-form-label">Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="createPassword" placeholder="Enter password">
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer modal-bg">
                <button type="button" class="btn btn-hover px-4 nv-red" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-hover px-4 nv-green" form="loginAccountModal">Login</button>
            </div>
        </div>
    </div>
</div>

@section('content')
<!-- Rest of your content remains the same -->
</div>
</div>
@endsection
