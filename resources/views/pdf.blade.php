<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

    <style>
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

        /* th, td {
            border: 1px solid black;
        } */
    </style>
</head>
<body class="calibri">
    <div style="fixed; width: 100%; text-align: center;">
        <strong class="medium">INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW (TARGETS)</strong>
    </div>

    <table style="fixed; width: 100%; border:none;">
        <tr>
            <td colspan="6" style="text-align: justify; padding: 6px; vertical-align: middle;">
                <p class="small bold">I, {{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}, {{ $employee->position }} - {{ $employee->status }} of the PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE, {{ strtoupper($employee->division->name) ?? '' }}, the attainment of the following target in accordance with the indicated measures for the period JANUARY to DECEMBER 2025.</p>
            </td>
        </tr>

        <!-- Spacer -->
        <tr class="small" style="text-align: center;">
            <td colspan="6" style="min-height: 30px; height:30px;"></td>
        </tr>

        <!-- Employee Information -->
        <tr class="small">
            <td colspan="5"><p>4.8 to 5 – Outstanding  3.9 to 4.79 – Very Satisfactory  3 to 3.89 – Satisfactory  2 – Unsatisfactory  1 – Poor</p></td>
            <td style="text-align: center; width:16.6%;" class="bold">{{ strtoupper($employee->firstName . ' ' . ($employee->middleName ? substr($employee->middleName, 0, 1) . '. ' : '') . $employee->lastName) }}</td>
        </tr>
        <tr class="small">
            <td colspan="5"></td>
            <td style="text-align: center;" class="smaller">{{ $employee->position }}</td>
        </tr>
        <!-- Spacer -->
        <tr class="small" style="text-align: center;">
            <td colspan="6" style="min-height: 30px; height:30px;"></td>
        </tr>
    </table>


    <table style="fixed; width: 100%;" class="border">
        <tr class="small">
            <td class="border">Reviewed by</td>
            <td class="border">Date</td>
            <td class="border"></td>
            <td class="border">Date</td>
            <td class="border">Approved by</td>
            <td class="border">Date</td>
        </tr>

        <!-- Signing Individuals -->
        <tr class="smaller bold" style="text-align: center;">
            <td style="padding-top: 30px; width: 16.7%;" class="border">{{ strtoupper ($chiefInfo['name']) }}</td> <!--Supervisor-->
            <td style="padding-top: 30px; width: 16.7%;" class="border"></td>
            <td style="padding-top: 30px; width: 16.7%;" class="border">CAROL G. GUNTALILIB</td>
            <td style="padding-top: 30px; width: 16.7%;" class="border"></td>
            <td style="padding-top: 30px; width: 16.7%;" class="border">MA. CARLA LUCIA M. TORRALBA, DDM</td>
            <td style="padding-top: 30px; width: 16.7%;" class="border"></td>
        </tr>

        <!-- Position -->
        <tr class="smaller" style="text-align: center;">
            <td class="border">Supervisor</td>
            <td class="border"></td>
            <td class="border">Assistant PHRMO</td>
            <td class="border"></td>
            <td class="border">PHRMO</td>
            <td class="border"></td>
        </tr>

        <!-- Spacer -->
        <tr class="small" style="text-align: center;">
            <td colspan="6" style="min-height: 30px; height:30px;"></td>
        </tr>

        <!-- Header for PPA -->
        <tr class="smaller" style="text-align: center;">
            <td rowspan="2" class="bold border">PROGRAMS/PROJECTS/ACTIVITIES</td>
            <td rowspan="2" class="bold border">SUCCESS INDICATOR</td>
            <td colspan="3" class="bold small border">RATINGS</td>
            <td rowspan="2" class="bold border">REMARKS</td>
        </tr>
        <tr class="smaller" style="text-align: center;">
            <td class="bold border">QUALITY</td>
            <td class="bold border">EFFICIENCY</td>
            <td class="bold border">TIMELINESS</td>
        </tr>

        @php
            $printedPrograms = [];
            $printedActivities = [];
        @endphp

        @foreach($targets as $target)
            @php
                $programName = $target['program_name'] ?? 'N/A';
                $activityName = $target['activity_name'] ?? '';
            @endphp

            {{-- Program --}}
            @if(!in_array($programName, $printedPrograms))
                <tr class="small">
                    <td class="bold uppercase border">{{ $programName }}</td>
                    <td class="bold border" colspan="5"></td>
                </tr>
                @php $printedPrograms[] = $programName; @endphp
            @endif

            {{-- Activity --}}
            @if(!in_array($activityName, $printedActivities))
                <tr class="small">
                    <td class="uppercase border" style="text-indent: 5px;">{{ $activityName }}</td>
                    <td class="border">{{ $target['activity_success_indicator'] ?? '' }}</td>
                    <td class="border">{{ $target['activity_quality'] ?? '' }}</td>
                    <td class="border">{{ $target['activity_efficiency'] ?? '' }}</td>
                    <td class="border">{{ $target['activity_timeliness'] ?? '' }}</td>
                    <td class="border">{{ $target['activity_remarks'] ?? '' }}</td>
                </tr>
                @php $printedActivities[] = $activityName; @endphp
            @endif

            {{-- Sub-Activity (always print) --}}
            <tr class="small" style="vertical-align: top;">
                <td style="text-indent: 10px;" class="border">{{ $target['sub_activity_name'] ?? 'N/A' }}</td>
                <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_success_indicator'] ?? 'N/A' }}</td>
                <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_quality'] ?? 'N/A' }}</td>
                <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_efficiency'] ?? 'N/A' }}</td>
                <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_timeliness'] ?? 'N/A' }}</td>
                <td style="white-space: pre-wrap;" class="border">{{ $target['sub_activity_remarks'] ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>