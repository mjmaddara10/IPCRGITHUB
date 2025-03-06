@extends('layouts')

@section('content')
@section('navbar')
<style>
    /* General Navbar Styling */
    .navbar {
        height: 55px;
        /* Set navbar height */
        padding-top: 0;
        padding-bottom: 0;
        display: flex;
        align-items: center;
        /* Centers navbar content */
    }

    .navbar-brand img {
        height: 50px;
        /* Adjust logo height */
        margin-bottom: 7px;
        margin-right: 10px;
        margin-top: 5px;
    }

    .navbar-brand {
        display: inline-flex;
        align-items: center;
    }

    /* IPCR Text */
    .ipcr-bold {
        font-weight: 1000;
        /* Maximum boldness */
        font-size: 2.2rem;
        /* Title size */
        color: #03592c;
    }

    input.form-control {
        margin-bottom: 10px;
    }
</style>

<nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom" style="height: 55px; width: 100%;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left-aligned Logo & Text -->
        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="#">
            <img src="{{ asset('images/NVLogo.png') }}" alt="NV Logo" class="me-2"
                style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
            <span style="font-weight: 1000; font-size: 2.2rem; color: #03592c;">IPCR</span>
        </a>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex gap-2">
                <!-- Button to Open Modal -->
                <a href="{{ route('admin.dashboard') }}" class="btn text-white mr-2"
                    style="background-color: #03592c; font-family: 'Montserrat', sans-serif;">
                    Assign Targets
                </a>
                <a href="#" class="btn text-white" id="logoutBtn"
                    style="background-color: #bc0c0c; font-family: 'Montserrat', sans-serif;">
                    Logout
                </a>

            </div>
        </div>
    </div>
    </div>
    </div>
</nav>




<!-- Gradient Bar -->
<div style="background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03); height: 10px; width: 100%;"></div>


<div class="container-fluid text-white p-3 d-flex flex-column justify-content-center"
    style="background-color: #03592c; height: auto; font-family: Montserrat, sans-serif;">
    <h1 class="fw-bold text-white" style="font-weight: 900;"> MANAGE USERS</h1>
    <div class="row align-items-center justify-content-between text-center">
        <!-- User Selection -->
        <div
            class="col-lg-6 col-md-12 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
            <label for="userSelect" class="form-label mb-0 me-2 ml-5" style="font-family: 'Montserrat';">Select
                User:</label>
            <select id="userSelect" class="form-select p-1 ml-2" style="width: 270px; border-radius: 4px;">
                <option value=""></option>
            </select>
        </div>
        <!-- Buttons Section -->
        <div class="col-lg-6 col-md-12 d-flex flex-wrap gap-2 justify-content-center justify-content-lg-end">
            <button class="btn text-white px-3 ml-2"
                style="background-color: #dd9f03; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.8); font-family: 'Montserrat';"
                data-bs-toggle="modal" data-bs-target="#adduserModal">
                Add User
            </button>
        </div>
    </div>
</div>


<img src="{{ asset('backgroundimage.jpg') }}" alt="Background image"
    class="img-fluid w-100 vh-100 position-absolute top-0 start-0"
    style="object-fit: cover; opacity: 0.4; z-index: -1;">

