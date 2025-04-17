<table id="ppaTable" class="table">
    <thead class="text-center">
        <tr>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Major Programs/Project/Activities</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Success Indicator</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Quality</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Efficiency</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Timeliness</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Remarks/MOV</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 5%;">Division/Individuals Responsible</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Actions</th>
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
                <td class="text-left border border-muted ps-1 fw-bold text-uppercase" style="background-color: #03592c; color:#FFFFFF">{{ $program->name }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->successIndicator }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->quality }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->efficiency }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->timeliness }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">{{ $program->remarks }}</td>
                @php
                    $allDivisionCount = \App\Models\Division::count();
                    $assignedCount = $program->divisions->count();
                @endphp

                <td class="text-center border border-muted"style="white-space: pre-wrap; background-color: #03592c; color:#FFFFFF">
                    @if ($assignedCount === $allDivisionCount)
                        All Divisions
                    @else
                        @foreach ($program->divisions as $division)
                            {{ $division->name }}
                        @endforeach
                    @endif
                </td>

                <!-- Buttons -->
                <td class="text-center" style= "color: #FFFFFF; background-color: #03592c;" colspan="3">
                    <!-- Add Activity -->
                    <button class="btn btn-sm addActivityInProgramBtn buttonHover" title="Add an activity"
                        data-program-id="{{ $program->id }}" 
                        data-program-name="{{ $program->name }}" data-bs-toggle="modal" data-bs-target="#addActivityInProgramModal" style= "background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                    </button>

                    <!-- Add Project -->
                    <!-- <button class="btn btn-sm addProjectBtn buttonHover" title="Add a project"
                        data-program-id="{{ $program->id }}" 
                        data-program-name="{{ $program->name }}" data-bs-toggle="modal" data-bs-target="#addProjectModal" style= "background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                    </button> -->

                    <!-- Edit Program -->
                    <button class="btn btn-sm editProgramBtn buttonHover" title="Edit program name"
                        data-program-id="{{ $program->id }}" 
                        data-program-name="{{ $program->name }}"
                        data-program-success="{{ $program->successIndicator }}"
                        data-program-quality="{{ $program->quality }}"
                        data-program-efficiency="{{ $program->efficiency }}"
                        data-program-timeliness="{{ $program->timeliness }}"
                        data-program-remarks="{{ $program->remarks }}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                    </button>

                    <!-- Delete Program -->
                    <button class="btn btn-sm deleteProgramBtn buttonHover" title="Delete program"
                        data-program-id="{{ $program->id }}"
                        data-url="{{ route('deleteProgram') }}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>

            <!-- Activities in Program-->
            @foreach($program->activities as $activity)
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
                @foreach($activity->subActivities as $subActivity)
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
                
            @endforeach        
        
        @endforeach
    </tbody>
</table>