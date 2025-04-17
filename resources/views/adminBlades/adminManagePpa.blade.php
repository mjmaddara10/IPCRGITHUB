<!-- View, add, edit, and delete PPAs -->
@extends('layouts')

@section('title', 'Manage PPA')

@section('navbar')
    @include('adminBlades.adminInclude')
@endsection



@section('content')
<div class="page-background"></div>
<div style="transform: scale(0.75); transform-origin: top center; width: 133.33%; margin-left: -16.665%;">
    <div class="container-fluid mt-3">
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
                    </select>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">

                <!-- Add Program -->
                    <a class="btn" data-bs-toggle="modal" data-bs-target="#addProgramModal" style= "color: #FFFFFF; background-color: #03592c;"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></i> Add Program/Project</a>
                
                    <!-- Buttons -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.viewEmployees') }}" class="btn btn-hover nv-green">
                    View Employees
                    </a>
                    <a href="{{ route('admin.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                    View IPCR
                    </a>
                    <a href="{{ route('admin.managePpa') }}" style="margin-left: 3px;" href="" class="btn btn-hover nv-green">
                    Manage PPA
                    </a>
                    <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    Logout
                    </a>
                </div>
            </div>

                <!-- PPA Table -->
                <div class="table-responsive" id="tableContainer">
                <table id="ppaTable" class="table">
                    <thead class="text-center">
                        <tr>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Programs/Project/Activities</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Success Indicator</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Quality</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Efficiency</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Timeliness</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Remarks/MOV</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 5%;">Division/Individuals Responsible</th>
                            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="programTableBody">
                        <!-- Program  -->
                        @foreach($programs as $program)
                            @php
                                // Get all the division IDs for the current program
                                $divisionIds = $program->divisions->pluck('id')->implode(',');
                            @endphp
                            <tr class="programRow" data-division-ids="{{ $divisionIds }}" data-program-id="{{ $program->id }}">
                                <td class="text-left border border-muted ps-1 fw-bold text-uppercase" style="background-color: #03592c; color:#FFFFFF">{{ $program->name }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->successIndicator }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->quality }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->efficiency }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->timeliness }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->remarks }}</td>
                                @php
                                    $allDivisionCount = \App\Models\Division::count();
                                    $assignedCount = $program->divisions->count();
                                @endphp

                                <td class="text-center border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">
                                    @if ($assignedCount === $allDivisionCount)
                                        All Divisions
                                    @else
                                        @foreach ($program->divisions as $division)
                                            {{ $division->name }}
                                        @endforeach
                                    @endif
                                </td>

                                <!-- Buttons -->
                                <td class="text-center" style= "color: #FFFFFF; background-color: #03592c;" colspan="3">
                                    <!-- Add Activity -->
                                    <button class="btn btn-sm addActivityInProgramBtn buttonHover" title="Add an activity"
                                        data-program-id="{{ $program->id }}" 
                                        data-program-name="{{ $program->name }}" data-bs-toggle="modal" data-bs-target="#addActivityInProgramModal" style= "background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                                    </button>

                                    <!-- Edit Program -->
                                    <button class="btn btn-sm editProgramBtn buttonHover" title="Edit program name"
                                        data-program-id="{{ $program->id }}" 
                                        data-program-name="{{ $program->name }}"
                                        data-program-success="{{ $program->successIndicator }}"
                                        data-program-quality="{{ $program->quality }}"
                                        data-program-efficiency="{{ $program->efficiency }}"
                                        data-program-timeliness="{{ $program->timeliness }}"
                                        data-program-remarks="{{ $program->remarks }}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Program -->
                                    <button class="btn btn-sm deleteProgramBtn buttonHover" title="Delete program"
                                        data-program-id="{{ $program->id }}"
                                        data-url="{{ route('deleteProgram') }}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Activities in Program-->
                            @foreach($program->activities as $activity)
                                <tr data-program-id="{{ $program->id }}">
                                    <td class="text-left" hidden>{{ $activity->id }}</td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">{{ $activity->name }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->successIndicator }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->quality }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->efficiency }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->timeliness }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->remarks }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->accountable }}</td>
                                    <td class="text-center border border-muted" style="background-color:rgb(212, 212, 212);">
                                        <!-- Add Sub-Activity -->
                                        <button class="btn btn-sm addSubActivityBtn buttonHover" title="Add a sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                                            data-activity-id="{{ $activity->id }}" 
                                            data-activity-name="{{ $activity->name }}" data-bs-toggle="modal" data-bs-target="#addSubActivityModal"><i class="fas fa-plus" style= "-webkit-text-stroke: 1px white; color: #FFFFFF;"></i>
                                        </button>

                                        <!-- Edit Activity -->
                                        <button class="btn btn-sm editActivityBtn buttonHover" title="Edit activity" style="color: rgb(144, 144, 144); background-color: rgb(144, 144, 144);"
                                            data-activity-id="{{ $activity->id }}" 
                                            data-activity-name="{{ $activity->name }}" 
                                            data-success-indicator="{{ $activity->successIndicator }}"
                                            data-quality="{{ $activity->quality }}"
                                            data-efficiency="{{ $activity->efficiency }}"
                                            data-timeliness="{{ $activity->timeliness }}"
                                            data-remarks="{{ $activity->remarks }}"
                                            data-bs-toggle="modal" data-bs-target="#editActivityModal"><i class="fas fa-edit" style="color:#FFFFFF;"></i>
                                        </button>

                                        <!-- Delete Activity -->
                                        <button class="btn btn-sm deleteActivityBtn buttonHover" title="Delete activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                                            data-activity-id="{{ $activity->id }}"
                                            data-url="{{ route('deleteActivity') }}"><i class="fas fa-trash" style="color:#FFFFFF;"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Sub-Activities -->
                                @foreach($activity->subActivities as $subActivity)
                                    <tr data-program-id="{{ $program->id }}">
                                        <td class="text-left" hidden>{{ $subActivity->id }}</td>
                                        <td class="text-left ps-3 border border-muted">{{ $subActivity->name }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->successIndicator }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->quality }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->efficiency }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->timeliness }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->remarks }}</td>
                                        <td class="text-center border border-muted"style="white-space: pre-wrap;">{{ $subActivity->accountable }}</td>
                                        <td class="text-center border border-muted">

                                            <!-- Edit Sub-Activity -->
                                            <button class="btn btn-sm editSubActivityBtn buttonHover" title="Edit sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
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
                                            <button class="btn btn-sm deleteSubActivityBtn buttonHover" title="Delete sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                                                data-sub-activity-id="{{ $subActivity->id }}"
                                                data-url="{{ route('deleteSubActivity') }}"><i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tr>
                                
                            @endforeach        
                        
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!------------------------------------Modals-------------------------------------->
<!-- Add Program Modal -->
<div class="modal fade" id="addProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="addProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -7%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Add Program
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addProgramForm" class="p-2">
                    @csrf

                    <!-- Division Responsible -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2">
                            Division/s Responsible:
                            <button class="btn btn-sm text-white me-2 buttonHover" id="addDivisionBtn" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </label>
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
                                    <th style="min-width: 200px;">Programs/Project/Activities</th>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addProgramName" id="addProgramName" autofocus></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addQuality" id="addQuality"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addEfficiency" id="addEfficiency"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addTimeliness" id="addTimeliness"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addRemarks" id="addRemarks"></textarea>
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
                            <i class="fas fa-save me-2"></i>Save Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Program/Project Modal -->
