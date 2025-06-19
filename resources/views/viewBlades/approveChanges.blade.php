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
                                            @if($programRequest->action === 'add' && $programRequest->gass_id == 1)
                                                <tr>
                                                    <td data-order="{{ $programRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($programRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($programRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->firstName ?? '' }} {{ $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $programRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $programRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->division->name ?? '' }}</td>
                                                    <td>Add Critical Activity named, "{{ $programRequest->name }}"</td>
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
                                                                data-program-requestor="{{ $programRequest->requestor }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewAddGassCritRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewAddGassCritRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($programRequest->action === 'add')
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
                                                                data-program-requestor="{{ $programRequest->requestor }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewAddProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewAddProgramRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($programRequest->action === 'edit' && $programRequest->gass_id == 1)
                                                <tr>
                                                    <td data-order="{{ $programRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($programRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($programRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->firstName ?? '' }} {{ $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $programRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $programRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->division->name ?? '' }}</td>
                                                    <td>Edit Critical Activity named, "{{ $programRequest->program->name }}"</td>
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
                                                                data-program-requestor="{{ $programRequest->requestor }}"
                                                                data-reference-program="{{ $programRequest->program_id }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewEditProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewEditProgramRequestModal"><i class="fas fa-eye"></i>
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
                                                                data-program-requestor="{{ $programRequest->requestor }}"
                                                                data-reference-program="{{ $programRequest->program_id }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewEditProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewEditProgramRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($programRequest->action === 'delete' && $programRequest->gass_id == 1)
                                                <tr>
                                                    <td data-order="{{ $programRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($programRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($programRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->firstName ?? '' }} {{ $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $programRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $programRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->division->name ?? '' }}</td>
                                                    <td>Delete Critical Activity named, "{{ $programRequest->name }}"</td>
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
                                                                data-program-requestor="{{ $programRequest->requestor }}"
                                                                data-reference-program="{{ $programRequest->program_id }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewDeleteProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewDeleteProgramRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($programRequest->action === 'delete')
                                                <tr>
                                                    <td data-order="{{ $programRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($programRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($programRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->firstName ?? '' }} {{ $programRequest->requester->middleName ? strtoupper(substr($programRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $programRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $programRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $programRequest->requester->division->name ?? '' }}</td>
                                                    <td>Delete Program named, "{{ $programRequest->name }}"</td>
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
                                                                data-program-requestor="{{ $programRequest->requestor }}"
                                                                data-reference-program="{{ $programRequest->program_id }}"
                                                                data-program-divisions='@json($programRequest->divisions->pluck("name"))'
                                                                data-program-division-id='@json($programRequest->divisions->pluck("id"))' class="btn action-btn buttonHover bg-primary viewDeleteProgramRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewDeleteProgramRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @foreach($activityRequest as $activityRequest)
                                            @if($activityRequest->action === 'add')
                                                <tr>
                                                    <td data-order="{{ $activityRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($activityRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($activityRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $activityRequest->requester->firstName ?? '' }} {{ $activityRequest->requester->middleName ? strtoupper(substr($activityRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $activityRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $activityRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $activityRequest->requester->division->name ?? '' }}</td>
                                                    <td>Add Activity named, "{{ $activityRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-activity-id="{{ $activityRequest->id }}"
                                                                data-program-id="{{ $activityRequest->program_id }}"
                                                                data-activity-name="{{ $activityRequest->name }}"
                                                                data-activity-success-indicator="{{ $activityRequest->successIndicator }}"
                                                                data-activity-quality="{{ $activityRequest->quality }}"
                                                                data-activity-efficiency="{{ $activityRequest->efficiency }}"
                                                                data-activity-timeliness="{{ $activityRequest->timeliness }}"
                                                                data-activity-remarks="{{ $activityRequest->remarks }}"
                                                                data-activity-requestor="{{ $activityRequest->requestor }}"
                                                                data-activity-employees='@json($activityRequest->employees->pluck("firstName"))'
                                                                data-activity-employee-id='@json($activityRequest->employees->pluck("id"))' class="btn action-btn buttonHover bg-primary viewAddActivityRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewAddActivityRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($activityRequest->action === 'edit')
                                                <tr>
                                                    <td data-order="{{ $activityRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($activityRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($activityRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $activityRequest->requester->firstName ?? '' }} {{ $activityRequest->requester->middleName ? strtoupper(substr($activityRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $activityRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $activityRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $activityRequest->requester->division->name ?? '' }}</td>
                                                    <td>Edit Activity named, "{{ $activityRequest->activity->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-activity-id="{{ $activityRequest->id }}"
                                                                data-activity-name="{{ $activityRequest->name }}"
                                                                data-activity-success-indicator="{{ $activityRequest->successIndicator }}"
                                                                data-activity-quality="{{ $activityRequest->quality }}"
                                                                data-activity-efficiency="{{ $activityRequest->efficiency }}"
                                                                data-activity-timeliness="{{ $activityRequest->timeliness }}"
                                                                data-activity-remarks="{{ $activityRequest->remarks }}"
                                                                data-activity-requestor="{{ $activityRequest->requestor }}"
                                                                data-reference-activity="{{ $activityRequest->activity_id }}"
                                                                data-activity-employees='@json($activityRequest->employees->pluck("firstName"))'
                                                                data-activity-employee-id='@json($activityRequest->employees->pluck("id"))' class="btn action-btn buttonHover bg-primary viewEditActivityRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewEditActivityRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($activityRequest->action === 'delete')
                                                <tr>
                                                    <td data-order="{{ $activityRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($activityRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($activityRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $activityRequest->requester->firstName ?? '' }} {{ $activityRequest->requester->middleName ? strtoupper(substr($activityRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $activityRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $activityRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $activityRequest->requester->division->name ?? '' }}</td>
                                                    <td>Delete Activity named, "{{ $activityRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-activity-id="{{ $activityRequest->id }}"
                                                                data-activity-name="{{ $activityRequest->name }}"
                                                                data-activity-success-indicator="{{ $activityRequest->successIndicator }}"
                                                                data-activity-quality="{{ $activityRequest->quality }}"
                                                                data-activity-efficiency="{{ $activityRequest->efficiency }}"
                                                                data-activity-timeliness="{{ $activityRequest->timeliness }}"
                                                                data-activity-remarks="{{ $activityRequest->remarks }}"
                                                                data-activity-requestor="{{ $activityRequest->requestor }}"
                                                                data-reference-activity="{{ $activityRequest->activity_id }}"
                                                                data-activity-employees='@json($activityRequest->employees->pluck("firstName"))'
                                                                data-activity-employee-id='@json($activityRequest->employees->pluck("id"))' class="btn action-btn buttonHover bg-primary viewDeleteActivityRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewDeleteActivityRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @foreach($subActivityRequest as $subActivityRequest)
                                            @if($subActivityRequest->action === 'add')
                                                <tr>
                                                    <td data-order="{{ $subActivityRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($subActivityRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($subActivityRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $subActivityRequest->requester->firstName ?? '' }} {{ $subActivityRequest->requester->middleName ? strtoupper(substr($subActivityRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $subActivityRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $subActivityRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $subActivityRequest->requester->division->name ?? '' }}</td>
                                                    <td>Add Sub-Activity named, "{{ $subActivityRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-sub-activity-id="{{ $subActivityRequest->id }}"
                                                                data-activity-id="{{ $subActivityRequest->activity_id }}"
                                                                data-sub-activity-name="{{ $subActivityRequest->name }}"
                                                                data-sub-activity-success-indicator="{{ $subActivityRequest->successIndicator }}"
                                                                data-sub-activity-quality="{{ $subActivityRequest->quality }}"
                                                                data-sub-activity-efficiency="{{ $subActivityRequest->efficiency }}"
                                                                data-sub-activity-timeliness="{{ $subActivityRequest->timeliness }}"
                                                                data-sub-activity-remarks="{{ $subActivityRequest->remarks }}"
                                                                data-sub-activity-requestor="{{ $subActivityRequest->requestor }}"
                                                                data-sub-activity-employees='@json($subActivityRequest->employees->pluck("firstName"))'
                                                                data-sub-activity-employee-id='@json($subActivityRequest->employees->pluck("id"))' class="btn action-btn buttonHover bg-primary viewAddSubActivityRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewAddSubActivityRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($subActivityRequest->action === 'edit')
                                                <tr>
                                                    <td data-order="{{ $subActivityRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($subActivityRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($subActivityRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $subActivityRequest->requester->firstName ?? '' }} {{ $subActivityRequest->requester->middleName ? strtoupper(substr($subActivityRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $subActivityRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $subActivityRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $subActivityRequest->requester->division->name ?? '' }}</td>
                                                    <td>Edit Sub-Activity named, "{{ $subActivityRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-sub-activity-id="{{ $subActivityRequest->id }}"
                                                                data-sub-activity-name="{{ $subActivityRequest->name }}"
                                                                data-sub-activity-success-indicator="{{ $subActivityRequest->successIndicator }}"
                                                                data-sub-activity-quality="{{ $subActivityRequest->quality }}"
                                                                data-sub-activity-efficiency="{{ $subActivityRequest->efficiency }}"
                                                                data-sub-activity-timeliness="{{ $subActivityRequest->timeliness }}"
                                                                data-sub-activity-remarks="{{ $subActivityRequest->remarks }}"
                                                                data-sub-activity-budget="{{ $subActivityRequest->budget }}"
                                                                data-sub-activity-requestor="{{ $subActivityRequest->requestor }}"
                                                                data-reference-sub-activity="{{ $subActivityRequest->sub_activity_id }}"
                                                                data-sub-activity-employees='@json($subActivityRequest->employees->pluck("firstName"))'
                                                                data-sub-activity-employee-id='@json($subActivityRequest->employees->pluck("id"))' class="btn action-btn buttonHover bg-primary viewEditSubActivityRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewSubEditActivityRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @elseif($subActivityRequest->action === 'delete')
                                                <tr>
                                                    <td data-order="{{ $subActivityRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($subActivityRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($subActivityRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $subActivityRequest->requester->firstName ?? '' }} {{ $subActivityRequest->requester->middleName ? strtoupper(substr($subActivityRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $subActivityRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $subActivityRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $subActivityRequest->requester->division->name ?? '' }}</td>
                                                    <td>Delete Sub-Activity named, "{{ $subActivityRequest->name }}"</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-sub-activity-id="{{ $subActivityRequest->id }}"
                                                                data-sub-activity-name="{{ $subActivityRequest->name }}"
                                                                data-sub-activity-success-indicator="{{ $subActivityRequest->successIndicator }}"
                                                                data-sub-activity-quality="{{ $subActivityRequest->quality }}"
                                                                data-sub-activity-efficiency="{{ $subActivityRequest->efficiency }}"
                                                                data-sub-activity-timeliness="{{ $subActivityRequest->timeliness }}"
                                                                data-sub-activity-remarks="{{ $subActivityRequest->remarks }}"
                                                                data-sub-activity-requestor="{{ $subActivityRequest->requestor }}"
                                                                data-reference-sub-activity="{{ $subActivityRequest->sub_activity_id }}"
                                                                data-sub-activity-employees='@json($subActivityRequest->employees->pluck("firstName"))'
                                                                data-sub-activity-employee-id='@json($subActivityRequest->employees->pluck("id"))' class="btn action-btn buttonHover bg-primary viewDeleteSubActivityRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewDeleteSubActivityRequestModal"><i class="fas fa-eye"></i>
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @foreach($gassRequest as $gassRequest)
                                            @if($gassRequest->action === 'edit')
                                                <tr>
                                                    <td data-order="{{ $gassRequest->created_at }}">
                                                        {{ \Carbon\Carbon::parse($gassRequest->created_at)->format('F j, Y') }}<br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($gassRequest->created_at)->format('g:i A') }}</small>
                                                    </td>
                                                    <td>{{ $gassRequest->requester->firstName ?? '' }} {{ $gassRequest->requester->middleName ? strtoupper(substr($gassRequest->requester->middleName, 0, 1)) . '.' : '—' }} {{ $gassRequest->requester->lastName ?? '' }}<br>
                                                        <small class="text-50 text-muted">{{ $gassRequest->requester->position ?? '' }}</small>
                                                    </td>
                                                    <td>{{ $gassRequest->requester->division->name ?? '' }}</td>
                                                    <td>Edit General Administrative and Support Services</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; justify-content: center; gap: 3px;">
                                                                
                                                            <button data-request-id="{{ $gassRequest->id }}"
                                                                data-reference-id="{{ $gassRequest->gass_id }}"
                                                                data-reference-name="{{ $gassRequest->gass->name }}"
                                                                data-reference-budget="{{ $gassRequest->gass->budget }}"
                                                                data-gass-requestor="{{ $gassRequest->requestor }}"
                                                                data-gass-budget="{{ $gassRequest->budget }}" class="btn action-btn buttonHover bg-primary viewGassRequest" title="View details" style="color: #FFFFFF;" data-bs-toggle="modal" data-bs-target="#viewEditGassRequestModal"><i class="fas fa-eye"></i>
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
                    <i class="fas fa-edit me-2"></i>View Request for Adding Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Division Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Division Responsible:</label>
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramNameRequest" id="addProgramNameRequest" autofocus></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramSuccessIndicatorRequest" id="addProgramSuccessIndicatorRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramQualityRequest" id="addProgramQualityRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramEfficiencyRequest" id="addProgramEfficiencyRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramTimelinessRequest" id="addProgramTimelinessRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramRemarksRequest" id="addProgramRemarksRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramBudgetRequest" id="addProgramBudgetRequest"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="addProgramApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="addProgramIdRequest" id="addProgramIdRequest">
                        <input type="hidden" name="divisionView" id="divisionView">
                        <input type="hidden" name="divisionIdView" id="divisionIdView">
                        <input type="hidden" name="addProgramRequestor" id="addProgramRequestor">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="addProgramDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" id="deleteProgramIdAddRequest">

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
<div class="modal fade" id="viewEditProgramRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewEditProgramRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewEditProgramRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Edit Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <div>
                    <h5 class="fw-bold mt-3">
                        Current Information
                    </h5>
                </div>
                <!-- Division Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Division Responsible:</label>
                    </div>
                    <div id="currentProgramDivisionsContainer" class="mb-2 d-flex flex-column gap-2">
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramName" id="existingProgramName" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramSuccessIndicator" id="existingProgramSuccessIndicator" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramQuality" id="existingProgramQuality" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramEfficiency" id="existingProgramEfficiency" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramTimeliness" id="existingProgramTimeliness" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramRemarks" id="existingProgramRemarks" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingProgramBudget" id="existingProgramBudget" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!--------------------Proposed Change -------------------->
                <!-- Division Responsible -->
                <div>
                    <h5 class="fw-bold mt-3">
                        Proposed Change
                    </h5>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Division Responsible:</label>
                    </div>
                    <div id="divisionInputsContainerEditProgram" class="mb-2 d-flex flex-column gap-2">
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramNameRequest" id="editProgramNameRequest" autofocus></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramSuccessIndicatorRequest" id="editProgramSuccessIndicatorRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramQualityRequest" id="editProgramQualityRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramEfficiencyRequest" id="editProgramEfficiencyRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramTimelinessRequest" id="editProgramTimelinessRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramRemarksRequest" id="editProgramRemarksRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editProgramBudgetRequest" id="editProgramBudgetRequest"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="editProgramApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="editProgramIdRequest" id="editProgramIdRequest">
                        <input type="hidden" name="divisionViewEditProgram" id="divisionViewEditProgram">
                        <input type="hidden" name="divisionIdViewEditProgram" id="divisionIdViewEditProgram">
                        <input type="hidden" name="editProgramRequestor" id="editProgramRequestor">
                        <input type="hidden" name="editProgramReference" id="editProgramReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="editProgramDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" id="deleteProgramIdEditRequest">

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

