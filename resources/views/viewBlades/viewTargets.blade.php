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
<!-- <div class="page-background"></div> -->
<div style="transform: scale(0.70); transform-origin: top center; width: 142.857%; margin-left: -21.4285%;">

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
                            @if($role === 'Division Chief' || $role === 'Department Head')
                                <small class="text-white-50">View all the users' targets</small>
                            @elseif($role === 'Staff')
                                <small class="text-white-50">View the assigned IPCR targets for you</small>
                            @endif
                        </div>
                    </div>

                    <!-- Exporting -->
                    <div class="d-flex align-items-center ms-auto" style="color: #FFFFFF; font-weight: 500;">
                        <div class="col-12 d-flex justify-content-start">
                            <a class="btn btn-md btn-primary" id="exportBtn">
                                <i class="fas fa-file-pdf me-2"></i> Export as PDF
                            </a>

                            
                        </div>
                    </div>
                </div>

                <div class="px-4 pt-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                        <!-- Division Select -->
                        <div class="d-flex align-items-center text-success me-3" style="min-width: 300px;">
                            @if($role === 'Division Chief' || $role === 'Department Head')
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
                                    @foreach ($employees->sortBy(function($employee) {
                                        return $employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '.' : '') . ' ' . $employee->lastName;
                                    }) as $employee)
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
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex align-items-center flex-wrap">
                            
                            @if($role === 'Division Chief')
                                <a href="{{ route('chief.managePpa') }}" class="btn btn-hover nv-green"  style="margin-left: 3px;">Manage PPA</a>
                                <a href="{{ route('chief.viewIpcr') }}" class="btn btn-hover text-success fw-bold" style="margin-left: 3px; background-color: rgb(230, 230, 230);">View Targets</a>

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
                                
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red" style="margin-left: 3px;" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @elseif($role === 'Department Head')
                            <a href="{{ route('head.managePpa') }}" class="btn btn-hover nv-green"  style="margin-left: 3px;">Manage PPA</a>
                                <a href="{{ route('head.viewIpcr') }}" class="btn btn-hover text-success fw-bold" style="margin-left: 3px; background-color: rgb(230, 230, 230);">View Targets</a>

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
                                
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red" style="margin-left: 3px;" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
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
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Programs/Project/Activities</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Success Indicator</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Quality</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Efficiency</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Timeliness</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Remarks/MOV</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Allotted Budget</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Division/s Responsible</th>
                                    <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Actions</th>
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

<!------------------------------------Modals-------------------------------------->
<!-- Edit Program Modal -->
<div class="modal fade" id="editProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="editProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -7%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Program
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editProgramId" name="editProgramId" required>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editProgramName" id="editProgramName" required></textarea>
                    </div>

                    <!-- Division Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Division/s Responsible:</label>
                            <button class="btn btn-sm text-white" id="editAddDivisionBtn" type="button" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div id="editDivisionSelectContainer" data-divisions="{{ json_encode($divisions) }}">
                            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border border-success" name="divisions[]">
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                    <option value="all">All Divisions</option>
                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeDivisionBtn" disabled>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>
                                    <th style="min-width: 200px;">Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSuccessIndicator" id="editSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editQuality" id="editQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editEfficiency" id="editEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editTimeliness" id="editTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editRemarks" id="editRemarks"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: middle;">
                                        <textarea class="form-control border-0 shadow-none auto-resize text-center" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editBudget" id="editBudget"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeEditModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -5%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editActivityModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Activity
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editActivityId" name="editActivityId" required>

                    <!-- Activity Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editActivityName" id="editActivityName"></textarea>
                    </div>
                    <!-- Individual Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                            <button class="btn btn-sm text-white" id="addAccountableEditBtn" type="button" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <div id="editContainer">
                            <!-- Selects will be added here dynamically -->
                        </div>
                    </div>

                    <!-- Activity Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSuccessIndicatorActivity" id="editSuccessIndicatorActivity"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editQualityActivity" id="editQualityActivity"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editEfficiencyActivity" id="editEfficiencyActivity"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editTimelinessActivity" id="editTimelinessActivity"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editRemarksActivity" id="editRemarksActivity"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeEditModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Sub-Activity Modal -->
<div class="modal fade" id="addSubActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addSubActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -5%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addSubActivityModalLabel">
                    <i class="fas fa-plus me-2"></i>Add Sub-Activity
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addSubActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="activityIdSub" name="activityIdSub" required>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="activityNameSub" id="activityNameSub" disabled></textarea>
                    </div>

                    <!-- Individual Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                            <button class="btn btn-sm text-white me-2" id="addsAccountablePersonBtn" type="button"
                                title="Add person" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div id="accountableSelectContainerSubAct" data-divisions="{{ json_encode($divisions) }}">
                            <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border border-success accountableSelect" id="addAccountableId" name="addAccountableId[]">
                                    
                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeAccountableBtn" disabled>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Sub-Activity Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Sub-Activity Name</th>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="addSubActivityName" id="addSubActivityName"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="addQuality" id="addQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="addEfficiency" id="addEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="addTimeliness" id="addTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="addRemarks" id="addRemarks"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeAddModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Sub-Activity Modal -->
<div class="modal fade" id="editSubActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editSubActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -5%;">

            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editSubActivityModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Sub-Activity
                </h5>
            </div>


            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editSubActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editActivityIdSub" name="editActivityIdSub" required>

                    <!-- Sub-Activity Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Sub-Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editActivityNameSub" id="editActivityNameSub" required></textarea>
                    </div>

                    <!-- Individual Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                            <button class="btn btn-sm text-white" id="addAccountableEditSubBtn" type="button" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <div id="editContainerSub">
                            <!-- Selects will be added here dynamically -->
                        </div>
                    </div>

                    <!-- Table Input Fields -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th>Success Indicator</th>
                                    <th>Quality</th>
                                    <th>Efficiency</th>
                                    <th>Timeliness</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="editSuccessIndicatorSub" id="editSuccessIndicatorSub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="editQualitySub" id="editQualitySub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="editEfficiencySub" id="editEfficiencySub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="editTimelinessSub" id="editTimelinessSub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" name="editRemarksSub" id="editRemarksSub"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeEditModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
