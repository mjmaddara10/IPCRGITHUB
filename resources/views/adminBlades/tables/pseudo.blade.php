<!-- Programs -->
@foreach($programs as $program)
    <tr>program info</tr>

    <!-- Projects -->
    @foreach($program->projects as $project)
        <tr>project info</tr>

        <!-- Sub-Projects -->
        @foreach($project->subProjects as $subProject)
            <tr>sub-project info</tr>

            <!-- Activities under Sub-Projects -->
            @foreach($subProject->activities as $activity)
                <tr>activities under sub-project info</tr>

                <!-- Sub-Activities under Activities under Sub-Projects -->
                @foreach($activity->sub-activities as $sub-activity)
                    <tr>sub-activities under sub-project info</tr>
                @endforeach

            @endforeach

        @endforeach

        <!-- Activities under Projects -->
        @foreach($project->activities as $activity)
                <tr>activities under project info</tr>

                <!-- Sub-Activities under Activities under Projects -->
                @foreach($activity->sub-activities as $sub-activity)
                    <tr>sub-activities under activities under project info</tr>
                @endforeach

        @endforeach

    @endforeach

    <!-- Activities under Programs -->
    @foreach($project->activities as $activity)

        <!-- Sub-Activities under Activities under Programs -->
        <tr>activities under program info</tr>
        @foreach($activity->sub-activities as $sub-activity)
            <tr>sub-activities under activities under program info</tr>
        @endforeach

    @endforeach
    
@endforeach

<!-- <tr data-program-id="{{ $program->id }}">
            @foreach($project->activities as $activity)
                <td class="text-left border border-muted" hidden>{{ $activity->id }}</td>
                <td class="text-left ps-5 border border-muted">{{ $activity->name }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->successIndicator }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->quality }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->efficiency }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->timeliness }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->remarks }}</td>
                <td class="text-center border border-muted"style="white-space: pre-wrap;">{{ $activity->accountable }}</td>
                <td class="text-end border border-muted">
                    <button class="btn btn-sm editActivityBtn buttonHover" title="Edit activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                        data-activity-id="{{ $activity->id }}" 
                        data-activity-name="{{ $activity->name }}" 
                        data-success-indicator="{{ $activity->successIndicator }}"
                        data-quality="{{ $activity->quality }}"
                        data-efficiency="{{ $activity->efficiency }}"
                        data-timeliness="{{ $activity->timeliness }}"
                        data-remarks="{{ $activity->remarks }}"
                        data-bs-toggle="modal" data-bs-target="#editActivityModal"><i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm deleteActivityBtn buttonHover" title="Delete activity" style="color: rgb(144, 144, 144);background-color: rgb(212, 212, 212);"
                        data-activity-id="{{ $activity->id }}"
                        data-url="{{ route('deleteActivity') }}"><i class="fas fa-trash"></i>
                    </button>
                </td>
            
        </tr>
        @endforeach -->
