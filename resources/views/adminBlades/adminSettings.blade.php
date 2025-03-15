@extends('layouts')

@section('title', 'Admin Settings')

@section('navbar')
<nav class="navbar navbar-expand-sm navbar-light border-bottom"
    style="height: 55px; width: 100%; background-color: #ffffff">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo and Brand Name -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center">
            <!-- Provincial Logo -->
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2" style="height: 40px; width: auto" />
            <!-- System Name -->
            <span class="brand-text">SPMS</span>
        </a>
        <!-- Logout Button -->
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.manageUsers') }}" class="btn btn-hover px-4 nv-green">
               Manage Users
            </a>
            <a href="{{ route('admin.managePpa') }}" style="margin-left: 3px;" href="" class="btn btn-hover px-4 nv-green">
                Manage PPA
             </a>
            <a href="{{ route('admin.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover px-4 nv-green">
               View IPCR
            </a>
            <a href="{{ route('admin.assignIpcr') }}" style="margin-left: 3px;" href="" class="btn btn-hover px-4 nv-green">
               Assign IPCR
            </a>
            <a href="{{ route('admin.settings') }}" style="margin-left: 3px;" href="" class="btn btn-hover px-4 nv-green">
               Settings
            </a>
            <a style="margin-left: 3px;" href="javascript:void(0)" onclick="confirmLogoutWithRedirect()" class="btn btn-hover px-4 nv-red">
               Logout
            </a>
        </div>
    </div>
</nav>
<div class="gold-gradient"></div>
@endsection

@section('content')
<div class="page-background"></div>
<div class="container mt-4 position-relative">
    <div class="row">
        <div class="col-12">

            <div class="bg-white">

                <div class="card-header py-3 d-flex align-items-center nv-green">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cog fa-2x text-white me-3"></i>
                        <div>
                            <h4 class="mb-0 text-white"
                                style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Admin Settings</h4>
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
                                    <td class="bg-white">{{ session('division') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered table-fixed">
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">User Name:</td>
                                    <td class="bg-white">{{ session('username') }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">Password:</td>
                                    <td class="bg-white">{{ session('password') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-hover px-4 nv-red" onclick="confirmDelete()">
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-hover px-4 ms-2 nv-green" data-bs-toggle="modal"
                                data-bs-target="#adminAccountModal">
                                <i class="fas fa-edit me-2"></i>Update Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Update Admin Account Modal -->
<div class="modal fade" id="adminAccountEditModal" tabindex="-1" aria-labelledby="adminAccountEditModal"
aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header nv-green">
                <h5 class="modal-title" id="adminAccountEditModal">
                    <i class="fas fa-edit me-2"></i>Admin Account Modification
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body modal-bg">
                <form method="POST" action="{{ route('admin.settings') }}">
                    @csrf
                    <div class="mb-3 row align-items-center">
                        <label for="updateName"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">First Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateName" value="{{ session('firstName') }}" name="">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateName"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Middle Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateName" value="{{ session('middleName') }}" name="">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateName"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Last Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateName" value="{{ session('lastName') }}" name="">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updatePosition"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Position:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updatePosition" value="{{ session('position') }}" name="">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateDivision"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Division:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateDivision" value="{{ session('division') }}" name="">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateStatus"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Status:</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="updateStatus">
                                <option value="Permanent" name="">Permanent</option>
                                <option value="COS" name="">COS</option>
                                <option value="Casual" name="">Casual</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateUsername"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Username:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateUsername" value="{{ session('username') }}" name="">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updatePassword"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="updatePassword" value="{{ session('password') }}" name="">
                        </div>
                    </div>
            </div>
                <div class="modal-footer modal-bg">
                    <button type="button" class="btn btn-hover px-4 nv-red" data-bs-dismiss="modal">Cancel</button>
                    <button type="Submit" class="btn btn-hover px-4 nv-green" onclick="adminUpdateAccount()">Save Changes</button>
                </div>
            </form>
        </div>
</div>
</div>
@endsection
