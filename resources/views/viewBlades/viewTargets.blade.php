@php
    $divisionChiefsArray = [];

    foreach ($divisions as $division) {
        $chief = $division->employees->first();

        $fullName = '________';
        $position = '________';

        if ($chief) {
            $middleInitial = $chief->middleName ? substr($chief->middleName, 0, 1) . '.' : '';
            $fullName = $chief->firstName . ' ' . $middleInitial . ' ' . $chief->lastName;
            $position = $chief->position;
        }

        $divisionChiefsArray[$division->id] = [
            'name' => $fullName,
            'position' => $position,
        ];
    }
@endphp

<script>
    const divisionChiefs = @json($divisionChiefsArray);
</script>

@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'View Targets')

<!-- Navigation Section -->
@section('navbar')
    @include('viewBlades.include')
@endsection

@section('content')
<div class="page-background"></div>
<div style="transform: scale(0.75); transform-origin: top center; width: 133.33%; margin-left: -16.665%;">

    <div style="padding-top: 2px;">
        <div class="container-fluid mt-2">
            <div class="bg-white">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex align-items-center nv-green">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tasks fa-2x text-white me-3"></i>
                        <div>
                            <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                                View Targets </h4>
                            <small class="text-white-50">View all the users' targets</small>
                        </div>
                    </div>

                    <!-- Exporting -->
                    <div class="d-flex align-items-center ms-auto" style="color: #FFFFFF; font-weight: 500;">
                        <div class="col-12 d-flex justify-content-start">
                            <a class="btn btn-md btn-primary" href="{{ route('pdf.generatePdf') }}">
                                <i class="fas fa-file-pdf me-2"></i> Export as PDF
                            </a>
                        </div>
                    </div>
                </div>

                <div class="px-4 pt-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                        <!-- Division Select -->
                        <div class="d-flex align-items-center text-success me-3" style="min-width: 300px;">
                            <label for="divisionSelect" class="me-2 fw-bold mb-0">Select Division:</label>
                            <select class="form-select form-select-md w-auto" name="divisionSelect" id="divisionSelect">
                                <option>Select a Division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        data-name="{{ $division->name }}">
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        

                            <!-- User Select -->
                            <label for="employeeSelect" class="mx-2 fw-bold mb-0">Select User:</label>
                            <select class="form-select form-select-md w-auto" name="employeeSelect" id="employeeSelect">
                                <option>Select a User</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        data-name="{{ $employee->firstName }} {{ $employee->middleName ? substr($employee->middleName, 0, 1) . '.' : '' }} {{ $employee->lastName }}"
                                        data-position="{{ $employee->position }}"
                                        data-status="{{ $employee->status }}"
                                        data-division-id="{{ $employee->division->id ?? ''}}"
                                        data-division-name="{{ $employee->division->name ?? ''}}">
                                        {{ $employee->firstName }} {{ $employee->middleName ? substr($employee->middleName, 0, 1) . '.' : '' }} {{ $employee->lastName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex align-items-center flex-wrap">
                            
                            @if($role === 'Division Chief')
                                <a href="{{ route('chief.audit') }}" class="btn btn-hover nv-green mb-1 me-1">Audit Trail</a>
                                <a href="{{ route('chief.viewEmployees') }}" class="btn btn-hover nv-green mb-1 me-1">View Users</a>
                                <a href="{{ route('chief.viewIpcr') }}" class="btn btn-hover text-success fw-bold mb-1 me-1" style="background-color: rgb(230, 230, 230);">View Targets</a>
                                <a href="{{ route('chief.managePpa') }}" class="btn btn-hover nv-green mb-1 me-1">Manage PPA</a>
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red mb-1" style="margin-left: 0;" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @elseif($role === 'Department Head')
                                <a href="{{ route('head.audit') }}" class="btn btn-hover nv-green mb-1 me-1">Audit Trail</a>
                                <a href="{{ route('head.viewEmployees') }}" class="btn btn-hover nv-green mb-1 me-1">View Users</a>
                                <a href="{{ route('head.viewIpcr') }}" class="btn btn-hover text-success fw-bold mb-1 me-1" style="background-color: rgb(230, 230, 230);">View Targets</a>
                                <a href="{{ route('head.managePpa') }}" class="btn btn-hover nv-green mb-1 me-1">Manage PPA</a>
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red mb-1" style="margin-left: 0;" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @elseif($role === 'Staff')
                                <a href="{{ route('staff.viewIpcr') }}" class="btn btn-hover text-success fw-bold mb-1 me-1" style="background-color: rgb(230, 230, 230);">View Targets</a>
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red mb-1" style="margin-left: 0;" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-3" style="font-family: 'Montserrat'; text-align: justify; font-weight: 1000;">
                            <p class="justified-text" id="employeeCommitmentText">
                                I, <span id="empName" class="fw-bold text-uppercase">________</span>,
                                <span id="empPosition" class="fw-bold">________</span> -
                                <span id="empStatus" class="fw-bold ">________</span><strong> of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE</strong>
                                <span id="empDivision" class="fw-bold text-uppercase">________</span> commit to deliver and agree to be rated on the attainment of the following targets in accordance with the indicated measures for the period January to December 2025.
                            </p>

                            <div class="d-flex justify-content-center">
                                <div class="row mt-3 align-items-center" style="width: 100%; max-width: 1200px;">
                                    <table style="width: 1200px;">
                                        <tr>
                                            <td class="text-end"><h6 class="mb-0 text-nowrap">Reviewed by: </h6></td>
                                            <td><h6 id="reviewedByName" class="mb-0 text-nowrap fw-bold ps-2"></h6></td>
                                            <td class="text-end"><h6 class="mb-0 text-nowrap">Approved by: </h6></td>
                                            <td><h6 class="mb-0 text-nowrap fw-bold ps-2">Ma. Carla Lucia M. Torralba</h6></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end"><h6 class="mb-0 text-nowrap"></h6></td>
                                            <td><h6 id="reviewedByPosition" class="mb-0 text-nowrap ps-2"></h6></td>
                                            <td class="text-end"><h6 class="mb-0 text-nowrap"></h6></td>
                                            <td><h6 class="mb-0 text-nowrap ps-2">Provincial Human Resource Management Officer</h6></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="container-fluid" style="padding: 0 0px;">
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover" style="fixed; width: 100%;">
                            <thead class="text-center d-none" id="thead-default">
                                <tr>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:20%;">Programs/Project/Activities</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Success Indicator</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Quality</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Efficiency</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Timeliness</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:20%;">Remarks/MOV</th>
                                </tr>
                            </thead>
                            <thead class="text-center d-none" id="thead-dept-head">
                                <tr>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Programs/Project/Activities</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:12%;">Success Indicator</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:11%;">Quality</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:11%;">Efficiency</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:11%;">Timeliness</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:16%;">Remarks/MOV</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Allotted Budget</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:14%;">Division/s Responsible</th>
                                </tr>
                            </thead>

                            <tbody id="usersTableBody">
                                <!-- Target PPAs here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