<div class="modal fade" id="addProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Add Program/Project
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="addProgramForm" class="p-2">
                    @csrf
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Program/Project Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="addProgramName" id="addProgramName" autofocus></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addQuality" id="addQuality"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addEfficiency" id="addEfficiency"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addTimeliness" id="addTimeliness"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addRemarks" id="addRemarks"></textarea>
                    </div>
                    <div class="col-12">
                        <div class="py-2">
                            <label class="form-label fw-bold text-dark mb-1">Division/s Responsible:</label>
                            <button class="btn btn-sm buttonHover" title="Add division responsible" id="addDivisionBtn" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                        </div>
                        
                        <!-- Division Selection -->
                        <div id="divisionSelectContainer" data-divisions="{{ json_encode($divisions) }}">
                            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select selectDivision" name="divisions[]">
                                    
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
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red closeAddModal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-hover px-3 nv-green">
                    <i class="fas fa-save me-2"></i>Add Program
                </button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit Program/Project Modal -->
<div class="modal fade" id="editProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="editProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Program
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
            <form id="editProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editProgramId" name="editProgramId" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editProgramName" id="editProgramName" autofocus></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editSuccessIndicator" id="editSuccessIndicator"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editQuality" id="editQuality"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editEfficiency" id="editEfficiency"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editTimeliness" id="editTimeliness"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editRemarks" id="editRemarks"></textarea>
                    </div>
                    <div class="col-12">
                        <div class="py-2">
                            <label class="form-label fw-bold text-dark mb-1">Division/s Responsible:</label>
                            <button class="btn btn-sm buttonHover" title="Add division responsible" id="editAddDivisionBtn" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                        </div>
                        
                        <!-- Division Selection -->
                        <div id="editDivisionSelectContainer" data-divisions="{{ json_encode($divisions) }}">
                            @foreach ($divisions as $division)
                                <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                                    <select class="form-select division-select" name="divisions[]">
                                        <option value="all">All Divisions</option> <!-- new option -->
                                        @foreach ($divisions as $div)
                                            <option value="{{ $div->id }}" {{ $div->id == $division->id ? 'selected' : '' }}>
                                                {{ $div->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-danger btn-sm removeDivisionBtn">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>    
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red closeEditModal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-hover px-3 nv-green">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Activity in Program Modal -->
<div class="modal fade" id="addActivityInProgramModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addActivityInProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addActivityInProgramModalLabel">
                    <i class="fas fa-add me-2"></i>Add Activity in Program
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="addActivityInProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="programIdProg" name="programIdProg" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="programNameProg" id="programNameProg" disabled></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addActivityName" id="addActivityName"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addQuality" id="addQuality"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addEfficiency" id="addEfficiency"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addTimeliness" id="addTimeliness"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addRemarks" id="addRemarks"></textarea>
                    </div>
                    <div class="col-12">
                        <div class="py-2">
                            <label class="form-label fw-bold text-dark mb-1">Individual/s Responsible:</label>
                            <button type="button" class="btn btn-sm" title="Add person" id="addAccountablePersonBtn" style="background-color: #01a550; color: #fff;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div id="accountableSelectContainer">
                            <div class="accountable-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border-2 py-2 accountableSelect" name="addAccountableId[]"
                                    style="border-color: #03592c; background-color: #ffffff;">
                                    <option value="">Select accountable person</option>
                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeAccountableBtn" disabled>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red closeAddModal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-hover px-3 nv-green">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editActivityModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Activity
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="editActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="activityId" name="activityId">
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editActivityName" id="editActivityName"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editSuccessIndicatorActivity" id="editSuccessIndicatorActivity"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editQualityActivity" id="editQualityActivity"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editEfficiencyActivity" id="editEfficiencyActivity"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editTimelinessActivity" id="editTimelinessActivity"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editRemarksActivity" id="editRemarksActivity"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Individual Responsible:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editRemarksActivity" id="editRemarksActivity"></textarea>
                    </div>
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red closeEditModal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-hover px-3 nv-green">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Sub-Activity -->
<div class="modal fade" id="addSubActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addSubActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addSubActivityModalLabel">
                    <i class="fas fa-add me-2"></i>Add Sub-Activity
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="addSubActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="activityIdSub" name="activityIdSub" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="activityNameSub" id="activityNameSub" disabled></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Sub-Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addSubActivityName" id="addSubActivityName" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addSuccessIndicator" id="addSuccessIndicator" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addQuality" id="addQuality" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addEfficiency" id="addEfficiency" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addTimeliness" id="addTimeliness" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addRemarks" id="addRemarks" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Individual/s Responsible:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addAccountable" id="addAccountable" required></textarea>
                    </div>
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red closeAddModal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-hover px-3 nv-green">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Sub-Activity Modal -->
<div class="modal fade" id="editSubActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editSubActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editSubActivityModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Sub-Activity
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="editSubActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editActivityIdSub" name="editActivityIdSub" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Sub-Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editActivityNameSub" id="editActivityNameSub" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editSuccessIndicatorSub" id="editSuccessIndicatorSub" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editQualitySub" id="editQualitySub" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editEfficiencySub" id="editEfficiencySub" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editTimelinessSub" id="editTimelinessSub" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editRemarksSub" id="editRemarksSub"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Individual Responsible:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editAccountableSub" id="editAccountableSub"></textarea>
                    </div>
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red closeEditModal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-hover px-3 nv-green">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection