<!-- View, add, edit, and delete PPAs -->
@extends('layouts')

@section('title', 'Manage PPA')

@section('navbar')
    @include('viewBlades.include')
@endsection



@section('content')
<!-- <div class="page-background"></div> -->
<div data-scrolled-id="{{ session('scrolled_id') }}">
    <div class="container-fluid mt-2">
        <div class="bg-white">
            <!-- Header -->
            <div class="card-header py-3 d-flex align-items-center nv-green">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list-alt fa-2x text-white me-3"></i>
                    <div>
                        <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                            Manage PPA</h4>
                        <small class="text-white-50">View, add, edit, and delete PPAs</small>
                    </div>
                </div>

                <div class="d-flex align-items-center ms-auto" style="color: #FFFFFF; font-weight: 500;">
                    <span>Select Division:</span>
                    <select class="form-select ms-2" id="divisionFilter" style="width: 250px; border: 2px solid #FFFFFF;">
                        <option value="">All Divisions</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                        <option value="gass">General Administrative and Support Services</option>
                    </select>
                </div>
            </div>

            <!-- Content || Navigation Buttons -->
            <div class="py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <!-- Add Program -->
                        <a class="btn nv-green" id="addProgramBtn" data-bs-toggle="modal" data-bs-target="#addProgramModal" style= "color: #FFFFFF; background-color: #03592c;"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></i> Add Program/Project</a>

                        <a class="btn nv-green" id="addGassProgramBtn" data-bs-toggle="modal" data-bs-target="#addGassProgramModal" style= "color: #FFFFFF; background-color: #03592c; display:none;"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></i> Add GASS Program/Project</a>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex align-items-center ms-auto">
                        @if($role === 'Division Chief')
                        <a href="{{ route('chief.managePpa') }}" style="margin-left: 3px; background-color:rgb(230, 230, 230);" class="btn btn-hover text-success fw-bold" onclick="localStorage.clear();">
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
                        @elseif($role === 'Department Head' || $role === 'Assistant Department Head')
                            <a href="{{ route('head.approve') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                Review Requests
                            </a>
                            <a href="{{ route('head.managePpa') }}" style="margin-left: 3px; background-color:rgb(230, 230, 230);" class="btn btn-hover text-success fw-bold" onclick="localStorage.clear();">
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
                        @endif
                    </div>
                </div>
            </div>

            <!-- Add CSS for fixed header -->
            <style>
                .table-fixed-header {
                    position: relative;
                    max-height: 70vh;
                    overflow-y: auto;
                }
                .table-fixed-header thead {
                    position: sticky;
                    top: 0;
                    z-index: 1;
                }
                .table-fixed-header th {
                    background-color: #dd9f03;
                }
            </style>

            <!-- PPA Table with fixed header -->
            <div class="table-responsive table-fixed-header" id="tableContainer">
                <table id="ppaTable" class="table" style="table-layout: fixed; width: 100%;">
                    <thead class="text-center default-text">
                        <tr style="vertical-align:middle;">
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12%;">Programs/Project/ Activities</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Success Indicator</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Quality</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Efficiency</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Timeliness</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 10%;">Remarks/MOV</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 8%;">Allotted Budget</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 9%">Division/s or Individual/s Responsible</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 9%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="programTableBody">
                        <!-- Program  -->
                        @foreach($programs as $program)
                            @php
                                // Get all the division IDs for the current program
                                $divisionIds = $program->divisions->pluck('id')->implode(',');
                            @endphp
                            <tr class="programRow" id="program-{{ $program->id }}" data-division-ids="{{ $divisionIds }}" data-program-id="{{ $program->id }}" style="vertical-align: top;">
                                <td class="text-left border border-muted ps-1 fw-bold text-uppercase default-text" style="background-color: #03592c; color:#FFFFFF">{{ $program->name }}</td>
                                <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF;">{{ $program->successIndicator }}</td>
                                <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF;">{{ $program->quality }}</td>
                                <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF;">{{ $program->efficiency }}</td>
                                <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF;">{{ $program->timeliness }}</td>
                                <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF;">{{ $program->remarks }}</td>
                                <td class="text-end border border-muted default-text"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF;">{{ $program->budget }}</td>
                                @php
                                    $allDivisionCount = \App\Models\Division::count();
                                    $assignedCount = $program->divisions->count();
                                @endphp

                                <td class="text-left border border-muted default-text" style="background-color: #03592c; color:#FFFFFF; vertical-align: top;">
                                    @if ($assignedCount === $allDivisionCount)
                                        All Divisions
                                    @else
                                        @foreach ($program->divisions as $division)
                                        {{ $division->name }} <br> <br>
                                        @endforeach
                                    @endif
                                </td>

                                <!-- Buttons -->
                                <td class="text-center" style= "color: #FFFFFF; background-color: #03592c;">
                                    <!-- Add Activity -->
                                    <button class="btn action-btn addActivityInProgramBtn buttonHover" title="Add an activity"
                                        data-program-id="{{ $program->id }}"
                                        data-program-name="{{ $program->name }}"
                                        data-division-ids="{{ json_encode($program->divisions->pluck('id')) }}" data-bs-toggle="modal" data-bs-target="#addActivityInProgramModal" style= "background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                                    </button>

                                    <!-- Edit Program -->
                                    <button class="btn action-btn editProgramBtn buttonHover" title="Edit program name"
                                        data-program-id="{{ $program->id }}"
                                        data-program-name="{{ $program->name }}"
                                        data-program-success="{{ $program->successIndicator }}"
                                        data-program-quality="{{ $program->quality }}"
                                        data-program-efficiency="{{ $program->efficiency }}"
                                        data-program-timeliness="{{ $program->timeliness }}"
                                        data-program-remarks="{{ $program->remarks }}"
                                        data-program-budget="{{ $program->budget }}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Program -->
                                    <button class="btn action-btn deleteProgramBtn buttonHover" title="Delete program"
                                        data-program-id="{{ $program->id }}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Move -->
                                    <div style="display: flex; justify-content: center; gap: 3px;">
                                        <form method="POST" action="{{ route('program.move' , [$program->id , 'up']) }}">
                                            @csrf
                                            <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move up"><i class="fas fa-caret-up" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                        </form>

                                        <form method="POST" action="{{ route('program.move' , [$program->id , 'down']) }}">
                                            @csrf
                                            <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move down"><i class="fas fa-caret-down" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                        </form>

                                        <button type="submit" class="btn action-btn btn-warning buttonHover programCollapseBtn mt-1"><i class="fas fa-down-left-and-up-right-to-center" style= "color: #FFFFFF;"></i></button>
                                    </div>

                                </td>
                            </tr>

                            <!-- Activities in Program-->
                            @foreach ($program->activities->sortBy('order') as $activity)
                                <tr class="activityRow" id="activity-{{ $activity->id }}" data-program-id="{{ $program->id }}" data-activity-id="{{ $activity->id }}" data-parent-program-id="{{ $program->id }}">
                                    <td class="text-left" hidden>{{ $activity->id }}</td>
                                    <td class="text-left border border-muted default-text" style="background-color:rgb(212, 212, 212);">{{ $activity->name }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->successIndicator }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->quality }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->efficiency }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->timeliness }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->remarks }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);"></td>
                                    @php
                                        $allEmployeeCount = \App\Models\Employee::count();
                                        $assignedCountAccountable = $activity->employees->count();
                                    @endphp

                                    <td class="text-center border border-muted default-text" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">
                                    @if ($activity->employees->count() === $allEmployeeCount)
                                        All Employees
                                    @else
                                        @foreach ($activity->employees as $employee)
                                            {{ $employee->firstName }} {{ strtoupper(substr($employee->middleName, 0, 1)) }}. {{ $employee->lastName }}
                                        @endforeach
                                    @endif
                                    </td>
                                    <td class="text-center border border-muted" style="background-color:rgb(212, 212, 212);">
                                        <!-- Add Sub-Activity -->
                                        <button class="btn action-btn addSubActivityBtn buttonHover" title="Add a sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                                            data-activity-id="{{ $activity->id }}"
                                            data-activity-name="{{ $activity->name }}"
                                            data-division-ids="{{ json_encode($program->divisions->pluck('id')) }}" data-bs-toggle="modal" data-bs-target="#addSubActivityModal"><i class="fas fa-plus" style= "-webkit-text-stroke: 1px white; color: #FFFFFF;"></i>
                                        </button>

                                        <!-- Edit Activity -->
                                        <button class="btn action-btn editActivityBtn buttonHover" title="Edit activity" style="color: rgb(144, 144, 144); background-color: rgb(144, 144, 144);"
                                            data-activity-id="{{ $activity->id }}"
                                            data-activity-name="{{ $activity->name }}"
                                            data-success-indicator="{{ $activity->successIndicator }}"
                                            data-quality="{{ $activity->quality }}"
                                            data-efficiency="{{ $activity->efficiency }}"
                                            data-timeliness="{{ $activity->timeliness }}"
                                            data-remarks="{{ $activity->remarks }}"
                                            data-division-ids="{{ json_encode($program->divisions->pluck('id')) }}" data-bs-toggle="modal" data-bs-target="#editActivityModal"><i class="fas fa-edit" style="color:#FFFFFF;"></i>
                                        </button>

                                        <!-- Delete Activity -->
                                        <button class="btn action-btn deleteActivityBtn buttonHover" title="Delete activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                                            data-activity-id="{{ $activity->id }}"
                                            data-url="{{ route('deleteActivity') }}"><i class="fas fa-trash" style="color:#FFFFFF;"></i>
                                        </button>

                                        <!-- Move -->
                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                            <form method="POST" action="{{ route('activity.move' , [$activity->id , 'up']) }}">
                                                @csrf
                                                <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move up"><i class="fas fa-caret-up" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                            </form>

                                            <form method="POST" action="{{ route('activity.move' , [$activity->id , 'down']) }}">
                                                @csrf
                                                <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move down"><i class="fas fa-caret-down" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                            </form>

                                            <button type="submit" class="btn action-btn btn-warning buttonHover activityCollapseBtn mt-1"><i class="fas fa-down-left-and-up-right-to-center" style= "color: #FFFFFF;"></i></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sub-Activities -->
                                @foreach($activity->subActivities->sortBy('order') as $subActivity)
                                    <tr class="subActivityRow" id="subActivity-{{ $subActivity->id }}" data-program-id="{{ $program->id }}" data-activity-id="{{ $activity->id }}" data-parent-program-id="{{ $program->id }}">
                                        <td class="text-left" hidden>{{ $subActivity->id }}</td>
                                        <td class="text-left ps-3 border border-muted default-text">{{ $subActivity->name }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->successIndicator }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->quality }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->efficiency }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->timeliness }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->remarks }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap;"></td>
                                        @php
                                            $allEmployeeCount = \App\Models\Employee::count();
                                            $assignedCountAccountable = $activity->employees->count();
                                        @endphp

                                        <td class="text-center border border-muted default-text" style="white-space: pre-wrap;">
                                        @if ($subActivity->employees->count() === $allEmployeeCount)
                                            All Employees
                                        @else
                                            @foreach ($subActivity->employees as $employee)
                                                {{ $employee->firstName }} {{ strtoupper(substr($employee->middleName, 0, 1)) }}. {{ $employee->lastName }}
                                            @endforeach
                                        @endif
                                        <td class="text-center border border-muted">

                                            <!-- Edit Sub-Activity -->
                                            <button class="btn action-btn editSubActivityBtn buttonHover" title="Edit sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                                                data-sub-activity-id="{{ $subActivity->id }}"
                                                data-sub-activity-name="{{ $subActivity->name }}"
                                                data-success-indicator="{{ $subActivity->successIndicator }}"
                                                data-quality="{{ $subActivity->quality }}"
                                                data-efficiency="{{ $subActivity->efficiency }}"
                                                data-timeliness="{{ $subActivity->timeliness }}"
                                                data-remarks="{{ $subActivity->remarks }}"
                                                data-accountable="{{ $subActivity->accountable }}"
                                                data-bs-toggle="modal" data-bs-target="#editSubActivityModal"><i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Delete Sub-Activity -->
                                            <button class="btn action-btn deleteSubActivityBtn buttonHover" title="Delete sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                                                data-sub-activity-id="{{ $subActivity->id }}"
                                                data-url="{{ route('deleteSubActivity') }}"><i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Move -->
                                            <div style="display: flex; justify-content: center; gap: 3px;">
                                                <form method="POST" action="{{ route('subActivity.move' , [$subActivity->id , 'up']) }}">
                                                    @csrf
                                                    <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move up"><i class="fas fa-caret-up" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                                </form>

                                                <form method="POST" action="{{ route('subActivity.move' , [$subActivity->id , 'down']) }}">
                                                    @csrf
                                                    <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move down"><i class="fas fa-caret-down" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tr>

                            @endforeach

                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- GASS Table -->
            <div class="table-responsive table-fixed-header" id="gassTable" style="display:none;">
                <table id="ppaTable" class="table" style="table-layout: fixed; width: 100%;">
                    <thead class="text-center default-text">
                        <tr style="vertical-align:middle;">
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12%;">Programs/Project/ Activities</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Success Indicator</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Quality</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Efficiency</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 12.3%;">Timeliness</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 10%;">Remarks/MOV</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 8%;">Allotted Budget</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 9%">Division/s or Individual/s Responsible</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 9%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="programTableBody">
                        <!-- GASS Name -->
                        @foreach ($gasses as $gass)
                            <tr>
                                <td class="text-left border border-muted ps-1 fw-bold text-uppercase fs-6" style="background-color: #03592c; color:#FFFFFF" colspan="6">{{ $gass->name }}</td>
                                <td class="text-end border border-muted ps-1 text-uppercase" style="background-color: #03592c; color:#FFFFFF">{{ $gass->budget }}</td>
                                <td class="text-left border border-muted ps-1 fw-bold text-uppercase" style="background-color: #03592c; color:#FFFFFF"></td>
                                <td class="text-center border border-muted ps-1 fw-bold text-uppercase" style="background-color: #03592c; color:#FFFFFF">
                                    <!-- Edit GASS -->
                                    <button class="btn action-btn editGassBtn buttonHover" title="Edit GASS"
                                        data-gass-id="{{ $gass->id }}"
                                        data-gass-name="{{ $gass->name }}"
                                        data-gass-budget="{{ $gass->budget }}"
                                        data-bs-toggle="modal" data-bs-target="#editGassModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Programs -->
                            @foreach ($gass->programs->sortBy('order') as $program)
                                @php
                                    // Get all the division IDs for the current program
                                    $divisionIds = $program->divisions->pluck('id')->implode(',');
                                @endphp
                                <tr class="programRow" id="program-{{ $program->id }}" data-program-id="{{ $program->id }}" style="vertical-align: top;">
                                    <td class="text-left border border-muted ps-1 fw-bold text-uppercase default-text" style="background-color:rgb(2, 113, 56); color:#FFFFFF">{{ $program->name }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: rgb(2, 113, 56); color:#FFFFFF;">{{ $program->successIndicator }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: rgb(2, 113, 56); color:#FFFFFF;">{{ $program->quality }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: rgb(2, 113, 56); color:#FFFFFF;">{{ $program->efficiency }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: rgb(2, 113, 56); color:#FFFFFF;">{{ $program->timeliness }}</td>
                                    <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color: rgb(2, 113, 56); color:#FFFFFF;">{{ $program->remarks }}</td>
                                    <td class="text-end border border-muted default-text"style="white-space: pre-wrap; background-color: rgb(2, 113, 56); color:#FFFFFF;">{{ $program->budget }}</td>
                                    @php
                                        $allDivisionCount = \App\Models\Division::count();
                                        $assignedCount = $program->divisions->count();
                                    @endphp

                                    <td class="text-left border border-muted default-text" style="background-color: rgb(2, 113, 56); color:#FFFFFF; vertical-align: top;">
                                        @if ($assignedCount === $allDivisionCount)
                                            All Divisions
                                        @else
                                            @foreach ($program->divisions as $division)
                                            {{ $division->name }} <br> <br>
                                            @endforeach
                                        @endif
                                    </td>

                                    <!-- Buttons -->
                                    <td class="text-center" style= "color: #FFFFFF; background-color: rgb(2, 113, 56);">
                                        <!-- Add Activity -->
                                        <button class="btn action-btn addActivityInProgramBtn buttonHover" title="Add an activity"
                                            data-program-id="{{ $program->id }}"
                                            data-program-name="{{ $program->name }}"
                                            data-division-ids="{{ json_encode($program->divisions->pluck('id')) }}" data-bs-toggle="modal" data-bs-target="#addActivityInProgramModal" style= "background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                                        </button>

                                        <!-- Edit Program -->
                                        <button class="btn action-btn editProgramBtn buttonHover" title="Edit program name"
                                            data-program-id="{{ $program->id }}"
                                            data-program-name="{{ $program->name }}"
                                            data-program-success="{{ $program->successIndicator }}"
                                            data-program-quality="{{ $program->quality }}"
                                            data-program-efficiency="{{ $program->efficiency }}"
                                            data-program-timeliness="{{ $program->timeliness }}"
                                            data-program-remarks="{{ $program->remarks }}"
                                            data-program-budget="{{ $program->budget }}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Program -->
                                        <button class="btn action-btn deleteProgramBtn buttonHover" title="Delete program"
                                            data-program-id="{{ $program->id }}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Move -->
                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                            <form method="POST" action="{{ route('program.move' , [$program->id , 'up']) }}">
                                                @csrf
                                                <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move up"><i class="fas fa-caret-up" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                            </form>

                                            <form method="POST" action="{{ route('program.move' , [$program->id , 'down']) }}">
                                                @csrf
                                                <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move down"><i class="fas fa-caret-down" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                            </form>

                                            <button type="submit" class="btn action-btn btn-warning buttonHover programCollapseBtn mt-1"><i class="fas fa-down-left-and-up-right-to-center" style= "color: #FFFFFF;"></i></button>
                                        </div>

                                    </td>
                                </tr>

                                <!-- Activities in Program-->
                                @foreach ($program->activities->sortBy('order') as $activity)
                                    <tr class="activityRow" id="activity-{{ $activity->id }}" data-program-id="{{ $program->id }}" data-activity-id="{{ $activity->id }}" data-parent-program-id="{{ $program->id }}">
                                        <td class="text-left" hidden>{{ $activity->id }}</td>
                                        <td class="text-left border border-muted default-text" style="background-color:rgb(212, 212, 212);">{{ $activity->name }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->successIndicator }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->quality }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->efficiency }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->timeliness }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->remarks }}</td>
                                        <td class="text-left border border-muted default-text"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);"></td>
                                        @php
                                            $allEmployeeCount = \App\Models\Employee::count();
                                            $assignedCountAccountable = $activity->employees->count();
                                        @endphp

                                        <td class="text-center border border-muted default-text" style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">
                                        @if ($activity->employees->count() === $allEmployeeCount)
                                            All Employees
                                        @else
                                            @foreach ($activity->employees as $employee)
                                                {{ $employee->firstName }} {{ strtoupper(substr($employee->middleName, 0, 1)) }}. {{ $employee->lastName }}
                                            @endforeach
                                        @endif
                                        </td>
                                        <td class="text-center border border-muted" style="background-color:rgb(212, 212, 212);">
                                            <!-- Add Sub-Activity -->
                                            <button class="btn action-btn addSubActivityBtn buttonHover" title="Add a sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                                                data-activity-id="{{ $activity->id }}"
                                                data-activity-name="{{ $activity->name }}"
                                                data-division-ids="{{ json_encode($program->divisions->pluck('id')) }}" data-bs-toggle="modal" data-bs-target="#addSubActivityModal"><i class="fas fa-plus" style= "-webkit-text-stroke: 1px white; color: #FFFFFF;"></i>
                                            </button>

                                            <!-- Edit Activity -->
                                            <button class="btn action-btn editActivityBtn buttonHover" title="Edit activity" style="color: rgb(144, 144, 144); background-color: rgb(144, 144, 144);"
                                                data-activity-id="{{ $activity->id }}"
                                                data-activity-name="{{ $activity->name }}"
                                                data-success-indicator="{{ $activity->successIndicator }}"
                                                data-quality="{{ $activity->quality }}"
                                                data-efficiency="{{ $activity->efficiency }}"
                                                data-timeliness="{{ $activity->timeliness }}"
                                                data-remarks="{{ $activity->remarks }}"
                                                data-division-ids="{{ json_encode($program->divisions->pluck('id')) }}" data-bs-toggle="modal" data-bs-target="#editActivityModal"><i class="fas fa-edit" style="color:#FFFFFF;"></i>
                                            </button>

                                            <!-- Delete Activity -->
                                            <button class="btn action-btn deleteActivityBtn buttonHover" title="Delete activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                                                data-activity-id="{{ $activity->id }}"
                                                data-url="{{ route('deleteActivity') }}"><i class="fas fa-trash" style="color:#FFFFFF;"></i>
                                            </button>

                                            <!-- Move -->
                                            <div style="display: flex; justify-content: center; gap: 3px;">
                                                <form method="POST" action="{{ route('activity.move' , [$activity->id , 'up']) }}">
                                                    @csrf
                                                    <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move up"><i class="fas fa-caret-up" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                                </form>

                                                <form method="POST" action="{{ route('activity.move' , [$activity->id , 'down']) }}">
                                                    @csrf
                                                    <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move down"><i class="fas fa-caret-down" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                                </form>

                                                <button type="submit" class="btn action-btn btn-warning buttonHover activityCollapseBtn mt-1"><i class="fas fa-down-left-and-up-right-to-center" style= "color: #FFFFFF;"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Sub-Activities -->
                                    @foreach($activity->subActivities->sortBy('order') as $subActivity)
                                        <tr class="subActivityRow" id="subActivity-{{ $subActivity->id }}" data-program-id="{{ $program->id }}" data-activity-id="{{ $activity->id }}" data-parent-program-id="{{ $program->id }}">
                                            <td class="text-left" hidden>{{ $subActivity->id }}</td>
                                            <td class="text-left ps-3 border border-muted default-text">{{ $subActivity->name }}</td>
                                            <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->successIndicator }}</td>
                                            <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->quality }}</td>
                                            <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->efficiency }}</td>
                                            <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->timeliness }}</td>
                                            <td class="text-left border border-muted default-text"style="white-space: pre-wrap;">{{ $subActivity->remarks }}</td>
                                            <td class="text-left border border-muted default-text"style="white-space: pre-wrap;"></td>
                                            @php
                                                $allEmployeeCount = \App\Models\Employee::count();
                                                $assignedCountAccountable = $activity->employees->count();
                                            @endphp

                                            <td class="text-center border border-muted default-text" style="white-space: pre-wrap;">
                                            @if ($subActivity->employees->count() === $allEmployeeCount)
                                                All Employees
                                            @else
                                                @foreach ($subActivity->employees as $employee)
                                                    {{ $employee->firstName }} {{ strtoupper(substr($employee->middleName, 0, 1)) }}. {{ $employee->lastName }}
                                                @endforeach
                                            @endif
                                            <td class="text-center border border-muted">

                                                <!-- Edit Sub-Activity -->
                                                <button class="btn action-btn editSubActivityBtn buttonHover" title="Edit sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                                                    data-sub-activity-id="{{ $subActivity->id }}"
                                                    data-sub-activity-name="{{ $subActivity->name }}"
                                                    data-success-indicator="{{ $subActivity->successIndicator }}"
                                                    data-quality="{{ $subActivity->quality }}"
                                                    data-efficiency="{{ $subActivity->efficiency }}"
                                                    data-timeliness="{{ $subActivity->timeliness }}"
                                                    data-remarks="{{ $subActivity->remarks }}"
                                                    data-accountable="{{ $subActivity->accountable }}"
                                                    data-bs-toggle="modal" data-bs-target="#editSubActivityModal"><i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Delete Sub-Activity -->
                                                <button class="btn action-btn deleteSubActivityBtn buttonHover" title="Delete sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                                                    data-sub-activity-id="{{ $subActivity->id }}"
                                                    data-url="{{ route('deleteSubActivity') }}"><i class="fas fa-trash"></i>
                                                </button>

                                                <!-- Move -->
                                                <div style="display: flex; justify-content: center; gap: 3px;">
                                                    <form method="POST" action="{{ route('subActivity.move' , [$subActivity->id , 'up']) }}">
                                                        @csrf
                                                        <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move up"><i class="fas fa-caret-up" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                                    </form>

                                                    <form method="POST" action="{{ route('subActivity.move' , [$subActivity->id , 'down']) }}">
                                                        @csrf
                                                        <button type="submit" class="btn action-btn btn-primary buttonHover mt-1" title="Move down"><i class="fas fa-caret-down" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tr>

                                @endforeach

                            @endforeach

                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- GASS Table -->
        </div>
    </div>
