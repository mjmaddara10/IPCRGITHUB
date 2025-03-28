@extends('layouts')

@section('title', 'Employee Settings')

@section('navbar')
<nav class="navbar navbar-expand-sm navbar-light border-bottom bg-white" style="height: 55px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="{{ route('admin.index') }}">
            <img src="{{ asset('img/NVLogo.png') }}" alt="NV Logo" class="me-2" style="height: 40px; width: auto;">
            <span class="brand-text">SPMS</span>
        </a>

        <div class="d-flex align-items-center">
            <a href="javascript:void(0)" onclick="confirmLogoutWithRedirect()" class="btn btn-hover px-4 nv-red">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
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
                                style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Employee Settings</h4>
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
                                    <td class="bg-white">Marc Jay H. Maddara</td>
                                </tr>
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">Position:</td>
                                    <td class="bg-white">Administrative Aide III (Clerk I)</td>
                                </tr>
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">Status:</td>
                                    <td class="bg-white">Permanent</td>
                                </tr>
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">Division:</td>
                                    <td class="bg-white">PITD</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered table-fixed">
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">User Name:</td>
                                    <td class="bg-white">Marc Jay H. Maddara</td>
                                </tr>
                                <tr>
                                    <td class="info-label fw-bold text-end" style="color: #03592c;">Password:</td>
                                    <td class="bg-white">********</td>
                                </tr>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-hover px-4 nv-red" onclick="confirmDelete()">
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-hover px-4 ms-2 nv-green" data-bs-toggle="modal"
                                data-bs-target="#employeeAccountModal">
                                <i class="fas fa-edit me-2"></i>Update Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="employeeAccountModal" tabindex="-1" aria-labelledby="employeeAccountModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header nv-green">
                    <h5 class="modal-title" id="employeeAccountModal">
                        <i class="fas fa-edit me-2"></i>Update Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body modal-bg">
                    <form id="employeeAccountForm">
                        @csrf
                        <div class="mb-3 row align-items-center">
                            <label for="updateName" class="col-sm-4 form-label text-end mb-0 modal-form-label">First
                                Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="updateName" value="" name="">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="updateName" class="col-sm-4 form-label text-end mb-0 modal-form-label">Middle
                                Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="updateName" value="" name="">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="updateName" class="col-sm-4 form-label text-end mb-0 modal-form-label">Last
                                Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="updateName" value="" name="">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="updatePosition"
                                class="col-sm-4 form-label text-end mb-0 modal-form-label">Position:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="updatePosition" value="" name="">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="updateDivision"
                                class="col-sm-4 form-label text-end mb-0 modal-form-label">Division:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="updateDivision" value="" name="">
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
                                <input type="text" class="form-control" id="updateUsername" value="" name="">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="updatePassword"
                                class="col-sm-4 form-label text-end mb-0 modal-form-label">Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="updatePassword" value="" name="">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer modal-bg">
                    <button type="button" class="btn btn-hover px-4 nv-red" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-hover px-4 nv-green" onclick="employeeUpdateAccount()">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