<!-- Program Delete Request Details Modal -->
<div class="modal fade" id="viewDeleteProgramRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewDeleteProgramRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewDeleteProgramRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Deletion Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Division Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Division Responsible:</label>
                    </div>
                    <div id="divisionInputsContainerDeleteProgram" class="mb-2 d-flex flex-column gap-2">
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteProgramNameRequest" id="deleteProgramNameRequest" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteProgramSuccessIndicatorRequest" id="deleteProgramSuccessIndicatorRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deletedProgramQualityRequest" id="deletedProgramQualityRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteProgramEfficiencyRequest" id="deleteProgramEfficiencyRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteProgramTimelinessRequest" id="deleteProgramTimelinessRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteProgramRemarksRequest" id="deleteProgramRemarksRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteProgramBudgetRequest" id="deleteProgramBudgetRequest" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="deleteProgramApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="deleteProgramIdRequest" id="deleteProgramIdRequest">
                        <input type="hidden" name="divisionViewDeleteProgram" id="divisionViewDeleteProgram">
                        <input type="hidden" name="divisionIdViewDeleteProgram" id="divisionIdViewDeleteProgram">
                        <input type="hidden" name="deleteProgramRequestor" id="deleteProgramRequestor">
                        <input type="hidden" name="deleteProgramReference" id="deleteProgramReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="deleteProgramDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" id="deleteProgramIdDeleteRequest">

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

