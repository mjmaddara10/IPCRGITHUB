<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}</title>

        <style>
            @page {
                margin-bottom: 70px;
            }

            .calibri {
                font-family: Calibri, sans-serif;
            }

            .smaller {
                font-size: 10px;
            }

            .small {
                font-size: 12px;
            }

            .medium {
                font-size: 14px;
            }

            .bold {
                font-weight: bold;
            }

            .bolder {
                font-weight: bolder;
            }

            .border {
                border: 1px solid black;
                border-collapse: collapse;
            }

            .uppercase {
                text-transform: uppercase;
            }

            p {
                text-indent: 30px;
                margin-top: 0;
                margin-bottom: 0;
            }

            footer {
                position:fixed;
                bottom: 5px;
                width: 100%;
                text-align: right;
                font-size: 12px;
                padding: 5px 0;
            }

            .pageNumber:after {
                content: counter(page);
            }

            .totalPages:after {
                content: counter(pages);
            }
        </style>
    </head>

    <body class="calibri">
        <main>
            <div style="fixed; width: 100%; text-align: center;">
                @if($employee->role === 'Staff')
                    <strong class="medium">INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (TARGETS)</strong>
                @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                    <strong class="medium">DIVISION PERFORMANCE COMMITMENT AND REVIEW (TARGETS)</strong>
                @elseif($employee->role === 'Department Head')
                    <strong class="medium">OFFICE PERFORMANCE COMMITMENT AND REVIEW (OPCR)</strong>
                @endif
            </div>

            <!-- Paragraph -->
            <table style="margin-bottom: 20px; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        @if($employee->role === 'Staff' )
                            <td colspan="6" style="text-align: justify; padding: 6px; vertical-align: middle;" >
                                <p class="small bold">I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}, {{ $employee->position }} - {{ $employee->status }} of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE, {{ strtoupper($employee->division->name) ?? '' }}, commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.</p>
                            </td>
                        @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                            <td colspan="8" style="text-align: justify; padding: 6px; vertical-align: middle;" >
                                <p class="small bold">I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}, {{ $employee->position }} - {{ $employee->status }} of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE, {{ strtoupper($employee->division->name) ?? '' }}, commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.</p>
                            </td>
                        @elseif($employee->role === 'Department Head')
                            <td colspan="8" style="text-align: justify; padding: 6px; vertical-align: middle;" >
                                <p class="small bold">I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}, PHRMO, Provincial Government of Nueva Vizcaya, commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.</p>
                            </td>
                        @endif
                    </tr>

                    @if($employee->role === 'Staff' )
                        <!-- Spacer -->
                        <tr class="small" style="text-align: center;">
                            <td colspan="6" style="min-height: 30px; height:30px;"></td>
                        </tr>

                        <!-- Employee Information -->
                        <tr class="small" >
                            <td colspan="4" ><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
                            <td colspan="2" style="text-align: center;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
                        </tr>
                        <tr class="small">
                            <td colspan="4"></td>
                            <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                        </tr>

                        <!-- Spacer -->
                        <tr class="small" style="text-align: center;">
                            <td colspan="6" style="min-height: 30px; height:30px;"></td>
                        </tr>
                    @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                        <!-- Spacer -->
                        <tr class="small" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>

                        <!-- Employee Information -->
                        <tr class="small" >
                            <td colspan="6" ><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
                            <td colspan="2" style="text-align: center;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
                            
                        </tr>
                        <tr class="small">
                            <td colspan="6"></td>
                            <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                            
                        </tr>

                        <!-- Spacer -->
                        <tr class="small" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>
                    @elseif($employee->role === 'Department Head')
                        <!-- Spacer -->
                        <tr class="small" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>

                        <!-- Employee Information -->
                        <tr class="small" >
                            <td colspan="6" ><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
                            <td colspan="2" style="text-align: center;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
                        </tr>
                        <tr class="small">
                            <td colspan="6"></td>
                            <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                        </tr>

                        <!-- Spacer -->
                        <tr class="small" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>
                    @endif

                    <!-- Sign -->
                    @if($employee->role === 'Staff')
                        <tr class="small">
                            <td class="border">Reviewed by</td>
                            <td class="border">Date</td>
                            <td class="border"></td>
                            <td class="border">Date</td>
                            <td class="border">Approved by</td>
                            <td class="border">Date</td>
                        </tr>
                    @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                        <tr class="small">
                            <td class="border">Reviewed by</td>
                            <td class="border">Date</td>
                            <td class="border" colspan="2"></td>
                            <td class="border">Date</td>
                            <td class="border" colspan="2">Approved by</td>
                            <td class="border">Date</td>
                        </tr>
                    @elseif($employee->role === 'Department Head')
                        <tr class="small">
                            <td class="border">Approved by</td>
                            <td class="border">Date</td>
                            <td class="border" colspan="6"></td>
                        </tr>
                    @endif

                    <!-- Signing Individuals -->
                    @if($employee->role === 'Staff')
                        <tr class="smaller bold" style="text-align: center;">
                            <td style="padding-top: 30px;" class="border">{{ strtoupper ($chiefInfo['name']) }}</td> <!--Supervisor-->
                            <td style="padding-top: 30px;" class="border"></td>
                            <td style="padding-top: 30px;" class="border">CAROL G. GUNTALILIB</td>
                            <td style="padding-top: 30px;" class="border"></td>
                            <td style="padding-top: 30px;" class="border">MA. CARLA LUCIA M. TORRALBA, DDM</td>
                            <td style="padding-top: 30px;" class="border"></td>
                        </tr>
                    @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                        <tr class="smaller bold" style="text-align: center;">
                            <td style="padding-top: 30px;" class="border">CAROL G. GUNTALILIB</td> <!--Supervisor-->
                            <td style="padding-top: 30px;" class="border"></td>
                            <td style="padding-top: 30px;" class="border" colspan="2"></td>
                            <td style="padding-top: 30px;" class="border"></td>
                            <td style="padding-top: 30px;" class="border" colspan="2">MA. CARLA LUCIA M. TORRALBA, DDM</td>
                            <td class="border"></td>
                        </tr>
                    @elseif($employee->role === 'Department Head')
                        <tr class="smaller bold" style="text-align: center;">
                            <td style="padding-top: 30px;" class="border">JOSE V. GAMBITO</td> <!--Supervisor-->
                            <td style="padding-top: 30px;" class="border"></td>
                            <td style="padding-top: 30px;" class="border" colspan="6"></td>
                        </tr>
                    @endif
                    

                    <!-- Position -->
                    @if($employee->role === 'Staff')
                        <tr class="smaller" style="text-align: center;">
                            <td class="border">Supervisor</td>
                            <td class="border"></td>
                            <td class="border">Assistant PHRMO</td>
                            <td class="border"></td>
                            <td class="border">PHRMO</td>
                            <td class="border"></td>
                        </tr>
                        <tr class="small" style="text-align: center;">
                            <td colspan="6" style="min-height: 30px; height:30px;"></td>
                        </tr>
                    @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                        <tr class="smaller" style="text-align: center;">
                            <td class="border">Assistant PHRMO</td>
                            <td class="border"></td>
                            <td class="border" colspan="2"></td>
                            <td class="border"></td>
                            <td class="border" colspan="2">PHRMO</td>
                            <td class="border"></td>
                        </tr>
                        <tr class="small" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>
                    @elseif($employee->role === 'Department Head')
                        <tr class="smaller" style="text-align: center;">
                            <td class="border">Governor</td>
                            <td class="border"></td>
                            <td class="border" colspan="6"></td>
                        </tr>
                        <tr class="small" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>
                    @endif
                    
            

                    <!------------------------------ PPA ------------------------------>
                    @if($employee->role === 'Staff')
                    <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                        <td rowspan="2" class="bold border" style="width: 20%;">PROGRAMS/PROJECTS/ACTIVITIES</td>
                        <td rowspan="2" class="bold border" style="width: 20%;">SUCCESS INDICATOR</td>
                        <td colspan="3" class="bold small border">RATINGS</td>
                        <td rowspan="2" class="bold border">REMARKS</td>
                    </tr>
                    <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                        <td class="bold border">QUALITY</td>
                        <td class="bold border">EFFICIENCY</td>
                        <td class="bold border">TIMELINESS</td>
                    </tr>
                </thead>

                @php
                    $printedPrograms = [];
                    $printedActivities = [];
                @endphp

                @foreach($targets as $target)
                    @php
                        $programId = $target['program_id'] ?? '';
                        $activityId = $target['activity_id'] ?? '';
                    @endphp

                    {{-- Program --}}
                    @if(!in_array($programId, $printedPrograms))
                        <tr class="small">
                            <td class="bold uppercase border" >{{ $target['program_name'] ?? '' }}</td>
                            <td class="bold border" colspan="5"></td>
                        </tr>
                        @php $printedPrograms[] = $programId; @endphp
                    @endif

                    {{-- Activity --}}
                    @if(!in_array($activityId, $printedActivities))
                        <tr class="small">
                            <td class="uppercase border" style="padding-left: 5px;">{{ $target['activity_name'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_success_indicator'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_quality'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_efficiency'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_timeliness'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_remarks'] ?? '' }}</td>
                        </tr>
                        @php $printedActivities[] = $activityId; @endphp
                    @endif

                    {{-- Sub-Activity (always print) --}}
                    <tr class="small" style="vertical-align: top;">
                        <td style="text-indent: 10px;" class="border">{{ $target['sub_activity_name'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_success_indicator'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_quality'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_efficiency'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_timeliness'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_remarks'] ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
                    @elseif($employee->role === 'Division Chief' || $employee->role === 'Assistant Department Head')
                    <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                        <td rowspan="2" class="bold border" style="width: 20%;">PROGRAMS/PROJECTS/ACTIVITIES</td>
                        <td rowspan="2" class="bold border" style="width: 15%;">SUCCESS INDICATOR</td>
                        <td rowspan="2" class="bold border" style="width: 9%;">ALLOTTED BUDGET</td>
                        <td rowspan="2" class="bold border" style="width: 8%;">INDIVIDUAL/S RESPONSIBLE</td>
                        <td colspan="3" class="bold small border">RATINGS</td>
                        <td rowspan="2" class="bold border">REMARKS</td>
                    </tr>
                    <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                        <td class="bold border">QUALITY</td>
                        <td class="bold border">EFFICIENCY</td>
                        <td class="bold border">TIMELINESS</td>
                    </tr>
                </thead>

                @php
                    $printedPrograms = [];
                    $printedActivities = [];
                @endphp

                @foreach($targets as $target)
                    @php
                        $programId = $target['program_id'] ?? '';
                        $activityId = $target['activity_id'] ?? '';
                    @endphp

                    {{-- Program --}}
                    @if(!in_array($programId, $printedPrograms))
                        <tr class="small">
                            <td class="bold uppercase border" >{{ $target['program_name'] ?? '' }}</td>
                            <td class="bold border"></td>
                            <td class="border" style="text-align: right; padding: 0px 5px;">{{ $target['program_budget'] ?? '' }}</td>
                            <td class="bold border"></td>
                            <td class="bold border"></td>
                            <td class="bold border"></td>
                            <td class="bold border"></td>
                            <td class="bold border"></td>
                        </tr>
                        @php $printedPrograms[] = $programId; @endphp
                    @endif

                    {{-- Activity --}}
                    @if(!in_array($activityId, $printedActivities))
                        <tr class="small">
                            <td class="uppercase border" style="padding-left: 5px;">{{ $target['activity_name'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_success_indicator'] ?? '' }}</td>
                            <td class="border"></td>
                            <td class="border" style="padding: 5px;">
                                @if(!empty($target['activity_employees']))
                                    @foreach($target['activity_employees'] as $employee)
                                        {{ $employee }}<br>
                                    @endforeach
                                @endif
                            </td>
                            <td class="border">{{ $target['activity_quality'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_efficiency'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_timeliness'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_remarks'] ?? '' }}</td>
                        </tr>
                        @php $printedActivities[] = $activityId; @endphp
                    @endif

                    {{-- Sub-Activity (always print) --}}
                    <tr class="small" style="vertical-align: top;">
                        <td style="text-indent: 10px;" class="border">{{ $target['sub_activity_name'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_success_indicator'] ?? '' }}</td>
                        <td class="border"></td>
                        <td class="border" style="padding: 5px;">
                            @if(!empty($target['sub_activity_employees']))
                                @foreach($target['sub_activity_employees'] as $employee)
                                    {{ $employee }}<br>
                                @endforeach
                            @endif
                        </td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_quality'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_efficiency'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_timeliness'] ?? '' }}</td>
                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_remarks'] ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
                @elseif($employee->role === 'Department Head')
                    <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                        <td rowspan="2" class="bold border" style="width: 15%">PROGRAMS/PROJECTS/ACTIVITIES</td>
                        <td rowspan="2" class="bold border">SUCCESS INDICATOR</td>
                        <td rowspan="2" class="bold border" style="width: 7%">ALLOTTED BUDGET</td>
                        <td rowspan="2" class="bold border" style="width: 10%">DIVISION/S RESPONSIBLE</td>
                        <td colspan="3" class="bold small border">RATINGS</td>
                        <td rowspan="2" class="bold border">REMARKS</td>
                    </tr>
                    <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                        <td class="bold border">QUALITY</td>
                        <td class="bold border">EFFICIENCY</td>
                        <td class="bold border">TIMELINESS</td>
                    </tr>
                </thead>

                @php
                    $printedPrograms = [];
                    $printedActivities = [];
                @endphp

                @foreach($targets as $target)
                    @php
                        $programId = $target['program_id'] ?? '';
                        $activityId = $target['activity_id'] ?? '';
                    @endphp

                    {{-- Program --}}
                    @if(!in_array($programId, $printedPrograms))
                        <tr class="small">
                            <td class="bold uppercase border">{{ $target['program_name'] ?? '' }}</td>
                            <td class="border">{{ $target['program_success_indicator'] ?? '' }}</td>
                            <td class="border" style="text-align: right; padding: 0px 5px;">{{ $target['program_budget'] ?? '' }}</td>
                            <td class="border" style="padding: 0px 5px;">{!! is_array($target['program_division'] ?? null) ? implode('<br><br>', $target['program_division']) : ($target['program_division'] ?? '') !!}</td>
                            <td class="border">{{ $target['program_quality'] ?? '' }}</td>
                            <td class="border">{{ $target['program_efficiency'] ?? '' }}</td>
                            <td class="border">{{ $target['program_timeliness'] ?? '' }}</td>
                            <td class="border">{{ $target['program_remarks'] ?? '' }}</td>
                        </tr>
                        @php $printedPrograms[] = $programId; @endphp
                    @endif

                    {{-- Activity --}}
                    @if(!in_array($activityId, $printedActivities))
                        <tr class="small" style="vertical-align: top;">
                            <td class="uppercase border" style="padding-left:5px;">{{ $target['activity_name'] ?? '' }}</td>
                            <td class="border">{{ $target['activity_success_indicator'] ?? '' }}</td>
                            <td class="border"></td>
                            <td class="border"></td>
                            <td class="border" style="white-space: pre-wrap;">{{ $target['activity_quality'] ?? '' }}</td>
                            <td class="border" style="white-space: pre-wrap;">{{ $target['activity_efficiency'] ?? '' }}</td>
                            <td class="border" style="white-space: pre-wrap;">{{ $target['activity_timeliness'] ?? '' }}</td>
                            <td class="border" style="white-space: pre-wrap;">{{ $target['activity_remarks'] ?? '' }}</td>
                        </tr>
                        @php $printedActivities[] = $activityId; @endphp
                    @endif
                @endforeach                    
            </table>
            @endif
        </main>
        
        
        <footer>
            <div>Page <span class="pageNumber"></span></div>
        </footer>
    </body>
    
</html>
