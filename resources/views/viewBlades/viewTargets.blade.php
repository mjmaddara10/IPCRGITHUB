@php
    $divisionChiefsArray = [];

    foreach ($divisions as $division) {
        $chief = $division->employees->firstWhere('role', 'Division Chief');

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
    const employees = @json($employees);
</script>

@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'View Targets')

<!-- Navigation Section -->
@section('navbar')
    @include('viewBlades.include')
@endsection

@section('content')
@if($role === 'Division Chief' || $role === 'Assistant Department Head' || $role === 'Department Head')
    <div>
@elseif($role === 'Staff')
    <div>
@endif

    <div class="py-1">
        <div class="container-fluid mt-2">
            <div class="bg-white">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex align-items-center nv-green">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tasks fa-2x text-white me-3"></i>
                        <div>
                            <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                                View Targets </h4>
                            @if($role === 'Division Chief' || $role === 'Assistant Department Head' || $role === 'Department Head')
                                <small class="text-white-50">View all the users' targets</small>
                            @elseif($role === 'Staff')
                                <small class="text-white-50">View the assigned IPCR targets for you</small>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center ms-auto" style="color: #FFFFFF; font-weight: 500;">
                        <div class="col-12 d-flex flex-column align-items-end">
                            <h4 id="currentDate" class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                                {{ now()->format('F j, Y') }}
                            </h4>
                            <p id="currentTime" class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif;">
                                {{ now()->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                        <!-- Effectivity Date for Staff -->
                        @if($role === 'Staff')
                            <div class="d-flex justify-content-start align-items-center flex-wrap mb-1">
                                <!-- Effectivity Select -->
                                <div class="d-flex align-items-center text-success me-3" style="min-width: 300px;">
                                    <label for="effectivitySelect" class="me-2 fw-bold mb-0">Set Effectivity Date From:</label>
                                    <input type="date" class="form-control form-control-sm" id="effectivitySelectFrom" name="effectivitySelectFrom" style="width: 200px;">
                                
                                    <label for="effectivitySelect" class="me-2 fw-bold mb-0 ms-2">To:</label>
                                    <input type="date" class="form-control form-control-sm" id="effectivitySelectTo" name="effectivitySelectTo" style="width: 200px;">
                                </div>
                            </div>
                        @endif

                        <div class="d-flex align-items-center text-success me-3" style="min-width: 300px;">
                            @if($role === 'Division Chief' || $role === 'Assistant Department Head' || $role === 'Department Head')

                                <!-- Division Select -->
                                <label for="divisionSelect" class="me-2 fw-bold mb-0">Select Division:</label>
                                <select class="form-select form-select-sm" name="divisionSelect" id="divisionSelect" style="width: 250px !important;">
                                    <option value="">All Divisions</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            data-name="{{ $division->name }}">
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            
                                <!-- User Select -->
                                <label for="employeeSelect" class="mx-2 fw-bold mb-0">Select User:</label>
                                <select class="form-select form-select-sm" name="employeeSelect" id="employeeSelect" style="width: 200px !important;">
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

                        <!-- Navigation Buttons -->
                        <div class="d-flex align-items-center flex-wrap">
                            @if($role === 'Division Chief')
                                <a href="{{ route('chief.managePpa') }}" class="btn btn-hover nv-green"  style="margin-left: 3px;" onclick="localStorage.clear();">Manage PPA</a>
                                <a href="{{ route('chief.viewIpcr') }}" class="btn btn-hover text-success fw-bold" style="margin-left: 3px; background-color: rgb(230, 230, 230);">View Targets</a>

                                
                                <a class="btn nv-green" id="exportBtn" data-user-id="{{ $user->id }}" data-user-division="{{ $user->division_id }}" style="margin-left: 3px;">Print O/D/IPCR</a>

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
                                
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red" style="margin-left: 3px;" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @elseif($role === 'Department Head' || $role === 'Assistant Department Head')
                                <a href="{{ route('head.approve') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                    Review Requests
                                </a>
                                <a href="{{ route('head.managePpa') }}" class="btn btn-hover nv-green"  style="margin-left: 3px;" onclick="localStorage.clear();">
                                    Manage PPA
                                </a>
                                <a href="{{ route('head.viewIpcr') }}" class="btn btn-hover text-success fw-bold" style="margin-left: 3px; background-color: rgb(230, 230, 230);">
                                    View Targets
                                </a>

                                <a class="btn nv-green" id="exportBtn" data-user-id="{{ $user->id }}" data-user-division="{{ $user->division_id }}" style="margin-left: 3px;">Print O/D/IPCR</a>

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
                                
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red" style="margin-left: 3px;" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @elseif($role === 'Staff')
                                <a href="{{ route('staff.viewIpcr') }}" class="btn btn-hover text-success fw-bold mb-1 me-1" style="background-color: rgb(230, 230, 230);">View Targets</a>
                                <a class="btn btn-primary mb-1 me-1" id="exportBtnStaff" data-user-id="{{ $user->id }}" data-user-division="{{ $user->division_id }}">
                                    <i class="fas fa-file-pdf me-2"></i> Print IPCR
                                </a>
                                <a id="adminLogoutBtn" class="btn btn-hover nv-red mb-1" style="margin-left: 0;" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                    Logout
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if($role === 'Division Chief' || $role === 'Assistant Department Head' || $role === 'Department Head')
                    <div class="pt-2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                            <!-- Effectivity Select -->
                            <div class="d-flex align-items-center text-success me-3" style="min-width: 300px;">
                                <label for="effectivitySelect" class="me-2 fw-bold mb-0">Set Effectivity Date From:</label>
                                <input type="date" class="form-control form-control-sm" id="effectivitySelectFrom" name="effectivitySelectFrom" style="width: 200px;">
                            
                                <label for="effectivitySelect" class="me-2 fw-bold mb-0 ms-2">To:</label>
                                <input type="date" class="form-control form-control-sm" id="effectivitySelectTo" name="effectivitySelectTo" style="width: 200px;">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Table Section -->
                <div class="table-responsive">
                    @if($role === 'Staff')
                        <div class="table-scroll">
                            <table class="table">
                                <thead class="text-center default-text">
                                    <tr>
                                        <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:20%;">Programs/Project/Activities</th>
                                        <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Success Indicator</th>
                                        <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Quality</th>
                                        <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Efficiency</th>
                                        <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Timeliness</th>
                                        <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width:20%;">Remarks/MOV</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $printedPrograms = [];
                                        $printedActivities = [];
                                    @endphp

                                    @foreach($targets as $target)
                                        @php
                                            $programName = $target['program_name'] ?? 'N/A';
                                            $activityName = $target['activity_name'] ?? '';
                                        @endphp

                                        {{-- Program --}}
                                        @if(!in_array($programName, $printedPrograms))
                                            <tr class="small">
                                                <td class="text-left border border-light default-text" colspan="6" style="font-weight: bold; background-color: #03592c; color:#FFFFFF;">{{ $programName }}</td>
                                            </tr>
                                            @php $printedPrograms[] = $programName; @endphp
                                        @endif

                                        {{-- Activity --}}
                                        @if(!in_array($activityName, $printedActivities))
                                            <tr class="small">
                                                <td colspan="6" class="text-left border border-muted default-text" style="background-color:rgb(212, 212, 212);">{{ $activityName }}</td>
                                            </tr>
                                            @php $printedActivities[] = $activityName; @endphp
                                        @endif

                                        {{-- Sub-Activity (always print) --}}
                                        <tr class="small" style="vertical-align: top;">
                                            <td style="text-indent: 10px;" class="border default-text">{{ $target['sub_activity_name'] ?? '' }}</td>
                                            <td style="white-space: pre-wrap;" class="border default-text">{{ $target['sub_activity_success_indicator'] ?? '' }}</td>
                                            <td style="white-space: pre-wrap;" class="border default-text">{{ $target['sub_activity_quality'] ?? '' }}</td>
                                            <td style="white-space: pre-wrap;" class="border default-text">{{ $target['sub_activity_efficiency'] ?? '' }}</td>
                                            <td style="white-space: pre-wrap;" class="border default-text">{{ $target['sub_activity_timeliness'] ?? '' }}</td>
                                            <td style="white-space: pre-wrap;" class="border default-text">{{ $target['sub_activity_remarks'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="table-scroll">
                        <table id="usersTable" class="table table-hover" style="table-layout: fixed; fixed; width: 100%;">
                            <thead class="text-center d-none default-text" id="thead-default">
                                <tr>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Programs/Project/Activities</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Success Indicator</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Quality</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Efficiency</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:15%;">Timeliness</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:20%;">Remarks/MOV</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Actions</th>
                                </tr>
                            </thead>
                            <thead class="text-center d-none default-text" id="thead-dept-head">
                                <tr>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:11%;">Programs/Project/ Activities</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Success Indicator</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Quality</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Efficiency</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Timeliness</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:10%;">Remarks/MOV</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:8%;">Allotted Budget</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:8%;">Division/s Responsible</th>
                                    <th class="border border-light default-text" style="color: #FFFFFF; background-color: #dd9f03; width:5%;">Actions</th>
                                </tr>
                            </thead>

                            <tbody id="usersTableBody" class="default-text">
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
<!-- Edit Program Modal (DH)-->
<div class="modal fade" id="editProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="editProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Program
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body text-default" style="background-color: #ffffff;">
                <form id="editProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editProgramId" name="editProgramId" required>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1 default-text">Program Name:</label>
                        <textarea class="form-control border-2 py-2 default-text"
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
                            <thead class="table-light fw-bold text-dark default-text">
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
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSuccessIndicator" id="editSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editQuality" id="editQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editEfficiency" id="editEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editTimeliness" id="editTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editRemarks" id="editRemarks"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: middle;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text text-center" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editBudget" id="editBudget"></textarea>
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

<!-- Edit Activity Modal (DH)-->
<div class="modal fade" id="editActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
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
                        <textarea class="form-control border-2 py-2 default-text"
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
                    <!-- <div class="table-responsive">
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
                    </div> -->

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

<!-- Edit Activity Modal (DC)-->
<div class="modal fade" id="editGassActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
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
                        <textarea class="form-control border-2 py-2 default-text"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassActivityName" id="editGassActivityName"></textarea>
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


<!-- Edit Sub-Activity Modal -->
<div class="modal fade" id="editSubActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editSubActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">

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
                        <textarea class="form-control border-2 py-2 default-text"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editActivityNameSubTarget" id="editActivityNameSubTarget" required></textarea>
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
                                    <th class="default-text">Success Indicator</th>
                                    <th class="default-text">Quality</th>
                                    <th class="default-text">Efficiency</th>
                                    <th class="default-text">Timeliness</th>
                                    <th class="default-text">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" name="editSuccessIndicatorSub" id="editSuccessIndicatorSub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" name="editQualitySub" id="editQualitySub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" name="editEfficiencySub" id="editEfficiencySub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" name="editTimelinessSub" id="editTimelinessSub"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize default-text" name="editRemarksSub" id="editRemarksSub"></textarea>
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

<!-- Edit GASS Modal -->
<div class="modal fade" id="editGassModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="editGassModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editGassModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit GASS
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editGassForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editGassIdTarget" name="editGassIdTarget" required>

                    <div class="mb-3">
                        <textarea class="form-control border-2 py-2 fw-bold text-uppercase"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassNameTarget" id="editGassNameTarget" disabled></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-0">Allotted Budget:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassBudgetTarget" id="editGassBudgetTarget"></textarea>
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

<!-- <script>
    flatpickr("#effectivitySelectFrom", {
        dateFormat: "m/d/Y"
    });
</script>
<script>
    flatpickr("#effectivitySelectTo", {
        dateFormat: "m/d/Y"
    });
</script> -->
@endsection

<style>
    thead {
        position: sticky;
        top: 0;
        z-index: 2;
        background: inherit;
    }
    .table-scroll {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>