<!-- Activity Add Request Details Modal -->
<div class="modal fade" id="viewAddActivityRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewAddActivityRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewAddActivityRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Adding Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Individual Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="employeeInputsContainer" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivityNameRequest" id="addActivityNameRequest" autofocus></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivitySuccessIndicatorRequest" id="addActivitySuccessIndicatorRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivityQualityRequest" id="addActivityQualityRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivityEfficiencyRequest" id="addActivityEfficiencyRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivityTimelinessRequest" id="addActivityTimelinessRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addActivityRemarksRequest" id="addActivityRemarksRequest"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="addActivityApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="addActivityIdRequest" id="addActivityIdRequest">
                        <input type="hidden" name="employeeView" id="employeeView">
                        <input type="hidden" name="employeeIdView" id="employeeIdView">
                        <input type="hidden" name="addActivityRequestor" id="addActivityRequestor">
                        <input type="hidden" name="addActivityProgramId" id="addActivityProgramId">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="addActivityDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="activity_id" id="deleteActivityIdAddRequest">

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

<!-- Activity Edit Request Details Modal -->
<div class="modal fade" id="viewEditActivityRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewEditActivityRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewEditActivityRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Edit Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <div>
                    <h5 class="fw-bold mt-3">
                        Current Information
                    </h5>
                </div>
                <!-- Individual Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="currentActivityIndividualContainer" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingActivityName" id="existingActivityName" autofocus></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingActivitySuccessIndicator" id="existingActivitySuccessIndicator"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingActivityQuality" id="existingActivityQuality"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingActivityEfficiency" id="existingActivityEfficiency"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingActivityTimeliness" id="existingActivityTimeliness"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingActivityRemarks" id="existingActivityRemarks"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!--------------------Proposed Change -------------------->
                <!-- Individual Responsible -->
                <div>
                    <h5 class="fw-bold mt-3">
                        Proposed Change
                    </h5>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="individualInputsContainerEditActivity" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editActivityNameRequest" id="editActivityNameRequest" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editActivitySuccessIndicatorRequest" id="editActivitySuccessIndicatorRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editActivityQualityRequest" id="editActivityQualityRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editActivityEfficiencyRequest" id="editActivityEfficiencyRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editActivityTimelinessRequest" id="editActivityTimelinessRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editActivityRemarksRequest" id="editActivityRemarksRequest" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="editActivityApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="editActivityIdRequest" id="editActivityIdRequest">
                        <input type="hidden" name="employeeViewEditActivity" id="employeeViewEditActivity">
                        <input type="hidden" name="employeeIdViewEditActivity" id="employeeIdViewEditActivity">
                        <input type="hidden" name="editActivityRequestor" id="editActivityRequestor">
                        <input type="hidden" name="editActivityReference" id="editActivityReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="editActivityDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="activity_id" id="deleteActivityIdEditRequest">

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

