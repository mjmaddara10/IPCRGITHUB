<!-- View, add, edit, and delete users -->
<!-- Extends the main layout template -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'View Users')

<!-- Navigation Section -->
@section('navbar')
    @include('viewBlades.include')
@endsection

@section('content')
<div class="page-background"></div>
<div style="transform: scale(0.75); transform-origin: top center; width: 133.33%; margin-left: -16.665%;">
    <div class="container-fluid mt-4 position-relative">
        <div class="row">
            <div class="col-12">
                <div class="bg-white">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center ms-auto">
                            @if($role === 'Division Chief')
                                <a href="{{ route('chief.audit') }}" class="btn btn-hover text-success fw-bold" style="background-color:rgb(230, 230, 230);">
                                    Audit Trail
                                </a>
                                <a href="{{ route('chief.viewEmployees') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    View Users
                                </a>
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
                                <a href="{{ route('head.audit') }}" class="btn btn-hover text-success fw-bold" style="background-color:rgb(230, 230, 230);">
                                    Audit Trail
                                </a>
                                <a href="{{ route('chief.viewEmployees') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    View Users
                                </a>
                                <a href="{{ route('head.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    View Targets
                                </a>
                                <a href="{{ route('head.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    Manage PPA
                                </a>
                                <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @endif
                                
                            </div>
                        </div>

                        <div class="card-header py-3 d-flex align-items-center nv-green">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users fa-2x text-white me-3"></i>
                                <div>
                                    <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Audit Trail</h4>
                                    <small class="text-white-50">View Actions of Administrators</small>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="table-responsive">
                                <table id="manageUserTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="color: #03592c;">Name</th>
                                            <th style="color: #03592c;">Role</th>
                                            <th style="color: #03592c;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection