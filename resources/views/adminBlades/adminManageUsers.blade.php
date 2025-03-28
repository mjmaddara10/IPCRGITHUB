<!-- View, add, edit, and delete users -->
<!-- Extends the main layout template -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Admin Manage Users')

<!-- Navigation Section -->
@section('navbar')
    @include('adminBlades.adminInclude')
@endsection

@section('content')
<div class="page-background"></div>
    <div class="container-fluid py-4">
        <div class="bg-white">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex align-items-center nv-green">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users fa-2x text-white me-3"></i>
                    <div>
                        <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Manage
                            Users</h4>
                        <small class="text-white-50">User Management</small>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table id="manageUserTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: #03592c;">ID</th>
                                <th style="color: #03592c;">First Name</th>
                                <th style="color: #03592c;">Middle Name</th>
                                <th style="color: #03592c;">Last Name</th>
                                <th style="color: #03592c;">Position</th>
                                <th style="color: #03592c;">Division</th>
                                <th style="color: #03592c;">Status</th>
                                <th style="color: #03592c;">Username</th>
                                <th style="color: #03592c;">Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->firstName }}</td>
                                <td>{{ $employee->middleName }}</td>
                                <td>{{ $employee->lastName }}</td>
                                <td>{{ $employee->position }}</td>
                                <td>{{ $employee->division }}</td>
                                <td>{{ $employee->status }}</td>
                                <td>{{ $employee->username }}</td>
                                <td>{{ $employee->password }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection