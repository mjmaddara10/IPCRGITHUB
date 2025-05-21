@extends('layouts')

@section('title', 'User Profile')

@section('navbar')
@include('viewBlades.include')
@endsection

@section('content')
<div class="page-background"></div>
<div class="container mt-2 position-relative">
    <div class="row">
        <div class="col-12">
            <div class="bg-white">
                <div class="p-1">
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
                                <ul class="dropdown-menu default-text">
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
                                <ul class="dropdown-menu default-text">
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
                        @elseif($role === 'Staff')
                            <a href="{{ route('staff.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                View Targets
                            </a>
                            <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                Logout
                            </a>
                        @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card h-100 nv-green shadow">
                <div class="card-body">
                    <h5 class="card-title">Manage PPA</h5>
                    <p class="card-text">View, add, edit, and delete PPAs.</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 nv-green shadow">
                <div class="card-body">
                    <h5 class="card-title">VIew Targets</h5>
                    <p class="card-text">View all the users' targets.</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 nv-green shadow">
                <div class="card-body">
                    <h5 class="card-title">Lookup Tables</h5>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 nv-green shadow">
                <div class="card-body">
                    <h5 class="card-title">User Profile</h5>
                    <p class="card-text">Your Information</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