<div class="container my-4 d-flex justify-content-center">
    <div class="col-md-9">
        <div class="row g-3 justify-content-center">
            <div class="col-md-6 d-flex align-items-center">
                <label for="first-name" class="form-label me-2"
                    style="margin-left: 20px; color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">First
                    Name:</label>
                <input type="text" id="first-name" class="form-control"
                    style="width: 300px; border: 3px solid #03592c; padding: 10px;">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <label for="username" class="form-label me-2"
                    style="color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">Username:</label>
                <input type="text" id="username" class="form-control"
                    style="width: 300px; border: 3px solid #03592c; padding: 10px;">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <label for="middle-name" class="form-label me-2"
                    style="color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">Middle Name:</label>
                <input type="text" id="middle-name" class="form-control"
                    style="width: 300px; border: 3px solid #03592c; padding: 10px;">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <label for="password" class="form-label me-2"
                    style="margin-left: 5px; color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">Password:</label>
                <input type="password" id="password" class="form-control"
                    style="width: 300px; border: 3px solid #03592c; padding: 10px;">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <label for="last-name" class="form-label me-2"
                    style="margin-left: 20px; color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">Last
                    Name:</label>
                <input type="text" id="last-name" class="form-control"
                    style="width: 300px; border: 3px solid #03592c; padding: 10px;">
            </div>
            <div class="col-md-6 d-flex align-items-center">

            </div>
            <div class="col-md-6 d-flex align-items-center">
                <label for="middle-name" class="form-label me-2"
                    style="color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">Middle Name:</label>
                <input type="text" id="middle-name" class="form-control"
                    style="width: 300px; border: 3px solid #03592c; padding: 10px;">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <label for="status" class="form-label me-2"
                    style="margin-left: 30px; color: #03592c;   font-weight: bolder; font-family: 'Montserrat'">Status:</label>
                <select id="status" class="form-select"
                    style="width: 300px; border: 3px solid #03592c;  padding: 10px;">
                    <option value="">Select status</option>
                </select>
            </div>
            <div class="col-md-12"><!-- Empty div to maintain layout -->
                <div class="col-md-6 d-flex align-items-center">
                    <label for="division" class="form-label me-2"
                        style="margin-left: 26px; color: #03592c;  font-weight: bolder; font-family: 'Montserrat'">Division:</label>
                    <select id="division" class="form-select"
                        style="width: 300px; border: 3px solid #03592c; padding: 10px;">
                        <option value="">Select division</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex mt-4" style="margin-left: 122px;">
            <button class="btn text-white me-2"
                style="box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.8); padding: 10px; background-color: #0d5cba; border-radius: 5px; border: none;">Edit
                User</button>
            <button class="btn btn-danger"
                style="box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.8); border-radius: 5px; padding: 10px; background-color: #bc0c0c;">Delete
                User</button>
        </div>

    </div>
</div>
</div>