</div>



<!------------------------------------Modals-------------------------------------->
<!-- Add Program Modal -->
<div class="modal fade" id="addProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="addProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Add Program
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                @if($role === 'Division Chief')
                    <form id="addProgramRequestForm" class="p-2">
                @elseif($role === 'Department Head' || $role === 'Assistant Department Head')
                    <form id="addProgramForm" class="p-2">
                @endif
                    @csrf
                    <!-- Division Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Division/s Responsible:</label>
                            <button class="btn btn-sm text-white buttonHover" id="addDivisionBtn" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div id="divisionSelectContainer" data-divisions="{{ json_encode($divisions) }}">
                            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border border-success selectDivision" name="divisions[]">
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
                                    <th style="min-width: 200px;">Program/Project</th>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>
                                    <th style="min-width: 200px;">Allotted Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramName" id="addProgramName" autofocus></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addQuality" id="addQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addEfficiency" id="addEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addTimeliness" id="addTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addRemarks" id="addRemarks"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addBudget" id="addBudget"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    @if($role === 'Division Chief' || $role === 'Assistant Department Head')
                        <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                            <button type="button" class="btn btn-danger px-3 closeAddModal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success px-3">
                                <i class="fas fa-save me-2"></i>Submit
                            </button>
                        </div>
                    @elseif($role === 'Department Head')
                        <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                            <button type="button" class="btn btn-danger px-3 closeAddModal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success px-3">
                                <i class="fas fa-save me-2"></i>Save Program
                            </button>
                        </div>
                    @endif
                    
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Program Modal -->
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

