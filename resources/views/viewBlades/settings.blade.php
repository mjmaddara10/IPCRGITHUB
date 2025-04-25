@extends('layouts')

@section('title', 'User Profile')

@section('navbar')
@include('viewBlades.include')
@endsection

@section('content')
<div class="page-background"></div>
<div class="container mt-4 position-relative">
    <div class="row">
        <div class="col-12">
            <div class="bg-white">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center ms-auto">
                        @if($role === 'Division Chief')
                            <a href="{{ route('chief.audit') }}" class="btn btn-hover nv-green mb-1 me-1">Audit Trail</a>
                            <a href="{{ route('chief.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                View Targets
                            </a>
                            <a href="{{ route('chief.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                Manage PPA
                            </a>
                            <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                Logout
                            </a>
                        @elseif($role === 'Department Head')
                            <a href="{{ route('head.audit') }}" class="btn btn-hover nv-green mb-1 me-1">Audit Trail</a>
                            <a href="{{ route('head.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                View Targets
                            </a>
                            <a href="{{ route('head.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                Manage PPA
                            </a>
                            <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                Logout
                            </a>
                        @elseif($role === 'Staff')
                            <a href="{{ route('staff.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                View Targets
                            </a>
                            <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                Logout
                            </a>
                        @endif
                            
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex align-items-center nv-green">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cog fa-2x text-white me-3"></i>
                            <div>
                                <h4 class="mb-0 text-white"
                                    style="font-family: 'Montserrat', sans-serif; font-weight: 600;">User Profile</h4>
                                <small class="text-white-50">Personal Information</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <table class="table table-bordered table-fixed">
                                    <tr>
                                        <td class="info-label fw-bold text-end" style="color: #03592c;">Name:</td>
                                        <td class="bg-white">{{ session('firstName') }} {{ session('middleInitial') }} {{ session('lastName') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label fw-bold text-end" style="color: #03592c;">Position:</td>
                                        <td class="bg-white">{{ session('position') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label fw-bold text-end" style="color: #03592c;">Status:</td>
                                        <td class="bg-white">{{ session('status') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label fw-bold text-end" style="color: #03592c;">Division:</td>
                                        <td class="bg-white">{{ session('division_name') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-bordered table-fixed">
                                    <tr>
                                        <td class="info-label fw-bold text-end" style="color: #03592c;">Username:</td>
                                        <td class="bg-white">{{ session('username') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label fw-bold text-end" style="color: #03592c;">Password:</td>
                                        <td class="bg-white" id="showPassword">********</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2">
                                            <button type="button" onclick="togglePassword()" style="border: none; cursor: pointer;" class="btn btn-hover px-4 ms-2 nv-green">
                                                Show Password
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('showPassword');
        const button = event.target;

        if (passwordField.textContent === '********') {
            // Replace the asterisks with the actual password from the session
            passwordField.textContent = '{{ session('password') }}';
            button.textContent = 'Hide Password';
        } else {
            // Hide the password again
            passwordField.textContent = '********';
            button.textContent = 'Show Password';
        }
    }
</script>

@endsection
