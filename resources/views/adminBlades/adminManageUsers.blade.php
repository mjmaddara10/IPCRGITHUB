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
            <!-- Add User Button
            <div class="mb-3">
                <button class="btn nv-green text-white" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus me-2"></i>Add User
                </button>
            </div> -->

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    Show
                    <select class="form-select mx-2" style="width: 70px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </div>
                <div class="d-flex align-items-center">
                    Search:
                    <input type="search" class="form-control ms-2" style="width: 200px;">
                </div>
            </div>

            <div class="table-responsive">
                <table id="usersTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="color: #03592c;">ID ▼</th>
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
                        <tr>
                            <td>1</td>
                            <td>John</td>
                            <td>Smith</td>
                            <td>Doe</td>
                            <td>Manager</td>
                            <td>HR</td>
                            <td>Permanent</td>
                            <td>johndoe</td>
                            <td>••••••••</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing 1 to 10 of 50 entries
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!----------------------------------Modals------------------------------------->
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="addUserForm" class="p-2">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">First Name:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="firstName"
                                required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Middle Name:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;"
                                name="middleName">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Last Name:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="lastName"
                                required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Position:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="position"
                                required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Division:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="division"
                                required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Employment Status:</label>
                            <select class="form-select border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="status"
                                required>
                                <option value="">Select Status</option>
                                <option value="permanent">Permanent</option>
                                <option value="casual">Casual</option>
                                <option value="cos">COS</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Username:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="username"
                                required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Password:</label>
                            <input type="password" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="password"
                                required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="addUserForm" class="btn btn-hover px-3 nv-green" onclick="confirmAdd(event)">
                    <i class="fas fa-save me-2"></i>Save User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editUserModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="editUserForm" class="p-2">
                    <input type="hidden" name="userId" id="editUserId">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">First Name:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="firstName"
                                id="editFirstName" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Middle Name:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;"
                                name="middleName" id="editMiddleName">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Last Name:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="lastName"
                                id="editLastName" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Position:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="position"
                                id="editPosition" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Division:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="division"
                                id="editDivision" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Employment Status:</label>
                            <select class="form-select border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="status"
                                id="editStatus" required>
                                <option value="">Select Status</option>
                                <option value="permanent">Permanent</option>
                                <option value="casual">Casual</option>
                                <option value="cos">COS</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Username:</label>
                            <input type="text" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="username"
                                id="editUsername" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-1">Password:</label>
                            <input type="password" class="form-control border-2"
                                style="border-color: #03592c; background-color: #ffffff; height: 35px;" name="password"
                                id="editPassword" placeholder="Leave blank to keep current">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="editUserForm" class="btn btn-hover px-3 nv-green" onclick="confirmEdit(event)">
                    <i class="fas fa-save me-2"></i>Update User
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
