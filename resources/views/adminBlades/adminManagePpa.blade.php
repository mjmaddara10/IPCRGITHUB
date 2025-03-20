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
                <!-- <pre>{{ var_dump($programs) }}</pre> -->

                    
                    <table id="ppaTable" class="table table-hover">
                        <thead class="text-center">
                            <tr>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Major Programs/Project/Activities</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Success Indicator</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Quality</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Efficiency</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Timeliness</th>
                                <th style="color: #FFFFFF; background-color: #dd9f03;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programs as $program)
                            <tr>
                                <td class="text-left" style= "color: #FFFFFF; background-color: #03592c;" colspan="6">{{ $program->name }}</td>
                            </tr>
                            @foreach($program->projects as $project)
                            <td class="text-left" style= "color: #FFFFFF; background-color:rgb(1, 165, 80);" colspan="6">&nbsp&nbsp&nbsp{{ $project->name }}</td>
                            <tr>
                                <tr>
                                    @foreach($project->activities as $activity)
                                        <td class="text-left">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{ $activity->name }}</td>
                                        <td class="text-center">{{ $activity->successIndicator }}</td>
                                        <td class="text-center">{{ $activity->quality }}</td>
                                        <td class="text-center">{{ $activity->efficiency }}</td>
                                        <td class="text-center">{{ $activity->timeliness }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editPpaModal"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" onclick="deletePpa(1)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    @endforeach
                                </tr>
                                
                            </tr>
                            <!-- <tr>
                            
                                <td class="text-center">{{ $project->name }}</td>
                                <td class="text-center">Quality</td>
                                <td class="text-center">Efficiency</td>
                                <td class="text-center">Timeliness</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editPpaModal"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="deletePpa(1)"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr> -->
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
<!-- Add PPA Modal -->
<div class="modal fade" id="addPpaModal" tabindex="-1" aria-labelledby="addPpaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addPpaModalLabel">
                    <i class="fas fa-plus me-2"></i>Add New PPA
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="addPpaForm" class="p-2">
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Major Programs/Project/Activities:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="ppaTitle" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="successIndicator" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="quality" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="efficiency" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="timeliness" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-hover px-3 nv-green" onclick="confirmAddPpa()">
                    <i class="fas fa-save me-2"></i>Save PPA
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit PPA Modal -->
<div class="modal fade" id="editPpaModal" tabindex="-1" aria-labelledby="editPpaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editPpaModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit PPA
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <form id="editPpaForm" class="p-2">
                    <input type="hidden" name="ppa_id" id="edit_ppa_id">
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Major Programs/Project/Activities:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="ppaTitle" id="edit_ppaTitle" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Success Indicator:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="successIndicator" id="edit_successIndicator" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Quality:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="quality" id="edit_quality" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Efficiency:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="efficiency" id="edit_efficiency" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark mb-1">Timeliness:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; background-color: #ffffff; min-height: 80px; resize: vertical;"
                            name="timeliness" id="edit_timeliness" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-hover px-3 nv-red" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-hover px-3 nv-green" onclick="confirmEditPpa()">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
