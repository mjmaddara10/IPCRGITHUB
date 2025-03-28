<!-- view and export employee IPCR -->
<!-- view and export buttons only, wala nang "Save Changes" -->
 <!-- view and export employee IPCR -->
<!-- view and export buttons only, wala nang "Save Changes" -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Employee IPCR')

<!-- Navigation Section -->
@section('navbar')
<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-sm navbar-light border-bottom fixed-top"
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
        position: fixed;
        top: 55px;
        z-index: 1030;
    "></div>
@section('content')
<div class="page-background"></div>

@endsection
<!-- Main Content Section -->
<!-- DataTable -->
<div style="padding-top: 70px;">
    <div class="container-fluid mt-2">
        <div class="bg-white">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex align-items-center nv-green">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user fa-2x text-white me-3"></i>
                    <div>
                        <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                            Employee IPCR </h4>
                        <small class="text-white-50">View IPCR</small>
                    </div>
                </div>
            </div>

            <div class="p-4 nv-green">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="d-flex align-items-center" style="color: #FFFFFF; font-weight: 500;">
                        <span>View IPCR:</span>
                        <select class="form-select ms-2" style="width: 250px; border: 2px solid #FFFFFF;">
                            <option selected disabled></option>
                            <option value="1">User 1</option>
                            <option value="2">User 2</option>
                            <option value="3">User 3</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Full-width content container -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12"
                        style="font-family: 'Montserrat'; background: #0d5cba; padding: 50px; color: #FFFFFF; text-align: justify;">
                        <p class="justified-text">
                            I, JULIUS N. IGLESIAS, Administrative Officer IV (HRMO II)- Permanent of the PROVINCIAL
                            HUMAN
                            RESOURCE MANAGEMENT
                            OFFICE, BENEFITS AND WELFARE DIVISION, commit to deliver and agree to be rated on the
                            attainment
                            of
                            the following targets in accordance with the indicated measures for the period January to
                            December 2025.
                        </p>

                        <!-- Nested row for inputs -->
                        <div class="row mt-3 align-items-center">
                            <!-- First Row -->
                            <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                                style="font-size: 0.875rem;">
                                <h6 class="mb-0 me-1 text-nowrap">Reviewed by:</h6>
                                <select class="form-select" style="width: 100%;">
                                    <option value="">Select Reviewer</option>
                                    <option value="reviewer1">Marc Jay Maddara</option>
                                    <option value="reviewer2">Marc Justin Manzano</option>
                                    <option value="reviewer3">Reviewer 3</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                                style="font-size: 0.875rem;">
                                <h6 class="mb-0 me-1 text-nowrap" style="margin-left: 105px;"></h6>
                                <select class="form-select" style="width: 100%;">
                                    <option value="">Select Reviewer</option>
                                    <option value="reviewer1">Reviewer 1</option>
                                    <option value="reviewer2">Reviewer 2</option>
                                    <option value="reviewer3">Reviewer 3</option>
                                </select>
                            </div>
                            <!-- Second Row -->
                            <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                                style="font-size: 0.875rem;">
                                <h6 class="mb-0 me-1 text-nowrap" style="margin-left: 36px;">Position:</h6>
                                <input type="text" class="form-control" style="width: 100%;" placeholder="Position">
                            </div>
                            <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                                style="font-size: 0.875rem;">
                                <h6 class="mb-0 me-1 text-nowrap">Approved by:</h6>
                                <select class="form-select" style="width: 100%;">
                                    <option value="">Approved by:</option>
                                    <option value="department1">Department 1</option>
                                    <option value="department2">Department 2</option>
                                    <option value="department3">Department 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table Section -->
            <div class="container-fluid" style="padding: 0 0px;">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover" style="width: 100%;">
                        <thead class="text-center">
                            <tr>
                                <!-- <th style="color: #FFFFFF; background-color: #dd9f03;">Assign</th> -->
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Major Programs
                                    /Project/Activities
                                </th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Success Indicator</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Quality</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Efficiency</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Timeliness</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Remarks/MOV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #ffffff;">
                                <!-- <td class="text-center"><input type="checkbox"></td> -->
                                <td class="text-center">1.1 Prepare Training Calendar</td>
                                <td class="text-center">Success Indicator</td>
                                <td class="text-center">Quality</td>
                                <td class="text-center">Efficiency</td>
                                <td class="text-center">Timeliness</td>
                                <td class="text-center">Remarks</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Save Button -->
                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-start mb-3 ms-4">
                        <a href="javascript:void(0)" onclick="exportToPDF()" class="btn nv-red px-2">
                            <i class="fas fa-file-pdf me-2"></i> Export to PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endsection
