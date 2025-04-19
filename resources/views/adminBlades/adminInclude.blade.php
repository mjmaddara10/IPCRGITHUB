<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-sm navbar-light border-bottom"
    style="height: 55px; width: 100%; background-color: #ffffff">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo and Brand Name -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center">
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2" style="height: 40px; width: auto" />
            <span class="brand-text" onclick="window.location.href='{{ route('admin.index') }}'" style="cursor: pointer;">SPMS</span>
        </a>

        <!-- User Info on the right -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Name + Position -->
            <div class="d-flex flex-column align-items-end text-end me-3">
                <span class="fw-bold text-success">{{ session('firstName') }} {{ session('middleInitial') }} {{ session('lastName') }}</span>
                <small class="text-muted">{{ session('position') }}</small>
            </div>
            <!-- Button -->
            <a href="{{ route('admin.settings') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                <i class="fas fa-user text-white mx-1"></i>
            </a>       
        </div>
    </div>
</nav>

<form id="logoutForm" action="{{ route('adminLogout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Decorative Gold Gradient Bar -->
<div style="background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03); height: 10px; width: 100%;"></div>