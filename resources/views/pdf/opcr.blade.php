<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}</title>

        <style>
            @page {
                margin-bottom: 70px;
                footer: html_footer;
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
            <!-- Info & Table -->
            <table style="margin-bottom: 20px; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <thead>
                    <!-- Header Title -->
                    <tr>
                        <td colspan="8" style="text-align: justify; padding: 6px; vertical-align: middle;">
                            <div style="width: 100%; text-align: center;">
                                <strong class="medium">OFFICE PERFORMANCE COMMITMENT AND REVIEW (OPCR)</strong>
                            </div>
                        </td>
                    </tr>

                    <!-- Paragraph -->
                    <tr>
                        <td colspan="8" style="text-align: justify; padding: 6px; vertical-align: middle;" >
                            <p class="small bold">I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}, PHRMO, Provincial Government of Nueva Vizcaya, commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.</p>
                        </td>
                    </tr>

                    <!-- Spacer -->
                    <tr class="smaller" style="text-align: center;">
                        <td colspan="8" style="min-height: 30px; height:30px;"></td>
                    </tr>

                    <!-- Employee Information -->
                    <tr class="smaller" >
                        <td colspan="6" ><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
                        <td colspan="2" style="text-align: center;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
                    </tr>
                    <tr class="smaller">
                        <td colspan="6"></td>
                        <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                    </tr>

                    <!-- Spacer -->
                    <tr class="smaller" style="text-align: center;">
                        <td colspan="8" style="min-height: 30px; height:30px;"></td>
                    </tr>

                    <!-- Sign -->
                    <tr class="smaller">
                        <td class="border">Approved by</td>
                        <td class="border"></td>
                        <td class="border" colspan="6"></td>
                    </tr>

                    <tr class="smaller bold" style="text-align: center;">
                        <td style="padding-top: 30px;" class="border">JOSE V. GAMBITO</td> <!--Supervisor-->
                        <td style="padding-top: 30px;" class="border"></td>
                        <td style="padding-top: 30px;" class="border" colspan="6"></td>
                    </tr>

                    <!-- Position -->
                    <tr class="smaller" style="text-align: center;">
                        <td class="border">Governor</td>
                        <td class="border">Date</td>
                        <td class="border" colspan="6"></td>
                    </tr>
                    <tr class="smaller" style="text-align: center;">
                        <td colspan="8" style="min-height: 30px; height:30px;"></td>
                    </tr>

                    <!-- PPA Header -->
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

                <tbody>
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
                            <tr class="smaller" style="vertical-align: top;">
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
                            <tr class="smaller" style="vertical-align: top;">
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
                </tbody>
            </table>
        
            <!-- GASS separate table -->
            <div style="page-break-before: always;">
                <table style="margin-bottom: 20px; border-collapse: collapse; table-layout: fixed; width: 100%;">
                    <thead>
                        <!-- Header Title -->
                        <tr>
                            <td colspan="8" style="text-align: justify; padding: 6px; vertical-align: middle;">
                                <div style="width: 100%; text-align: center;">
                                    <strong class="medium">OFFICE PERFORMANCE COMMITMENT AND REVIEW (OPCR)</strong>
                                </div>
                            </td>
                        </tr>

                        <!-- Paragraph -->
                        <tr>
                            <td colspan="8" style="text-align: justify; padding: 6px; vertical-align: middle;" >
                                <p class="smaller bold">I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}, PHRMO, Provincial Government of Nueva Vizcaya, commit to deliver and agree to be rated on the attainment of the following target in accordance with the indicated measures for the period {{ $dateRange }}.</p>
                            </td>
                        </tr>

                        <!-- Spacer -->
                        <tr class="smaller" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>

                        <!-- Employee Information -->
                        <tr class="smaller" >
                            <td colspan="6" ><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
                            <td colspan="2" style="text-align: center;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
                        </tr>
                        <tr class="smaller">
                            <td colspan="6"></td>
                            <td colspan="2" style="text-align: center;" class="smaller">{{ $employee->position }}</td>
                        </tr>

                        <!-- Spacer -->
                        <tr class="smaller" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>

                        <!-- Sign -->
                        <tr class="smaller">
                            <td class="border">Approved by</td>
                            <td class="border"></td>
                            <td class="border" colspan="6"></td>
                        </tr>

                        <tr class="smaller bold" style="text-align: center;">
                            <td style="padding-top: 30px;" class="border">JOSE V. GAMBITO</td> <!--Supervisor-->
                            <td style="padding-top: 30px;" class="border"></td>
                            <td style="padding-top: 30px;" class="border" colspan="6"></td>
                        </tr>

                        <!-- Position -->
                        <tr class="smaller" style="text-align: center;">
                            <td class="border">Governor</td>
                            <td class="border">Date</td>
                            <td class="border" colspan="6"></td>
                        </tr>
                        <tr class="smaller" style="text-align: center;">
                            <td colspan="8" style="min-height: 30px; height:30px;"></td>
                        </tr>

                        <!-- GASS Header -->
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
                        $printedGassName = [];
                        $printedGassPrograms = [];
                        $printedGassActivities = [];
                    @endphp

                    @foreach($gasses as $gass)
                        @php
                            $gassId = $gass['gass_id'] ?? '';
                            $gassProgramId = $gass['program_id'] ?? '';
                            $gassActivityId = $gass['activity_id'] ?? '';
                        @endphp

                        {{-- GASS Name --}}
                        @if(!in_array($gassId, $printedGassName))
                            <tr class="smaller" style="vertical-align: top;">
                                <td class="bold uppercase border" colspan="2">{{ strtoupper($gass['gass_name'] ?? '') }}</td>
                                <td class="border" style="text-align: right; padding: 0px 5px;">{{ $gass['gass_budget'] ?? '' }}</td>
                                <td class="bold border"></td>
                                <td class="bold border"></td>
                                <td class="bold border"></td>
                                <td class="bold border"></td>
                                <td class="bold border"></td>
                            </tr>
                            @php $printedGassName[] = $gassId; @endphp
                        @endif

                        {{-- Program --}}
                        @if(!in_array($gassProgramId, $printedGassPrograms))
                            <tr class="smaller" style="vertical-align: top;">
                                <td class="bold uppercase border">{{ $gass['program_name'] ?? '' }}</td>
                                <td class="border">{{ $gass['program_success_indicator'] ?? '' }}</td>
                                <td class="border" style="text-align: right; padding: 0px 5px;">{{ $gass['program_budget'] ?? '' }}</td>
                                <td class="border" style="padding: 0px 5px;">{!! is_array($gass['program_division'] ?? null) ? implode('<br><br>', $gass['program_division']) : ($gass['program_division'] ?? '') !!}</td>
                                <td class="border">{{ $gass['program_quality'] ?? '' }}</td>
                                <td class="border">{{ $gass['program_efficiency'] ?? '' }}</td>
                                <td class="border">{{ $gass['program_timeliness'] ?? '' }}</td>
                                <td class="border">{{ $gass['program_remarks'] ?? '' }}</td>
                            </tr>
                            @php $printedGassPrograms[] = $gassProgramId; @endphp
                        @endif

                        {{-- Activity --}}
                        @if(!in_array($gassActivityId, $printedGassActivities))
                            <tr class="smaller" style="vertical-align: top;">
                                <td class="uppercase border" style="padding-left:5px;">{{ $gass['activity_name'] ?? '' }}</td>
                                <td class="border">{{ $gass['activity_success_indicator'] ?? '' }}</td>
                                <td class="border"></td>
                                <td class="border"></td>
                                <td class="border" style="white-space: pre-wrap;">{{ $gass['activity_quality'] ?? '' }}</td>
                                <td class="border" style="white-space: pre-wrap;">{{ $gass['activity_efficiency'] ?? '' }}</td>
                                <td class="border" style="white-space: pre-wrap;">{{ $gass['activity_timeliness'] ?? '' }}</td>
                                <td class="border" style="white-space: pre-wrap;">{{ $gass['activity_remarks'] ?? '' }}</td>
                            </tr>
                            @php $printedGassActivities[] = $gassActivityId; @endphp
                        @endif
                    @endforeach
                </table>
            </div>
        </main>
        
        <footer>
            <div>Page <span class="pageNumber"></span></div>
        </footer>
        
    </body>
</html>