<!-- Activity Delete Request Details Modal -->
<div class="modal fade" id="viewDeleteActivityRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewDeleteActivityRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewDeleteActivityRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Deletion Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Individual Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="employeeInputsContainerDeleteActivity" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteActivityNameRequest" id="deleteActivityNameRequest" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteActivitySuccessIndicatorRequest" id="deleteActivitySuccessIndicatorRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteActivityQualityRequest" id="deleteActivityQualityRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteActivityEfficiencyRequest" id="deleteActivityEfficiencyRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteActivityTimelinessRequest" id="deleteActivityTimelinessRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteActivityRemarksRequest" id="deleteActivityRemarksRequest" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="deleteActivityApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="deleteActivityIdRequest" id="deleteActivityIdRequest">
                        <input type="hidden" name="employeeViewDeleteActivity" id="employeeViewDeleteActivity">
                        <input type="hidden" name="employeeIdViewDeleteActivity" id="employeeIdViewDeleteActivity">
                        <input type="hidden" name="deleteActivityRequestor" id="deleteActivityRequestor">
                        <input type="hidden" name="deleteActivityReference" id="deleteActivityReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="deleteActivityDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="activity_id" id="deleteActivityIdDeleteRequest">

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

<!-- Sub-Activity Add Request Details Modal -->
<div class="modal fade" id="viewAddSubActivityRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewAddSubActivityRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewAddSubActivityRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Adding Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Individual Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="employeeInputsContainerSub" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
                    </div>
                </div>
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
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSubActivityNameRequest" id="addSubActivityNameRequest" autofocus></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSubActivitySuccessIndicatorRequest" id="addSubActivitySuccessIndicatorRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSubActivityQualityRequest" id="addSubActivityQualityRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSubActivityEfficiencyRequest" id="addSubActivityEfficiencyRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSubActivityTimelinessRequest" id="addSubActivityTimelinessRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSubActivityRemarksRequest" id="addSubActivityRemarksRequest"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="addSubActivityApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="addSubActivityIdRequest" id="addSubActivityIdRequest">
                        <input type="hidden" name="employeeViewSub" id="employeeViewSub">
                        <input type="hidden" name="employeeIdViewSub" id="employeeIdViewSub">
                        <input type="hidden" name="addSubActivityRequestor" id="addSubActivityRequestor">
                        <input type="hidden" name="addParentActivityId" id="addParentActivityId">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="addSubActivityDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="sub_activity_id" id="deleteSubActivityIdAddRequest">

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

