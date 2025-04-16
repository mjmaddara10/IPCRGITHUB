<!-- View, add, edit, and delete PPAs -->
@extends('layouts')

@section('title', 'Manage PPA')

@section('navbar')
    @include('adminBlades.adminInclude')
@endsection



@section('content')
<div class="page-background"></div>
<div>
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

<!------------------------------------Modals-------------------------------------->
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