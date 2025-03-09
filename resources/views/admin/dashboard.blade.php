@extends('layouts')

@section('content')
@section('navbar')

{{-- ==================== STYLES SECTION ==================== --}}
<style>
    /* Custom Checkbox Styling */
    .custom-checkbox {
        width: 20px;
        height: 20px;
        background-color: #03592c;
        border: none;
        appearance: none;
        outline: none;
        cursor: pointer;
        position: relative;
        border-radius: 3px;
    }

    .custom-checkbox:checked::before {
        content: '\2713';
        font-size: 16px;
        color: white;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Modal Styles */
    .custom-modal { max-width: 90%; }
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
        font-family: 'Montserrat';
    }
    .modal-footer {
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }
    .form-control { border-radius: 8px; }
    .btn { border-radius: 8px; }

    @media (min-width: 1200px) {
        .modal-xl { max-width: 75%; }
    }

    /* Table Styles */
    .wrap-text {
        word-break: break-word;
        white-space: normal;
        overflow-wrap: break-word;
        padding: 8px;
    }
    table th, table td {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }
</style>

{{-- ==================== NAVBAR SECTION ==================== --}}
<nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom" style="height: 55px; width: 100%;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        {{-- Logo & Brand --}}
        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="#">
            <img src="{{ asset('images/NVLogo.png') }}" alt="NV Logo" class="me-2"
                style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
            <span style="font-weight: 1000; font-size: 2.2rem; color: #03592c;">IPCR</span>
        </a>

        {{-- Navbar Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navigation Items --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex gap-2">
                {{-- Assign Targets Button --}}
                <button class="btn text-white mr-2"
                    style="background-color: #03592c; font-family: 'Montserrat', sans-serif;" type="button">
                    Assign Targets
                </button>

                {{-- Settings Dropdown --}}
                <div class="dropdown">
                    <button class="btn text-white mr-2 dropdown-toggle"
                        style="background-color: #0d5cba; font-family: 'Montserrat', sans-serif;" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Settings
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                        <li><a class="dropdown-item" href="{{ url('/admin/myprofile') }}">My Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/manageuser') }}">Manage Users</a></li>
                    </ul>
                </div>

                {{-- Logout Button --}}
                <a href="#" class="btn text-white" id="logoutBtn"
                    style="background-color: #bc0c0c; font-family: 'Montserrat', sans-serif;">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Gradient Bar --}}
<div style="background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03); height: 10px; width: 100%;"></div>
@endsection

{{-- ==================== HEADER SECTION ==================== --}}
<div class="container-fluid text-white p-3 d-flex flex-column justify-content-center"
    style="background-color: #03592c; height: auto; font-family: Montserrat, sans-serif;">
    <h1 class="fw-bold text-white" style="font-weight: 900;">WELCOME, ADMIN</h1>
    <div class="row align-items-center justify-content-between text-center">
        {{-- User Selection --}}
        <div class="col-lg-6 col-md-12 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
            <label for="userSelect" class="form-label mb-0 me-2 ml-5">Select User:</label>
            <select id="userSelect" class="form-select p-1 ml-2" style="width: 250px; border-radius: 4px;">
                <option value=""></option>
            </select>
        </div>
        {{-- PDF Button --}}
        <div class="col-lg-6 col-md-12 d-flex flex-wrap gap-2 justify-content-center justify-content-lg-end">
            <button class="btn text-white px-3 ml-2"
                style="background-color: #07aa4d; box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.8);" data-bs-toggle="modal"
                data-bs-target="#loginModal">
                Convert to PDF
                <i class="bi bi-file-earmark-pdf"></i>
            </button>
        </div>
    </div>
</div>