<!-- Sub-Activity Edit Request Details Modal -->
<div class="modal fade" id="viewSubEditActivityRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewSubEditActivityRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewSubEditActivityRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Edit Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <div>
                    <h5 class="fw-bold mt-3">
                        Current Information
                    </h5>
                </div>
                <!-- Individual Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="currentSubActivityIndividualContainer" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
                    </div>
                </div>
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
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingSubActivityName" id="existingSubActivityName" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingSubActivitySuccessIndicator" id="existingSubActivitySuccessIndicator" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingSubActivityQuality" id="existingSubActivityQuality" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingSubActivityEfficiency" id="existingSubActivityEfficiency" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingSubActivityTimeliness" id="existingSubActivityTimeliness" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="existingSubActivityRemarks" id="existingSubActivityRemarks" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!--------------------Proposed Change -------------------->
                <!-- Individual Responsible -->
                <div>
                    <h5 class="fw-bold mt-3">
                        Proposed Change
                    </h5>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="individualInputsContainerEditSubActivity" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
                    </div>
                </div>
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
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSubActivityNameRequest" id="editSubActivityNameRequest" autofocus></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSubActivitySuccessIndicatorRequest" id="editSubActivitySuccessIndicatorRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSubActivityQualityRequest" id="editSubActivityQualityRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSubActivityEfficiencyRequest" id="editSubActivityEfficiencyRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSubActivityTimelinessRequest" id="editSubActivityTimelinessRequest"></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editSubActivityRemarksRequest" id="editSubActivityRemarksRequest"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="editSubActivityApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="editSubActivityIdRequest" id="editSubActivityIdRequest">
                        <input type="hidden" name="employeeViewEditSubActivity" id="employeeViewEditSubActivity">
                        <input type="hidden" name="employeeIdViewEditSubActivity" id="employeeIdViewEditSubActivity">
                        <input type="hidden" name="editSubActivityRequestor" id="editSubActivityRequestor">
                        <input type="hidden" name="editSubActivityReference" id="editSubActivityReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="editSubActivityDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="sub_activity_id" id="deleteSubActivityIdEditRequest">

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

