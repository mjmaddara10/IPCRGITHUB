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
                    <a class="btn" data-bs-toggle="modal" data-bs-target="#addProgramModal" style= "color: #FFFFFF; background-color: #03592c;"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></i> Add Program</a>

                    <!-- Buttons -->
                <div class="d-flex align-items-center">
                    <a onclick="showTable('viewAll')" style="margin-left: 3px;" class="btn btn-hover px-4 nv-green">View All</a>
                    <a onclick="showTable('opcrTable')" style="margin-left: 3px;" class="btn btn-hover px-4 nv-green">OPCR</a>
                    <a onclick="showTable('dpcrTable')" style="margin-left: 3px;" class="btn btn-hover px-4 nv-green">DPCR</a>
                    <a onclick="showTable('ipcrTable')" style="margin-left: 3px;" class="btn btn-hover px-4 nv-green">IPCR</a>
                </div>
            </div>

                <!-- PPA Table -->
                <div class="table-responsive" id="tableContainer">
                    @include('adminBlades.tables.viewAll')
                </div>
            </div>
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
                            <button class="btn btn-sm text-white me-2" id="addDivisionBtn" type="button" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </label>
                        <div id="divisionSelectContainer" data-divisions="{{ json_encode($divisions) }}">
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

                    <!-- Division Responsible -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2">
                            Division/s Responsible:
                            <button class="btn btn-sm text-white me-2" id="editAddDivisionBtn" type="button" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </label>
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
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editProgramName" id="editProgramName" autofocus></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editSuccessIndicator" id="editSuccessIndicator"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editQuality" id="editQuality"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editEfficiency" id="editEfficiency"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editTimeliness" id="editTimeliness"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editRemarks" id="editRemarks"></textarea>
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


<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addProjectModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -7%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addProjectLabel">
                    <i class="fas fa-plus me-2"></i>Add Project
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addProjectForm" class="p-2">
                    @csrf
                    <input type="hidden" id="programId" name="programId" required>

                    <!-- Program Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="programName" id="programName" disabled></textarea>
                    </div>

                    <!-- Division Selection (moved up) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-1">Individual/s Responsible:</label>
                        <button type="button" class="btn btn-sm" title="Add division responsible" id="addDivisionBtn" style="color: #fff; background-color: rgb(1, 165, 80);">
                            <i class="fas fa-plus"></i>
                        </button>

                        <div id="divisionSelectContainer" data-divisions="{{ json_encode($divisions) }}" class="mt-2">
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

                    <!-- Project Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Project Name</th>
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
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addProjectName" id="addProjectName" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addSuccessIndicatorProject" id="addSuccessIndicatorProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addQualityProject" id="addQualityProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addEfficiencyProject" id="addEfficiencyProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addTimelinessProject" id="addTimelinessProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addRemarksProject" id="addRemarksProject"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-4" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeAddModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Add Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editProjectModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Project
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="editProjectForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editProjectId" name="editProjectId" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Project Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editProjectName" id="editProjectName"></textarea>
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

<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -7%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addActivityModalLabel">
                    <i class="fas fa-add me-2"></i>Add Activity
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="projectId" name="projectId" required>

                    <!-- Project Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Project Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="projectName" id="projectName" disabled></textarea>
                    </div>

                    <!-- Individual/s Responsible -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-1">Individual/s Responsible:</label>
                        <button type="button" class="btn btn-sm" title="Add individual responsible" id="addDivisionBtn" style="color: #fff; background-color: rgb(1, 165, 80);">
                            <i class="fas fa-plus"></i>
                        </button>

                        <div id="divisionSelectContainer" data-divisions="{{ json_encode($divisions) }}" class="mt-2">
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

                    <!-- Activity Details Table -->
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
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addActivityName" id="addActivityName" required></textarea>
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
                    <div class="modal-footer border-0 mt-4" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeAddModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Add Activity
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
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -7%;">
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
                    <input type="hidden" id="activityId" name="activityId" required>

                    <!-- Project Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Project Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="projectName" id="projectName" disabled></textarea>
                    </div>

                    <!-- Individual/s Responsible -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-1">Individual/s Responsible:</label>
                        <button type="button" class="btn btn-sm" title="Add individual responsible" id="addDivisionBtn" style="color: #fff; background-color: rgb(1, 165, 80);">
                            <i class="fas fa-plus"></i>
                        </button>

                        <div id="divisionSelectContainer" data-divisions="{{ json_encode($divisions) }}" class="mt-2">
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

                    <!-- Activity Details Table -->
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
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editActivityName" id="editActivityName" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editSuccessIndicatorActivity" id="editSuccessIndicatorActivity"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editQualityActivity" id="editQualityActivity"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editEfficiencyActivity" id="editEfficiencyActivity"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editTimelinessActivity" id="editTimelinessActivity"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editRemarksActivity" id="editRemarksActivity"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-4" style="background-color: #f8f9fa;">
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


