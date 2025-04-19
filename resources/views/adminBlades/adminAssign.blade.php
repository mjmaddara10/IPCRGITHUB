<!-- Assign PPAs here -->
<!-- Save Changes button here -->
@extends('layouts')

<!-- Sets the page title in the browser tab -->
@section('title', 'Assign PPA')

<!-- Navigation Section -->
@section('navbar')
    @include('adminBlades.adminInclude')
@endsection

@section('content')
<div class="page-background"></div>

<div class="container-fluid mt-3">
    <div class="bg-white">

        <!-- Card Header -->
        <div class="card-header py-3 d-flex align-items-center nv-green">
            <div class="d-flex align-items-center">
                <i class="fas fa-tasks fa-2x text-white me-3"></i>
                <div>
                    <h4 class="mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Assign PPA</h4>
                    <small class="text-white-50">Assign PPA</small>
                </div>
            </div>
        </div>

        <div class="p-4 nv-green">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="d-flex align-items-center" style="color: #FFFFFF; font-weight: 500;">
                    <span>Select User:</span>
                    <select class="form-select" name="employeeSelect" id="employeeSelect">
                        <option value="">Select an Employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                data-name="{{ $employee->firstName }} {{ $employee->middleName ? substr($employee->middleName, 0, 1) . '.' : '' }} {{ $employee->lastName }}"
                                data-position="{{ $employee->position }}"
                                data-status="{{ $employee->status }}"
                                data-division-id="{{ $employee->division->id }}"
                                data-division-name="{{ $employee->division->name }}">
                                {{ $employee->firstName }} {{ $employee->middleName ? substr($employee->middleName, 0, 1) . '.' : '' }} {{ $employee->lastName }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Blue area -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="font-family: 'Montserrat'; background: #0d5cba; padding: 50px; color: #FFFFFF; text-align: justify;">
                <p class="justified-text" id="employeeCommitmentText">
                    I, <span id="empName" class="fw-bold text-light text-uppercase">________</span>,
                    <span id="empPosition" class="fw-bold text-light">________</span> -
                    <span id="empStatus" class="fw-bold text-light ">________</span><strong> of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE</strong>,
                    <span id="empDivision" class="fw-bold text-light text-uppercase">________</span>,
                    commit to deliver and agree to be rated on the attainment of the following targets in accordance with the indicated measures for the period January to December 2025.
                </p>

                    <!-- Nested row for inputs -->
                    <div class="row mt-3 align-items-center">
                        <!-- First Row -->
                        <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                            style="font-size: 0.875rem;">
                            <h6 class="mb-0 me-1 text-nowrap">Reviewed by:</h6>
                            <select class="form-select" style="width: 100%;">
                                <option value="">Select Reviewer</option>
                                <option value="reviewer1">Marc Jay Maddara</option>
                                <option value="reviewer2">Marc Justin Manzano</option>
                                <option value="reviewer3">Reviewer 3</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                            style="font-size: 0.875rem;">
                            <h6 class="mb-0 me-1 text-nowrap" style="margin-left: 105px;"></h6>
                            <select class="form-select" style="width: 100%;">
                                <option value="">Select Reviewer</option>
                                <option value="reviewer1">Reviewer 1</option>
                                <option value="reviewer2">Reviewer 2</option>
                                <option value="reviewer3">Reviewer 3</option>
                            </select>
                        </div>
                        <!-- Second Row -->
                        <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                            style="font-size: 0.875rem;">
                            <h6 class="mb-0 me-1 text-nowrap" style="margin-left: 36px;">Position:</h6>
                            <input type="text" class="form-control" style="width: 100%;" placeholder="Position">
                        </div>
                        <div class="col-md-6 col-sm-12 d-flex align-items-center flex-nowrap mb-3"
                            style="font-size: 0.875rem;">
                            <h6 class="mb-0 me-1 text-nowrap">Approved by:</h6>
                            <select class="form-select" style="width: 100%;">
                                <option value="">Approved by:</option>
                                <option value="department1">Department 1</option>
                                <option value="department2">Department 2</option>
                                <option value="department3">Department 3</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="container-fluid" style="padding: 0 0px;">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover" style="width: 100%;">

                    <thead class="text-center">
                        <tr>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Assign</th>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Major Programs/Project/Activities</th>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Success Indicator</th>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Quality</th>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Efficiency</th>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Timeliness</th>
                            <th style="color: #FFFFFF; background-color: #dd9f03;">Remarks/MOV</th>
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
                                <td class="text-center" style="background-color: #03592c; color:#FFFFFF; width: 5%;"><input type="checkbox"></td>
                                <td class="text-left border border-muted ps-1 fw-bold text-uppercase" style="background-color: #03592c; color:#FFFFFF; width: 13.57%;">{{ $program->name }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF; width: 13.57%;">{{ $program->successIndicator }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF; width: 13.57%;">{{ $program->quality }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF; width: 13.57%;">{{ $program->efficiency }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF; width: 13.57%;">{{ $program->timeliness }}</td>
                                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF; width: 13.57%;">{{ $program->remarks }}</td>
                                
                            </tr>

                            <!-- Activities in Program-->
                            @foreach($program->activities as $activity)
                                <tr data-program-id="{{ $program->id }}">
                                    <td class="text-center" style="background-color:rgb(212, 212, 212);"><input type="checkbox"></td>
                                    <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">{{ $activity->name }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->successIndicator }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->quality }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->efficiency }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->timeliness }}</td>
                                    <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->remarks }}</td>
                                </tr>

                                <!-- Sub-Activities -->
                                @foreach($activity->subActivities as $subActivity)
                                    <tr data-program-id="{{ $program->id }}">
                                        <td class="text-center"><input type="checkbox"></td>
                                        <td class="text-left" hidden>{{ $subActivity->id }}</td>
                                        <td class="text-left ps-3 border border-muted">{{ $subActivity->name }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->successIndicator }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->quality }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->efficiency }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->timeliness }}</td>
                                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->remarks }}</td>
                                    </tr>
                                    @endforeach
                                </tr>
                                
                            @endforeach        

                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Save Button -->
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-start mb-3 ms-4">
                    <a href="javascript:void(0)" onclick="confirmSave()" class="btn btn-success px-2">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