<!-- Sub-Activity Delete Request Details Modal -->
<div class="modal fade" id="viewDeleteSubActivityRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewDeleteSubActivityRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewDeleteSubActivityRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Deletion Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Individual Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Individual/s Responsible:</label>
                    </div>
                    <div id="employeeInputsContainerDeleteSubActivity" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
                    </div>
                </div>
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
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteSubActivityNameRequest" id="deleteSubActivityNameRequest" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteSubActivitySuccessIndicatorRequest" id="deleteSubActivitySuccessIndicatorRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteSubActivityQualityRequest" id="deleteSubActivityQualityRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteSubActivityEfficiencyRequest" id="deleteSubActivityEfficiencyRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteSubActivityTimelinessRequest" id="deleteSubActivityTimelinessRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="deleteSubActivityRemarksRequest" id="deleteSubActivityRemarksRequest" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="deleteSubActivityApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="deleteSubActivityIdRequest" id="deleteSubActivityIdRequest">
                        <input type="hidden" name="employeeViewDeleteSubActivity" id="employeeViewDeleteSubActivity">
                        <input type="hidden" name="employeeIdViewDeleteSubActivity" id="employeeIdViewDeleteSubActivity">
                        <input type="hidden" name="deleteSubActivityRequestor" id="deleteSubActivityRequestor">
                        <input type="hidden" name="deleteSubActivityReference" id="deleteSubActivityReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="deleteSubActivityDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="sub_activity_id" id="deleteSubActivityIdDeleteRequest">

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