<!-- Add Sub-Project Modal -->
<div class="modal fade" id="addSubProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addSubProjectModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -7%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addSubProjectModalLabel">
                    <i class="fas fa-add me-2"></i>Add Sub-Project
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addSubProjectForm" class="p-2">
                    @csrf
                    <input type="hidden" id="projectIdSub" name="projectIdSub" required>

                    <!-- Project Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Project Name:</label>
                        <textarea class="form-control border-2 py-2" style="border-color: #03592c; background-color: rgb(228, 228, 228); min-height: 50px; resize: vertical;" name="projectNameSub" id="projectNameSub" disabled></textarea>
                    </div>

                    <!-- Sub-Project Title -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Sub-Project Title:</label>
                        <textarea class="form-control border-2 py-2" style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;" name="addSubProjectTitle" id="addSubProjectTitle" required></textarea>
                    </div>

                    <!-- Sub-Project Details Table -->
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
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addSuccessIndicatorSubProject" id="addSuccessIndicatorSubProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addQualitySubProject" id="addQualitySubProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addEfficiencySubProject" id="addEfficiencySubProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addTimelinessSubProject" id="addTimelinessSubProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addRemarksSubProject" id="addRemarksSubProject"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Individual/s Responsible -->
                    <div class="mb-4">
                        <div class="py-2">
                            <label class="form-label fw-bold text-dark mb-1">Individual/s Responsible:</label>
                            <button class="btn btn-sm buttonHover" title="Add division responsible" id="addDivisionBtn" style="color: #fff; background-color: rgb(1, 165, 80);">
                                <i class="fas fa-plus" style="color: #fff; -webkit-text-stroke: 1px white;"></i>
                            </button>
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

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-4" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeAddModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Add Sub-Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Sub-Project Modal -->
<div class="modal fade" id="editSubProjectModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="editSubProjectModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -10%;">

            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editSubProjectModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Sub-Project
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editSubProjectForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editSubProjectId" name="editSubProjectId" required>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Sub-Project Title:</label>
                        <textarea class="form-control border-2" style="background-color: rgb(228, 228, 228); min-height: 50px; resize: vertical;" name="editSubProjectName" id="editSubProjectName"></textarea>
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
                                    <th>Individual Responsible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editSuccessIndicatorSubProject" id="editSuccessIndicatorSubProject" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editQualitySubProject" id="editQualitySubProject" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editEfficiencySubProject" id="editEfficiencySubProject" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editTimelinessSubProject" id="editTimelinessSubProject" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editRemarksSubProject" id="editRemarksSubProject"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editAccountableSubProject" id="editAccountableSubProject"></textarea>
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


<!-- Add Activity in Sub-Project Modal -->
<div class="modal fade" id="addActivityInSubModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addActivityInSubModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -10%;">

            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addActivityInSubModalLabel">
                    <i class="fas fa-plus me-2"></i>Add Activity in Sub-Project
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addActivityInSubForm" class="p-2">
                    @csrf
                    <input type="hidden" id="subProjectId" name="subProjectId" required>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Sub-Project Name:</label>
                        <textarea class="form-control border-2" style="background-color: rgb(228, 228, 228); min-height: 50px; resize: vertical;" name="subProjectName" id="subProjectName" disabled></textarea>
                    </div>

                    <!-- Table Input Fields -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th>Activity Name</th>
                                    <th>Success Indicator</th>
                                    <th>Quality</th>
                                    <th>Efficiency</th>
                                    <th>Timeliness</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addActivityName" id="addActivityName" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addSuccessIndicator" id="addSuccessIndicator" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addQuality" id="addQuality" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addEfficiency" id="addEfficiency" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addTimeliness" id="addTimeliness" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addRemarks" id="addRemarks" required></textarea>
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


<!-- Add Activity in Program Modal -->
<div class="modal fade" id="addActivityInProgramModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addActivityInProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -10%;">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addActivityInProgramModalLabel">
                    <i class="fas fa-plus me-2"></i>Add Activity in Program
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addActivityInProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="programIdProg" name="programIdProg" required>

                    <!-- Program Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="programNameProg" id="programNameProg" disabled></textarea>
                    </div>

                    <!-- Activity Table -->
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
                                    <th style="min-width: 200px;">Individual/s Responsible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addActivityName" id="addActivityName"></textarea>
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
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addAccountable" id="addAccountable"></textarea>
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


<!-- Add Sub-Activity Modal -->
<div class="modal fade" id="addSubActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addSubActivityModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -10%;">
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

                    <!-- Activity Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="activityNameSub" id="activityNameSub" disabled></textarea>
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
                                    <th style="min-width: 200px;">Individual/s Responsible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addSubActivityName" id="addSubActivityName" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addSuccessIndicator" id="addSuccessIndicator" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addQuality" id="addQuality" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addEfficiency" id="addEfficiency" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addTimeliness" id="addTimeliness" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addRemarks" id="addRemarks" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="addAccountable" id="addAccountable" required></textarea>
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
        <div class="modal-content border-0 shadow rounded-3" style="transform: scale(0.85); transform-origin: center; width: 120%; margin-left: -10%;">

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

                    <!-- Table Input Fields -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th>Sub-Activity Name</th>
                                    <th>Success Indicator</th>
                                    <th>Quality</th>
                                    <th>Efficiency</th>
                                    <th>Timeliness</th>
                                    <th>Remarks</th>
                                    <th>Individual Responsible</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editActivityNameSub" id="editActivityNameSub" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editSuccessIndicatorSub" id="editSuccessIndicatorSub" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editQualitySub" id="editQualitySub" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editEfficiencySub" id="editEfficiencySub" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editTimelinessSub" id="editTimelinessSub" required></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editRemarksSub" id="editRemarksSub"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control border-0 shadow-none" style="min-height: 100px; resize: vertical;" name="editAccountableSub" id="editAccountableSub"></textarea>
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
