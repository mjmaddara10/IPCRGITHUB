<!-- view and export employee IPCR -->
<!-- view and export buttons only, wala nang "Save Changes" -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Admin viewIpcr')

<!-- Navigation Section -->
@section('navbar')
<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-sm navbar-light border-bottom"
    style="height: 55px; width: 100%; background-color: #ffffff">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo and Brand Name -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center">
            <!-- Provincial Logo -->
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2" style="height: 40px; width: auto" />
            <!-- System Name -->
            <span class="brand-text">IPCR</span>
        </a>
       <!-- Logout Button -->
       <div class="d-flex align-items-center">
        <a href="javascript:void(0)" onclick="confirmLogoutWithRedirect()" class="btn btn-hover px-4 nv-red">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
    </div>
    </div>
</nav>
<!-- Decorative Gold Gradient Bar -->
<div style="
        background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03);
        height: 10px;
        width: 100%;
    "></div>
@section('content')
<div class="page-background"></div>

@endsection
<!-- Main Content Section -->

@endsection