<!-- GASS Edit Request Details Modal -->
<div class="modal fade" id="viewEditGassRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewEditGassRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewEditGassRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Edit Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-0">Program:</label>
                        <textarea class="form-control border-2 py-2 fw-bold text-uppercase"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassName" id="editGassName" disabled></textarea>
                    </div>
                    <h5 class="fw-bold mt-3">
                        Current Information
                    </h5>
                </div>
                
                <div class="table-responsive">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-0">Allotted Budget:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="existingGassBudget" id="existingGassBudget"></textarea>
                    </div>
                </div>

                <!--------------------Proposed Change -------------------->
                <div>
                    <h5 class="fw-bold mt-3">
                        Proposed Change
                    </h5>
                </div>
                <div class="table-responsive">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-0">Allotted Budget:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassBudget" id="editGassBudget"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="editGassApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="editGassRequestor" id="editGassRequestor">
                        <input type="hidden" name="editGassRequestId" id="editGassRequestId">
                        <input type="hidden" name="editGassReferenceId" id="editGassReferenceId">
                    
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="editGassDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="editGassDisapproveRequestId" id="editGassDisapproveRequestId">

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

<!-- GASS Critical Activity Request Details Modal -->
<div class="modal fade" id="viewAddGassCritRequestModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="viewAddGassCritRequestModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="viewAddGassCritRequestModalLabel">
                    <i class="fas fa-edit me-2"></i>View Request for Deletion Details
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <!-- Division Responsible -->
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <label class="form-label fw-bold text-dark mb-0">Division Responsible:</label>
                    </div>
                    <div id="divisionInputsContainerAddGassCrit" class="mb-2 d-flex flex-column gap-2">
                        <!-- JS will insert text inputs here -->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center border-success">
                        <thead class="table-light fw-bold text-dark">
                            <tr>
                                <th style="min-width: 200px;">Critical Activity Name</th>
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
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="AddGassCritNameRequest" id="AddGassCritNameRequest" autofocus readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="AddGassCritSuccessIndicatorRequest" id="AddGassCritSuccessIndicatorRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="AddGassCritQualityRequest" id="AddGassCritQualityRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="AddGassCritEfficiencyRequest" id="AddGassCritEfficiencyRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="AddGassCritTimelinessRequest" id="AddGassCritTimelinessRequest" readonly></textarea>
                                </td>
                                <td style="border: 1px solid #ccc; vertical-align: top;">
                                    <textarea class="form-control border-0 shadow-none auto-resize"
                                        style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="AddGassCritRemarksRequest" id="AddGassCritRemarksRequest" readonly></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                    <form class="addGassCritApproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="addGassCritRequestId" id="addGassCritRequestId">
                        <input type="hidden" name="divisionViewAddGassCrit" id="divisionViewAddGassCrit">
                        <input type="hidden" name="divisionIdViewAddGassCrit" id="divisionIdViewAddGassCrit">
                        <input type="hidden" name="addGassCritRequestor" id="addGassCritRequestor">
                        <input type="hidden" name="addGassCritReference" id="addGassCritReference">

                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>

                    <form class="addGassCritDisapproveForm" method="POST">
                        @csrf
                        <input type="hidden" name="program_id" id="addGassCritRequestIdDisapprove">

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
@endsection