<!-- Add Activity in Program Modal -->
<div class="modal fade" id="addActivityInProgramModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-hidden="true" tabindex="-1" aria-labelledby="addActivityInProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addActivityInProgramModalLabel">
                    <i class="fas fa-plus me-2"></i>Add Activity
                </h5>
            </div>

            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addActivityInProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="programIdProg" name="programIdProg" required>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1 default-text">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="programNameProg" id="programNameProg" disabled></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                            <button class="btn btn-sm text-white" id="addAccountablePersonBtn" type="button" title="Add person" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div id="accountableSelectContainer" data-divisions="{{ json_encode($divisions) }}">
                            <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border border-success accountableSelect" id="addAccountableId" name="addAccountableId[]">

                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeAccountableBtn" disabled>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Activity Name</th>
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
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivityName" id="addActivityName"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addQuality" id="addQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addEfficiency" id="addEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addTimeliness" id="addTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addRemarks" id="addRemarks"></textarea>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

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

<!-- Edit Activity Modal -->
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
        <div class="modal-content border-0 shadow rounded-3">
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

@include('gassModals.programModals')
@endsection

@if (session('scrolled_id'))
<script>
    window.onload = function () {
        const element = document.getElementById('{{ session('scrolled_id') }}');
        if (element) {
            const rect = element.getBoundingClientRect();
            const elementTop = rect.top + window.pageYOffset; // Get the top of the element relative to the document
            const elementHeight = rect.height; // Height of the element
            const windowHeight = window.innerHeight; // Height of the viewport

            // Calculate the scroll position to center the element
            const scrollPosition = elementTop - (windowHeight / 2) + (elementHeight / 2);

            window.scrollTo({ top: scrollPosition, behavior: 'smooth' }); // Scroll to the position
        }
    }
</script>
@endif
