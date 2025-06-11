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
            @if($employee->role === 'Staff')
                @foreach ($groupedTargetsBySignatory as $signatoryName => $data)
                    <div @if(!$loop->first) style="page-break-before: always;" @endif>
                        <!-- Info & Table -->
                        <table style="margin-bottom: 20px; border-collapse: collapse; table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <!-- Header -->
                                    <td colspan="6" style="text-align: justify; padding: 6px; vertical-align: middle;">
                                        <div style="width: 100%; text-align: center;">
                                            <strong class="medium">INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (TARGETS)</strong>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6" style="text-align: justify; padding: 6px; vertical-align: middle;">
                                        <p class="small bold">
                                            I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }},
                                            {{ $employee->position }} - {{ $employee->status }} of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE,
                                            {{ strtoupper($employee->division->name) ?? '' }},
                                            commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.
                                        </p>
                                    </td>
                                </tr>

                                <!-- Spacer -->
                                <tr class="small"><td colspan="6" style="height:30px;"></td></tr>

                                <!-- Employee Info -->
                                <tr class="smaller">
                                    <td colspan="4">
                                        <p>4.8 to 5 – Outstanding 3.9 to 4.79 – Very Satisfactory 3 to 3.89 – Satisfactory 2 – Unsatisfactory 1 – Poor</p>
                                    </td>
                                    <td colspan="2" style="text-align: center;" class="bold">
                                        {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}
                                    </td>
                                </tr>
                                <tr class="smaller">
                                    <td colspan="4"></td>
                                    <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                                </tr>

                                <!-- Spacer -->
                                <tr class="small"><td colspan="6" style="height:30px;"></td></tr>

                                <!-- Sign -->
                                <tr class="smaller">
                                    <td class="border">Reviewed by</td>
                                    <td class="border"></td>
                                    <td class="border"></td>
                                    <td class="border"></td>
                                    <td class="border">Approved by</td>
                                    <td class="border"></td>
                                </tr>
                                <tr class="smaller bold" style="text-align: center;">
                                    <td class="border" style="padding-top: 30px;">{{ $signatoryName }}</td>
                                    <td class="border" style="padding-top: 30px;"></td>
                                    <td class="border" style="padding-top: 30px;">CAROL G. GUNTALILIB</td>
                                    <td class="border" style="padding-top: 30px;"></td>
                                    <td class="border" style="padding-top: 30px;">MA. CARLA LUCIA M. TORRALBA, DDM</td>
                                    <td class="border" style="padding-top: 30px;"></td>
                                </tr>
                                <tr class="smaller" style="text-align: center;">
                                    <td class="border">{{ $data['signatoryPosition'] }}</td>
                                    <td class="border">Date</td>
                                    <td class="border">Assistant PHRMO</td>
                                    <td class="border">Date</td>
                                    <td class="border">PHRMO</td>
                                    <td class="border">Date</td>
                                </tr>

                                <tr class="smaller"><td colspan="6" style="height:30px;"></td></tr>

                                <!-- PPA Header -->
                                <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                                    <td rowspan="2" class="bold border" style="width: 18%;">PROGRAMS/PROJECTS/ACTIVITIES</td>
                                    <td rowspan="2" class="bold border" style="width: 15%;">SUCCESS INDICATOR</td>
                                    <td colspan="3" class="bold small border">RATINGS</td>
                                    <td rowspan="2" class="bold border" style="width: 15%;">REMARKS</td>
                                </tr>
                                <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                                    <td class="bold border">QUALITY</td>
                                    <td class="bold border">EFFICIENCY</td>
                                    <td class="bold border">TIMELINESS</td>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $printedPrograms = [];
                                    $printedActivities = [];
                                @endphp

                                @foreach($data['targets'] as $target)
                                    @php
                                        $programId = $target['program_id'] ?? '';
                                        $activityId = $target['activity_id'] ?? '';
                                    @endphp

                                    {{-- Program --}}
                                    @if (!in_array($programId, $printedPrograms))
                                        <tr class="smaller" style="vertical-align: top;">
                                            <td class="bold uppercase border">{{ $target['program_name'] ?? '' }}</td>
                                            <td class="bold border" colspan="5"></td>
                                        </tr>
                                        @php $printedPrograms[] = $programId; @endphp
                                    @endif

                                    {{-- Activity --}}
                                    @if (!in_array($activityId, $printedActivities))
                                        <tr class="smaller" style="vertical-align: top;">
                                            <td class="uppercase border" style="padding-left: 5px;">{{ $target['activity_name'] ?? '' }}</td>
                                            <td class="border">{{ $target['activity_success_indicator'] ?? '' }}</td>
                                            <td class="border">{{ $target['activity_quality'] ?? '' }}</td>
                                            <td class="border">{{ $target['activity_efficiency'] ?? '' }}</td>
                                            <td class="border">{{ $target['activity_timeliness'] ?? '' }}</td>
                                            <td class="border">{{ $target['activity_remarks'] ?? '' }}</td>
                                        </tr>
                                        @php $printedActivities[] = $activityId; @endphp
                                    @endif

                                    {{-- Sub-Activity --}}
                                    <tr class="smaller" style="vertical-align: top;">
                                        <td style="text-indent: 10px;" class="border">{{ $target['sub_activity_name'] ?? '' }}</td>
                                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_success_indicator'] ?? '' }}</td>
                                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_quality'] ?? '' }}</td>
                                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_efficiency'] ?? '' }}</td>
                                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_timeliness'] ?? '' }}</td>
                                        <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_remarks'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                @foreach ($groupedGassProgramsBySignatory as $signatoryName => $data)
                    <!-- GASS separate table -->
                    <div style="page-break-before: always;">
                        <table style="margin-bottom: 20px; border-collapse: collapse; table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <!-- Header -->
                                    <td colspan="6" style="text-align: justify; padding: 6px; vertical-align: middle;">
                                        <div style="width: 100%; text-align: center;">
                                            <strong class="medium">INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (TARGETS)</strong>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6" style="text-align: justify; padding: 6px; vertical-align: middle;">
                                        <p class="smaller bold">
                                            I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }},
                                            {{ $employee->position }} - {{ $employee->status }} of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE,
                                            {{ strtoupper($employee->division->name) ?? '' }},
                                            commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.
                                        </p>
                                    </td>
                                </tr>

                                <!-- Spacer -->
                                <tr class="smaller" style="text-align: center;">
                                    <td colspan="6" style="min-height: 30px; height:30px;"></td>
                                </tr>

                                <!-- Employee Information -->
                                <tr class="smaller" >
                                    <td colspan="4" ><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
                                    <td colspan="2" style="text-align: center;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
                                    
                                </tr>
                                <tr class="smaller">
                                    <td colspan="4"></td>
                                    <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                                    
                                </tr>

                                <!-- Spacer -->
                                <tr class="smaller" style="text-align: center;">
                                    <td colspan="6" style="min-height: 30px; height:30px;"></td>
                                </tr>

                                <tr class="smaller">
                                    <td class="border">Reviewed by</td>
                                    <td class="border"></td>
                                    <td class="border"></td>
                                    <td class="border" colspan="2">Approved by</td>
                                    <td class="border"></td>
                                </tr>

                                <tr class="smaller bold" style="text-align: center;">
                                    <td style="padding-top: 30px;" class="border">CAROL G. GUNTALILIB</td> <!--Supervisor-->
                                    <td style="padding-top: 30px;" class="border"></td>
                                    <td style="padding-top: 30px;" class="border"></td>
                                    <td style="padding-top: 30px;" class="border" colspan="2">MA. CARLA LUCIA M. TORRALBA, DDM</td>
                                    <td class="border"></td>
                                </tr>

                                <tr class="smaller" style="text-align: center;">
                                    <td class="border">Assistant PHRMO</td>
                                    <td class="border">Date</td>
                                    <td class="border"></td>
                                    <td class="border" colspan="2">PHRMO</td>
                                    <td class="border">Date</td>
                                </tr>
                                <tr class="smaller" style="text-align: center;">
                                    <td colspan="6" style="min-height: 30px; height:30px;"></td>
                                </tr>

                                <!-- GASS Header -->
                                <tr class="smaller" style="text-align: center; background-color:rgb(225, 225, 225);">
                                    <td rowspan="2" class="bold border" style="width: 20%;">PROGRAMS/PROJECTS/ACTIVITIES</td>
                                    <td rowspan="2" class="bold border" style="width: 15%;">SUCCESS INDICATOR</td>
                                    
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
                                $printedGassNames = [];
                                $printedGassPrograms = [];
                                $printedGassActivities = [];
                            @endphp

                            @foreach($data['targets'] as $gass)
                                @php
                                    $gassName = $gass['gass_name'] ?? '';
                                    $gassProgramId = $gass['program_id'] ?? '';
                                    $gassActivityId = $gass['activity_id'] ?? '';
                                @endphp

                                {{-- GASS Name --}}
                                @if($gassName && !in_array($gassName, $printedGassNames))
                                    <tr class="smaller" style="vertical-align: top;">
                                        <td class="bold uppercase border" colspan="2">{{ strtoupper($gassName) }}</td>
                                        <td class="bold border"></td>
                                        <td class="bold border"></td>
                                        <td class="bold border"></td>
                                        <td class="bold border"></td>
                                    </tr>
                                    @php $printedGassNames[] = $gassName; @endphp
                                @endif

                                {{-- Program --}}
                                @if(!in_array($gassProgramId, $printedGassPrograms))
                                    <tr class="smaller" style="vertical-align: top;">
                                        <td class="uppercase border" >{{ $gass['program_name'] ?? '' }}</td>
                                        <td class="bold border"></td>
                                        
                                        <td class="bold border"></td>
                                        <td class="bold border"></td>
                                        <td class="bold border"></td>
                                        <td class="bold border"></td>
                                    </tr>
                                    @php $printedGassPrograms[] = $gassProgramId; @endphp
                                @endif

                                {{-- Activity --}}
                                @if(!in_array($gassActivityId, $printedGassActivities))
                                    <tr class="smaller" style="vertical-align: top;">
                                        <td class="border" style="padding-left: 5px;">{{ $gass['activity_name'] ?? '' }}</td>
                                        <td class="border">{{ $gass['activity_success_indicator'] ?? '' }}</td>
                                        
                                        <td class="border">{{ $gass['activity_quality'] ?? '' }}</td>
                                        <td class="border">{{ $gass['activity_efficiency'] ?? '' }}</td>
                                        <td class="border">{{ $gass['activity_timeliness'] ?? '' }}</td>
                                        <td class="border">{{ $gass['activity_remarks'] ?? '' }}</td>
                                    </tr>
                                    @php $printedGassActivities[] = $gassActivityId; @endphp
                                @endif

                                {{-- Sub-Activity (always print) --}}
                                <tr class="smaller" style="vertical-align: top;">
                                    <td style="text-indent: 10px;" class="border">{{ $gass['sub_activity_name'] ?? '' }}</td>
                                    <td style="white-space: pre-wrap;" class="border">{{ $gass['sub_activity_success_indicator'] ?? '' }}</td>
                                    
                                    <td style="white-space: pre-wrap;" class="border">{{ $gass['sub_activity_quality'] ?? '' }}</td>
                                    <td style="white-space: pre-wrap;" class="border">{{ $gass['sub_activity_efficiency'] ?? '' }}</td>
                                    <td style="white-space: pre-wrap;" class="border">{{ $gass['sub_activity_timeliness'] ?? '' }}</td>
                                    <td style="white-space: pre-wrap;" class="border">{{ $gass['sub_activity_remarks'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endforeach
            @endif
        </main>
        
        <footer>
            <div>Page <span class="pageNumber"></span></div>
        </footer>
    </body>
</html>