{{-- ==================== USER INFO SECTION ==================== --}}
<div class="container-fluid text-white text-center p-1"
    style="background-color: #0d5cba; font-family: Montserrat, sans-serif;">
    {{-- User Details --}}
    <p class="mb-4 mt-2" style="margin-left: 30px; margin-right: 30px;">
        I, <strong>JULIUS GERON N. IGLESIAS</strong>, Administrative Officer IV (HRMO II) - Permanent of the
        <strong>PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE, BENEFITS AND WELFARE DIVISION</strong>,
        commit to deliver and agree to be rated on the attainment of the following target in accordance with the
        indicated measures for the period
        <strong>
            {{-- Date Selection --}}
            <select id="monthSelect" class="form-select d-inline w-auto">
                <option>January</option>
                <!-- ... other months ... -->
            </select>
            to
            <select id="monthSelect" class="form-select d-inline w-auto">
                <option>January</option>
                <!-- ... other months ... -->
            </select>
            <input type="number" id="yearSelect" class="form-control d-inline w-auto"
                style="max-width: 100px;" min="2025" max="2100" value="2025">
        </strong>
    </p>

    {{-- Review and Approval Section --}}
    <div class="container d-flex justify-content-center">
        <div class="w-100">
            <div class="row text-center">
                {{-- Reviewed By --}}
                <div class="col-md-6 d-flex align-items-center justify-content-center mb-2">
                    <label for="reviewedBy" class="fw-bold me-2" style="white-space: nowrap;">Reviewed by:</label>
                    <div class="d-flex">
                        <input type="text" id="reviewedBy" class="form-control me-2 p-2 w-100"
                            style="max-width: 300px; height: 35px; border-radius: 4px;">
                        <input type="text" class="form-control p-2 w-100"
                            style="max-width: 300px; height: 35px; border-radius: 4px;">
                    </div>
                </div>
                {{-- Approved By --}}
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <label for="approvedBy" class="fw-bold me-2" style="white-space: nowrap;">Approved by:</label>
                    <input type="text" id="approvedBy" class="form-control p-2 w-100"
                        style="max-width: 300px; height: 35px; border-radius: 4px;">
                </div>
            </div>
        </div>
    </div>

    {{-- Rating Scale --}}
    <p class="mt-3">
        <strong>4.8 to 5</strong> – Outstanding &nbsp;
        <strong>3.9 to 4.79</strong> – Very Satisfactory &nbsp;
        <strong>3 to 3.89</strong> – Satisfactory &nbsp;
        <strong>2</strong> – Unsatisfactory &nbsp;
        <strong>1</strong> – Poor
    </p>
</div>

{{-- ==================== TABLE SECTION ==================== --}}
<div style="overflow-x: auto; display: flex; flex-direction: column; width: 100%;">
    <table id="dynamicTable" class="table bg-transparent flex-grow-1 text-center"
        style="width: 100%; max-width: 100%; font-family: Montserrat, sans-serif; background-color: rgba(255, 255, 255, 0.3); border-collapse: collapse; flex: 1; backdrop-filter: blur(10px); table-layout: fixed;">
        <thead class="text-center">
            <tr>
                <th style="background-color: #dd9f03; color: #ffffff; width: 10%;">Assign</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 20%;">Major Programs / Projects / Activities</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 20%;">Success Indicator</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 20%;">Quality</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 20%;">Efficiency</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 20%;">Timeliness</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 20%;">Remarks/MOV</th>
                <th style="background-color: #dd9f03; color: #ffffff; width: 10%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically added here -->
        </tbody>
    </table>
    {{-- Table Actions --}}
    <div class="text-start p-3">
        <button class="btn text-white shadow-lg px-3" style="background-color: #07aa4d;" onclick="addRow()">Add Row</button>
        <button class="btn text-white shadow-lg px-3" style="background-color: #07aa4d;">Save Changes</button>
    </div>
</div>

{{-- ==================== JAVASCRIPT SECTION ==================== --}}
<script>
    function addRow() {
        let table = document.getElementById("dynamicTable").getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();
        newRow.innerHTML = `
            <td class="text-center align-middle"><input type="checkbox" class="form-check-input custom-checkbox"></td>
            <td contenteditable="true" class="wrap-text"></td>
            <td contenteditable="true" class="wrap-text"></td>
            <td contenteditable="true" class="wrap-text"></td>
            <td contenteditable="true" class="wrap-text"></td>
            <td contenteditable="true" class="wrap-text"></td>
            <td contenteditable="true" class="wrap-text"></td>
            <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button></td>
        `;
    }

    function removeRow(button) {
        let row = button.parentElement.parentElement;
        row.remove();
    }
</script>

@endsection