<!-- Modal for USER ACCOUNT REGISTRATION  -->
<div class="modal fade" id="adduserModal" tabindex="-1" aria-labelledby="userAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title w-100" id="userAccountModalLabel"
                    style="font-family: 'Montserrat'; font-weight: 700; color: #03592c; font-size: 2.5rem;">
                    <i class="fa-solid fa-user-plus mr-2"></i>USER ACCOUNT REGISTRATION
                </h1>
            </div>
            <div class="modal-body" style="background-color: #eaeaea;">
                <form class="mt-3 w-100" method="POST">
                    @csrf <!-- CSRF Token for security -->
                    <div class="container">
                        <table class="w-100" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c; width: 20%;">First
                                        Name:</td>
                                    <td>
                                        <input type="text" class="form-control" id="first-name" name="first_name"
                                            style="width: 300px; margin-left: 10px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Middle Name:</td>
                                    <td>
                                        <input type="text" class="form-control" id="middle-name" name="middle_name"
                                            style="width: 300px; margin-left: 10px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Last Name:</td>
                                    <td>
                                        <input type="text" class="form-control" id="last-name" name="last_name"
                                            style="width: 300px; margin-left: 10px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Position:</td>
                                    <td>
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="position" name="position"
                                                    style="width: 300px; margin-left: 10px;">
                                            </div>
                                            <label for="status" class="col-md-2 col-form-label text-end"
                                                style="font-weight: 700; color: #03592c;">Status:</label>
                                            <div class="col-md-4">
                                                <select class="form-select" id="status" name="status"
                                                    style="width: 150px; margin-left: 10px;">
                                                    <option selected disabled>Choose option</option>
                                                    <option value="Casual">Casual</option>
                                                    <option value="COS">COS</option>
                                                    <option value="Permanent">Permanent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Division:</td>
                                    <td>
                                        <input type="text" class="form-control" id="division" name="division"
                                            style="width: 300px; margin-left: 10px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <!-- Modal Footer Buttons -->
            <div class="modal-footer d-flex justify-content-center" style="background-color: #eaeaea;">
                <button type="button" data-bs-dismiss="modal" class="btn btn-danger"
                    style="font-family: 'Montserrat'; padding: 10px; width: 150px; background-color: #bc0c0c; border: none; outline: none; color: white; font-size: 16px; font-weight: bold; border-radius: 5px; cursor: pointer; text-align: center;">
                    Cancel
                </button>
                <button type="submit" class="btn ms-2"
                    style="font-family: 'Montserrat'; padding: 10px; width: 120px; background-color: #03592c; border: none; color: white; font-size: 14px; font-weight: bold; border-radius: 5px; cursor: pointer;">
                    Add
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Modal for User Account Modification -->
<div class="modal fade" id="EditUserModal" tabindex="-1" aria-labelledby="userAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title w-100"
                    style="font-family: 'Montserrat'; font-weight: 700; color: #03592c; font-size: 2.5rem;">
                    USER ACCOUNT MODIFICATION
                </h1>
            </div>
            <div class="modal-body" style="background-color: #eaeaea;">
                <form class="mt-3 w-100" method="POST">
                    @csrf <!-- CSRF Token for security -->
                    <div class="container">
                        <table class="w-100" style="border-collapse: collapse;">
                            <tbody>
                                <!-- Select User -->
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c; width: 20%;">Select
                                        User:</td>
                                    <td>
                                        <select class="form-select" id="nameOption" name="user_id"
                                            style="width: 250px; margin-bottom: 10px; margin-left: 10px;">
                                            <option selected disabled>Choose option</option>
                                            <option value="nickname">Nickname</option>
                                            <option value="middleName">Middle Name</option>
                                            <option value="suffix">Suffix</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- First Name & Username -->
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">First Name:</td>
                                    <td>
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="firstName" name="first_name"
                                                    style="width: 250px; margin-bottom: 10px; margin-left: 10px;">
                                            </div>
                                            <label for="username" class="col-md-2 col-form-label text-end"
                                                style="font-weight: 700; color: #03592c;">
                                                Username:
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="username" name="username"
                                                    style="width: 240px;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Middle Name & Password -->
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Middle Name:</td>
                                    <td>
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="middleName"
                                                    name="middle_name"
                                                    style="width: 250px; margin-bottom: 10px; margin-left: 10px;">
                                            </div>
                                            <label for="password" class="col-md-2 col-form-label text-end"
                                                style="font-weight: 700; color: #03592c;">
                                                Password:
                                            </label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" style="width: 115px;">
                                                    <span class="input-group-text" onclick="togglePassword()"
                                                        style="cursor: pointer;">
                                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Last Name -->
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Last Name:</td>
                                    <td>
                                        <input type="text" class="form-control" id="lastName" name="last_name"
                                            style="width: 250px; margin-bottom: 10px; margin-left: 10px;">
                                    </td>
                                </tr>
                                <!-- Position & Status -->
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Position:</td>
                                    <td>
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="position" name="position"
                                                    style="width: 250px; margin-bottom: 10px; margin-left: 10px;">
                                            </div>
                                            <label for="status" class="col-md-2 col-form-label text-end"
                                                style="font-weight: 700; color: #03592c;">
                                                Status:
                                            </label>
                                            <div class="col-md-4">
                                                <select class="form-select" id="status" name="status"
                                                    style="width: 240px; margin-bottom: 10px;">
                                                    <option selected disabled>Choose option</option>
                                                    <option value="Casual">Casual</option>
                                                    <option value="COS">COS</option>
                                                    <option value="Permanent">Permanent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Division -->
                                <tr>
                                    <td class="text-end" style="font-weight: 700; color: #03592c;">Division:</td>
                                    <td>
                                        <input type="text" class="form-control" id="division" name="division"
                                            style="width: 250px; margin-bottom: 10px; margin-left: 10px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center" style="background-color: #eaeaea;">
                <button type="button" data-bs-dismiss="modal" class="btn btn-danger"
                    style="font-family: 'Montserrat'; padding: 10px; width: 150px; background-color: #bc0c0c; border: none; outline: none; color: white; font-size: 16px; font-weight: bold; border-radius: 5px; cursor: pointer; text-align: center;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-success"
                    style="font-family: 'Montserrat'; padding: 10px; width: 150px; background-color: #03592c; border: none; outline: none; color: white; font-size: 16px; font-weight: bold; border-radius: 5px; cursor: pointer; text-align: center;">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>





@endsection
