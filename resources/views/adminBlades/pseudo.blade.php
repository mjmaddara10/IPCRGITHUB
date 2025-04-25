@foreach($employee->selectedActivities as $selectedActivity)
    <tr data-program-id="{{ $program->id }}">
        <td class="text-left" hidden>{{ $activity->id }}</td>
        <td class="text-left border border-muted" style="background-color:rgb(212, 212, 212);">{{ $activity->name }}</td>
        <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->successIndicator }}</td>
        <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->quality }}</td>
        <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->efficiency }}</td>
        <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->timeliness }}</td>
        <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->remarks }}</td>
        <td class="text-left border border-muted"style="white-space: pre-wrap; background-color:rgb(212, 212, 212);">{{ $activity->accountable }}</td>
        <td class="text-center border border-muted" style="background-color:rgb(212, 212, 212);">
            <!-- Add Sub-Activity -->
            <button class="btn btn-sm addSubActivityBtn buttonHover" title="Add a sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                data-activity-id="{{ $activity->id }}" 
                data-activity-name="{{ $activity->name }}" data-bs-toggle="modal" data-bs-target="#addSubActivityModal"><i class="fas fa-plus" style= "-webkit-text-stroke: 1px white; color: #FFFFFF;"></i>
            </button>

            <!-- Edit Activity -->
            <button class="btn btn-sm editActivityBtn buttonHover" title="Edit activity" style="color: rgb(144, 144, 144); background-color: rgb(144, 144, 144);"
                data-activity-id="{{ $activity->id }}" 
                data-activity-name="{{ $activity->name }}" 
                data-success-indicator="{{ $activity->successIndicator }}"
                data-quality="{{ $activity->quality }}"
                data-efficiency="{{ $activity->efficiency }}"
                data-timeliness="{{ $activity->timeliness }}"
                data-remarks="{{ $activity->remarks }}"
                data-bs-toggle="modal" data-bs-target="#editActivityModal"><i class="fas fa-edit" style="color:#FFFFFF;"></i>
            </button>

            <!-- Delete Activity -->
            <button class="btn btn-sm deleteActivityBtn buttonHover" title="Delete activity" style="color: rgb(144, 144, 144);background-color: rgb(144, 144, 144);"
                data-activity-id="{{ $activity->id }}"
                data-url="{{ route('deleteActivity') }}"><i class="fas fa-trash" style="color:#FFFFFF;"></i>
            </button>
        </td>
    </tr>

    <!-- Sub-Activities -->
    @foreach($selectedActivity->selectedSubActivities as $selectedSubActivity)
        <tr data-program-id="{{ $program->id }}">
            <td class="text-left" hidden>{{ $subActivity->id }}</td>
            <td class="text-left ps-3 border border-muted">{{ $subActivity->name }}</td>
            <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->successIndicator }}</td>
            <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->quality }}</td>
            <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->efficiency }}</td>
            <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->timeliness }}</td>
            <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $subActivity->remarks }}</td>
            <td class="text-center border border-muted"style="white-space: pre-wrap;">{{ $subActivity->accountable }}</td>
            <td class="text-center border border-muted">

                <!-- Edit Sub-Activity -->
                <button class="btn btn-sm editSubActivityBtn buttonHover" title="Edit sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                    data-sub-activity-id="{{ $subActivity->id }}" 
                    data-sub-activity-name="{{ $subActivity->name }}" 
                    data-success-indicator="{{ $subActivity->successIndicator }}"
                    data-quality="{{ $subActivity->quality }}"
                    data-efficiency="{{ $subActivity->efficiency }}"
                    data-timeliness="{{ $subActivity->timeliness }}"
                    data-remarks="{{ $subActivity->remarks }}"
                    data-accountable="{{ $subActivity->accountable }}"
                    data-bs-toggle="modal" data-bs-target="#editSubActivityModal"><i class="fas fa-edit"></i>
                </button>

                <!-- Delete Sub-Activity -->
                <button class="btn btn-sm deleteSubActivityBtn buttonHover" title="Delete sub-activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                    data-sub-activity-id="{{ $subActivity->id }}"
                    data-url="{{ route('deleteSubActivity') }}"><i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tr>

    @foreach($programs as $program)
        @foreach($program->activities as $activity)
            @foreach($activity->subActivities as $subActivity)
            @endforeach
        @endforeach
    @endforeach
    
@endforeach  

// if (assignment.sub_activity_name) {
//     row += `
//     <tr>
//         <td class="text-left ps-3 border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_name).replace(/\n/g, '<br><br>')}</td>
//         <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_success_indicator).replace(/\n/g, '<br><br>')}</td>
//         <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_quality).replace(/\n/g, '<br><br>')}</td>
//         <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_efficiency).replace(/\n/g, '<br><br>')}</td>
//         <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_timeliness).replace(/\n/g, '<br><br>')}</td>
//         <td class="text-left border border-muted" style="background-color: #f8f8f8;">${safeValue(assignment.sub_activity_remarks).replace(/\n/g, '<br><br>')}</td>`;

//     if (isDeptHead) {
//         row += `
//             <td class="border border-muted" style="background-color: #f8f8f8;"></td>
//             <td class="border border-muted" style="background-color: #f8f8f8;"></td>
//         `;
//     }

//     row += `</tr>`;
// }