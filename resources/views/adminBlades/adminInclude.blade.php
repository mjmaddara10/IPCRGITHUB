<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-sm navbar-light border-bottom"
    style="height: 55px; width: 100%; background-color: #ffffff">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo and Brand Name -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center">
            <!-- Provincial Logo -->
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2" style="height: 40px; width: auto" />
            <!-- System Name -->
            <span class="brand-text" onclick="window.location.href='{{ route('admin.index') }}'" style="cursor: pointer;">SPMS</span>
        </a>
        <!-- Logout Button -->
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.manageUsers') }}" class="btn btn-hover px-4 nv-green">
               Manage Users
            </a>
            <a href="{{ route('admin.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover px-4 nv-green">
               View IPCR
            </a>
            <a href="{{ route('admin.assignIpcr') }}" style="margin-left: 3px;" href="" class="btn btn-hover px-4 nv-green">
               Assign PPA
            </a>
            <a href="{{ route('admin.managePpa') }}" style="margin-left: 3px;" href="" class="btn btn-hover px-4 nv-green">
               Manage PPA
            </a>
            <a href="{{ route('admin.settings') }}" style="margin-left: 3px;" href="" class="btn btn-hover px-4 nv-green">
               Settings
            </a>
            <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover px-4 nv-red">
               Logout
            </a>
        </div>
    </div>
</nav>

<!-- Decorative Gold Gradient Bar -->
<div style="background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03); height: 10px; width: 100%;"></div>