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
            </div>

            <!-- Content -->
            <div class="p-4">
                <!-- Add PPA Button -->
                <div class="mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPpaModal">
                        <i class="fas fa-plus me-2"></i>Add PPA
                    </button>
                </div>

                <!-- PPA Table -->
                <div class="table-responsive">
                    <table id="ppaTable" class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 15%;">Major Programs/Project/Activities</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 15%;">Success Indicator</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 15%;">Quality</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 15%;">Efficiency</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 15%;">Timeliness</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 15%;">Remarks/MOV</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03; width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programs as $program)
                            <tr>
                                <td class="text-left" style= "color: #FFFFFF; background-color: #03592c;" colspan="7">{{ $program->name }}</td>
                            </tr>
                            <tr>
                                @foreach($program->projects as $project)
                                <td class="text-left" hidden>{{ $project->id }}</td>
                                <td class="text-left ps-4" style= "color: #FFFFFF; background-color:rgb(1, 165, 80);" colspan="5">{{ $project->name }}</td>
                                <td class="text-end" style= "color: #FFFFFF; background-color:rgb(1, 165, 80);" colspan="2">
                                    <button class="btn btn-sm btn-warning addActivityBtn" 
                                        data-project-id="{{ $project->id }}" 
                                        data-project-name="{{ $project->name }}" data-bs-toggle="modal" data-bs-target="#addActivityModal"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i></button>
                                    <button class="btn btn-sm btn-primary editProjectBtn" 
                                        data-project-id="{{ $project->id }}" 
                                        data-project-name="{{ $project->name }}" data-bs-toggle="modal" data-bs-target="#editProjectModal"><i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteProjectBtn" 
                                        data-project-id="{{ $project->id }}"
                                        data-url="{{ route('deleteProject') }}"><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                @foreach($project->activities as $activity)
                                    <td class="text-left" hidden>{{ $activity->id }}</td>
                                    <td class="text-left ps-5">{{ $activity->name }}</td>
                                    <td class="text-left"style="white-space: pre-wrap;">{{ $activity->successIndicator }}</td>
                                    <td class="text-left"style="white-space: pre-wrap;">{{ $activity->quality }}</td>
                                    <td class="text-left"style="white-space: pre-wrap;">{{ $activity->efficiency }}</td>
                                    <td class="text-left"style="white-space: pre-wrap;">{{ $activity->timeliness }}</td>
                                    <td class="text-left"style="white-space: pre-wrap;">{{ $activity->remarks }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-primary editActivityBtn" 
                                            data-activity-id="{{ $activity->id }}" 
                                            data-activity-name="{{ $activity->name }}" 
                                            data-success-indicator="{{ $activity->successIndicator }}"
                                            data-quality="{{ $activity->quality }}"
                                            data-efficiency="{{ $activity->efficiency }}"
                                            data-timeliness="{{ $activity->timeliness }}"
                                            data-remarks="{{ $activity->remarks }}"
                                            data-bs-toggle="modal" data-bs-target="#editActivityModal"><i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteActivityBtn" 
                                            data-activity-id="{{ $activity->id }}"
                                            data-url="{{ route('deleteActivity') }}"><i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                            </tr>
                            @endforeach
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
                    <input type="hidden" id="activityId" name="activityId" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editActivityName" id="editActivityName" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editSuccessIndicator" id="editSuccessIndicator" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editQuality" id="editQuality" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editEfficiency" id="editEfficiency" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editTimeliness" id="editTimeliness" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Remarks:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="editRemarks" id="editRemarks" required></textarea>
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
<div class="modal fade" id="addActivityModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addActivityModalLabel">
                    <i class="fas fa-add me-2"></i>Add Activity
                </h5>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="addActivityForm" class="p-2">
                    @csrf
                    <input type="hidden" id="projectId" name="projectId" required>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Project Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
                            name="projectName" id="projectName" disabled></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Activity Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="addActivityName" id="addActivityName" required></textarea>
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
                            style="border-color: #03592c; background-color:rgb(228, 228, 228); min-height: 50px; resize: vertical;"
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
@endsection
