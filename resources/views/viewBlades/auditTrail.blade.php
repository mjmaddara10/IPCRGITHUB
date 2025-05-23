<!-- View, add, edit, and delete users -->
<!-- Extends the main layout template -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Audit Trail')

<!-- Navigation Section -->
@section('navbar')
    @include('viewBlades.include')
@endsection

@section('content')
<!-- <div class="page-background"></div> -->
<div>
    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-12">
                <div class="bg-white">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center ms-auto pt-3">
                                @if($role === 'Division Chief')
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
                                                <a class="dropdown-item default-text" href="{{ route('chief.audit') }}">Audit Trail</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item default-text" href="{{ route('chief.viewEmployees') }}">View Users</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                        Logout
                                    </a>
                                @elseif($role === 'Department Head' || $role === 'Assistant Department Head')
                                    <a href="{{ route('head.approve') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                        Review Requests
                                    </a>
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
                                                <a class="dropdown-item default-text" href="{{ route('head.audit') }}">Audit Trail</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item default-text" href="{{ route('head.viewEmployees') }}">View Users</a>
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
                                    <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Audit Trail</h4>
                                    <small class="text-white-50">View Actions of Administrators</small>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="table-responsive">
                                <table id="auditTrailTable" class="table table-hover" style="table-layout: fixed; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="color: #03592c; width: 8%;">Date/Time</th>
                                            <th style="color: #03592c; width: 13%;">Name</th>
                                            <th style="color: #03592c; width: 8%;">Role</th>
                                            <th style="color: #03592c; width: 12%;">Program Name</th>
                                            <th style="color: #03592c; width: 18%;">Actions</th>
                                            <th style="color: #03592c; width: 20%;">From</th>
                                            <th style="color: #03592c; width: 20%;">To</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach ($auditTrails as $audit)
                                            <tr>
                                                <td data-order="{{ $audit->created_at }}">
                                                    {{ \Carbon\Carbon::parse($audit->created_at)->format('F j, Y') }}<br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($audit->created_at)->format('g:i A') }}</small>
                                                </td>
                                                <td>{{ $audit->full_name }}</td>
                                                <td>{{ ucfirst($audit->role) }}</td>
                                                <td>{{ $audit->program_name ?? '—' }}</td>
                                                <td>{{ $audit->action }}</td>
                                                <td>{{ $audit->action_from ?? '—' }}</td>
                                                <td>{{ $audit->action_to ?? '—' }}</td>
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
