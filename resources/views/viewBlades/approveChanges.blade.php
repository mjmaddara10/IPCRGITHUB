<!-- View, add, edit, and delete users -->
<!-- Extends the main layout template -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Review Requests')

<!-- Navigation Section -->
@section('navbar')
    @include('viewBlades.include')
@endsection

@section('content')
<!-- <div class="page-background"></div> -->
<div>
    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-12">
                <div class="bg-white">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center ms-auto pt-3">
                                @if($role === 'Division Chief')
                                    <a href="{{ route('chief.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green" onclick="localStorage.clear();">
                                        Manage PPA
                                    </a>
                                    <a href="{{ route('chief.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                        View Targets
                                    </a>

                                    <div class="btn-group" style="margin-left: 3px;">
                                        <button type="button" class="btn btn-hover nv-green dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Lookup Tables
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item default-text" href="{{ route('chief.audit') }}">Audit Trail</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item default-text" href="{{ route('chief.viewEmployees') }}">View Users</a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                        Logout
                                    </a>
                                @elseif($role === 'Department Head' || $role === 'Assistant Department Head')
                                    <a href="{{ route('head.approve') }}" style="margin-left: 3px; background-color:rgb(230, 230, 230);" class="btn btn-hover text-success fw-bold" onclick="localStorage.clear();">
                                        Review Requests
                                    </a>
                                    <a href="{{ route('head.managePpa') }}" style="margin-left: 3px;" class="btn btn-hover nv-green" onclick="localStorage.clear();">
                                        Manage PPA
                                    </a>
                                    <a href="{{ route('head.viewIpcr') }}" style="margin-left: 3px;" class="btn btn-hover nv-green">
                                        View Targets
                                    </a>

                                    <div class="btn-group" style="margin-left: 3px;">
                                        <button type="button" class="btn btn-hover nv-green dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Lookup Tables
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item default-text" href="{{ route('head.audit') }}">Audit Trail</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item default-text" href="{{ route('head.viewEmployees') }}">View Users</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <a style="margin-left: 3px;" id="adminLogoutBtn" class="btn btn-hover nv-red" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logoutForm').submit();">
                                        Logout
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-header py-3 d-flex align-items-center nv-green">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users fa-2x text-white me-3"></i>
                                <div>
                                    <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Review PPA Requests</h4>
                                    <small class="text-white-50">Authorize the Division Chiefs' requests for changes in the PPAs</small>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="table-responsive">
                                <table id="requestTable" class="table table-hover" style="table-layout: fixed; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="color: #03592c; width: 8%;">Date/Time</th>
                                            <th style="color: #03592c; width: 20%;">Requestor</th>
                                            <th style="color: #03592c; width: 17%;">Division</th>
                                            <th style="color: #03592c; width: 47%;">Request</th>
                                            <th style="color: #03592c; width: 8%;">Action</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($programRequest as $programRequest)
                                            @if($programRequest->action === 'add')
                                                <tr>
                                                    <td data-order="{{ $programRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($programRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($programRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->firstName ?? '' }} {{ $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $programRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $programRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->division->name ?? '' }}</td>
                                                    <td>Add Program named, "{{ $programRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-program-id="{{ $programRequest->id }}"
                                                                data-program-name="{{ $programRequest->name }}"
                                                                data-program-success-indicator="{{ $programRequest->successIndicator }}"
                                                                data-program-quality="{{ $programRequest->quality }}"
                                                                data-program-efficiency="{{ $programRequest->efficiency }}"
                                                                data-program-timeliness="{{ $programRequest->timeliness }}"
                                                                data-program-remarks="{{ $programRequest->remarks }}"
                                                                data-program-budget="{{ $programRequest->budget }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewAddProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewAddProgramRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($programRequest->action === 'edit')
                                                <tr>
                                                    <td data-order="{{ $programRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($programRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($programRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->firstName ?? '' }} {{ $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $programRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $programRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->division->name ?? '' }}</td>
                                                    <td>Edit Program named, "{{ $programRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-program-id="{{ $programRequest->id }}"
                                                                data-program-name="{{ $programRequest->name }}"
                                                                data-program-success-indicator="{{ $programRequest->successIndicator }}"
                                                                data-program-quality="{{ $programRequest->quality }}"
                                                                data-program-efficiency="{{ $programRequest->efficiency }}"
                                                                data-program-timeliness="{{ $programRequest->timeliness }}"
                                                                data-program-remarks="{{ $programRequest->remarks }}"
                                                                data-program-budget="{{ $programRequest->budget }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewAddProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewAddProgramRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!------------------------------------------- Request Modals ----------------------------------------------->

<!-- Program Add Request Details Modal -->
<div class="modal fade" id="viewAddProgramRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewAddProgramRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewAddProgramRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Division Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Division/s Responsible:</label>
                    </div>
                    <div id="divisionInputsContainer" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center border-success">
                        <thead class="table-light fw-bold text-dark">
                            <tr>
                                <th style="min-width: 200px;">Program Name</th>
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramNameRequest" id="addProgramNameRequest" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramSuccessIndicatorRequest" id="addProgramSuccessIndicatorRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramQualityRequest" id="addProgramQualityRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramEfficiencyRequest" id="addProgramEfficiencyRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramTimelinessRequest" id="addProgramTimelinessRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramRemarksRequest" id="addProgramRemarksRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramBudgetRequest" id="addProgramBudgetRequest" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="addProgramApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" id="addProgramIdRequest">
                        <input type="hidden" name="program_division" id="divisionView">
                        <input type="hidden" name="program_division_id" id="divisionIdView">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="addProgramDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" id="deleteProgramIdRequest">

                        <button type="submit" class="btn btn-danger px-3">
                            <i class="fas fa-times me-2"></i>Disapprove
                        </button>
                    </form>

                    <button type="button" class="btn btn-primary text-white px-3" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Edit Request Details Modal -->
@endsection