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
        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <!-- Provincial Logo -->
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2"
                style="height: 40px; width: auto;">
            <!-- System Name -->
            <span class="brand-text">IPCR</span>
        </a>
        <!-- Authentication Button Section -->
        <div class="d-flex align-items-center">
            <!-- Login Button -->
            <a href="" class="btn btn-success me-3">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </a>
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
@section('content')
<!-- Rest of your content remains the same -->
</div>
</div>
@endsection