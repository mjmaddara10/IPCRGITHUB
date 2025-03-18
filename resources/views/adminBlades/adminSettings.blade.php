@extends('layouts')

@section('title', 'Admin Settings')

@section('navbar')
    @include('adminBlades.adminInclude')
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

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-hover px-4 nv-red" onclick="confirmDelete()">
                                <i class="fas fa-trash-alt me-2"></i>Delete
                            </button>
                            <button type="button" class="btn btn-hover px-4 ms-2 nv-green" data-bs-toggle="modal"
                                data-bs-target="#adminAccountEditModal">
                                <i class="fas fa-edit me-2"></i>Update Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Update Admin Account Modal -->
<div class="modal fade" id="adminAccountEditModal" tabindex="-1" aria-labelledby="adminAccountEditModal" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 40%;">
        <div class="modal-content">

            <div class="modal-header nv-green">
                <h5 class="modal-title" id="adminAccountEditModal">
                    <i class="fas fa-edit me-2"></i>Admin Account Modification
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body modal-bg">
                <form action="{{ route('adminSettings') }}" method="POST">
                    @csrf
                    <div class="mb-3 row align-items-center">
                        <label for="updateName"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">First Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateFirstName" value="{{ session('firstName') }}" name="updateFirstName">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateName"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Middle Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateMiddleName" value="{{ session('middleName') }}" name="updateMiddleName">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateName"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Last Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateLastName" value="{{ session('lastName') }}" name="updateLastName">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updatePosition"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Position:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updatePosition" value="{{ session('position') }}" name="updatePosition">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateDivision"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Division:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateDivision" value="{{ session('division') }}" name="updateDivision">
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateStatus"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Status:</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="updateStatus" name="updateStatus">
                                <option value="Permanent" name="permanent">Permanent</option>
                                <option value="COS" name="COS">COS</option>
                                <option value="Casual" name="casual">Casual</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updateUsername"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Username:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="updateUsername" value="{{ session('username') }}" name="updateUsername" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label for="updatePassword"
                            class="col-sm-4 form-label text-end mb-0 modal-form-label">Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="updatePassword" value="{{ session('password') }}" name="updatePassword">
                        </div>
                    </div>
            </div>
                <div class="modal-footer modal-bg">
                    <button type="button" class="btn btn-hover px-4 nv-red" data-bs-dismiss="modal">Cancel</button>
                    <button type="Submit" class="btn btn-hover px-4 nv-green" >Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('message') == 'success')
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Admin details updated successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

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
