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
<!-- <div class="page-background"></div> -->
<div style="transform: scale(0.75); transform-origin: top center; width: 133.33%; margin-left: -16.665%;">
    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-12">
                <div class="bg-white">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center ms-auto">
                            @if($role === 'Division Chief' || $role === 'Assistant Department Head')
                                <a href="{{ route('chief.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green" onclick="localStorage.clear();">
                                    Manage PPA
                                </a>
                                <a href="{{ route('chief.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    View Targets
                                </a>
                                
                                <div class="btn-group" style="margin-left: 3px;">
                                    <button type="button" class="btn btn-hover nv-green dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Lookup Tables
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('chief.audit') }}">Audit Trail</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('chief.viewEmployees') }}">View Users</a>
                                        </li>
                                    </ul>
                                </div>

                                <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @elseif($role === 'Department Head')
                                <a href="{{ route('head.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green" onclick="localStorage.clear();">
                                    Manage PPA
                                </a>
                                <a href="{{ route('head.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    View Targets
                                </a>

                                <div class="btn-group" style="margin-left: 3px;">
                                    <button type="button" class="btn btn-hover nv-green dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Lookup Tables
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('head.audit') }}">Audit Trail</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('head.viewEmployees') }}">View Users</a>
                                        </li>
                                    </ul>
                                </div>

                                <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @endif
                                
                            </div>
                        </div>

                        <div class="card-header py-3 d-flex align-items-center nv-green">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users fa-2x text-white me-3"></i>
                                <div>
                                    <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">View Users</h4>
                                    <small class="text-white-50">User Overview</small>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="table-responsive">
                                <table id="manageUserTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th style="color: #03592c;">ID</th> -->
                                            <th style="color: #03592c;">First Name</th>
                                            <th style="color: #03592c;">Middle Name</th>
                                            <th style="color: #03592c;">Last Name</th>
                                            <th style="color: #03592c;">Position</th>
                                            <th style="color: #03592c;">Division</th>
                                            <th style="color: #03592c;">Status</th>
                                            <th style="color: #03592c;">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <!-- <td>{{ $employee->id }}</td> -->
                                            <td>{{ $employee->firstName }}</td>
                                            <td>{{ $employee->middleName }}</td>
                                            <td>{{ $employee->lastName }}</td>
                                            <td>{{ $employee->position }}</td>
                                            <td>{{ $employee->division->name ?? '' }}</td>
                                            <td>{{ $employee->status }}</td>
                                            <td>{{ $employee->role }}</td>
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