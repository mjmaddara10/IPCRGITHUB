<table id="ppaTable" class="table table-hover">
    <thead class="text-center">
        <tr>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Major Programs/Project/Activities1</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Success Indicator</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Quality</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Efficiency</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Timeliness</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Remarks/MOV</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 5%;">Category</th>
            <th class="border border-light" style="color: #FFFFFF; background-color: #dd9f03; width: 13.57%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Programs -->
        @foreach($programs as $program)
        <tr>
            <td class="text-left" style= "color: #FFFFFF; background-color: #03592c;" colspan="5">{{ $program->name }}</td>

            <td class="text-end" style= "color: #FFFFFF; background-color:#03592c;" colspan="3">

                <!-- Add Project -->
                <button class="btn btn-sm addProjectBtn buttonHover" title="Add a project"
                    data-program-id="{{ $program->id }}" 
                    data-program-name="{{ $program->name }}" data-bs-toggle="modal" data-bs-target="#addProjectModal" style= "background-color: rgb(1, 165, 80);"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                </button>

                <!-- Edit Program -->
                <button class="btn btn-sm editProgramBtn buttonHover" title="Edit program name"
                    data-program-id="{{ $program->id }}" 
                    data-program-name="{{ $program->name }}" data-bs-toggle="modal" data-bs-target="#editProgramModal" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-edit"></i>
                </button>

                <!-- Delete Program -->
                <button class="btn btn-sm deleteProgramBtn buttonHover" title="Delete program"
                    data-program-id="{{ $program->id }}"
                    data-url="{{ route('deleteProgram') }}" style= "color: #FFFFFF; background-color: rgb(1, 165, 80);"><i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        <tr>
            <!-- Projects -->
            @foreach($program->projects as $project)
            <td class="text-left" hidden>{{ $project->id }}</td>
            
            <td class="text-left ps-4" style= "color: #FFFFFF; background-color:rgb(1, 165, 80);" colspan="5">{{ $project->name }}</td>
            <td class="text-end" style= "color: #FFFFFF; background-color:rgb(1, 165, 80);" colspan="3">

                <!-- Add Sub-Project -->
                <button class="btn btn-sm addSubProjectBtn buttonHover" title="Add sub-project" style="background-color: #03592c; color: #ffffff;" 
                    data-project-id="{{ $project->id }}" 
                    data-project-name="{{ $project->name }}" data-bs-toggle="modal" data-bs-target="#addSubProjectModal"><i class="fas fa-caret-down"></i>
                </button>

                <!-- Add Activity -->
                <button class="btn btn-sm addActivityBtn buttonHover" title="Add an activity" style="background-color: #03592c;" 
                    data-project-id="{{ $project->id }}" 
                    data-project-name="{{ $project->name }}" data-bs-toggle="modal" data-bs-target="#addActivityModal"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                </button>

                <!-- Edit Project -->
                <button class="btn btn-sm editProjectBtn buttonHover" title="Edit project name" style="color: #ffffff;background-color: #03592c;" 
                    data-project-id="{{ $project->id }}" 
                    data-project-name="{{ $project->name }}" data-bs-toggle="modal" data-bs-target="#editProjectModal"><i class="fas fa-edit"></i>
                </button>

                <!-- Delete Project -->
                <button class="btn btn-sm deleteProjectBtn buttonHover" title="Delete project" style="color: #ffffff; background-color: #03592c;" 
                    data-project-id="{{ $project->id }}"
                    data-url="{{ route('deleteProject') }}"><i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>

        <!-- Sub-Projects -->
        <tr>
            @foreach($project->subProjects as $subProject)
            <td class="text-left" hidden>{{ $subProject->id }}</td>
            <td class="text-left ps-5" style= "background-color:rgb(212, 212, 212);" colspan="5">{{ $subProject->name }}</td>
            <td class="text-end" style= "background-color:rgb(212, 212, 212);" colspan="2">

                <!-- Add Activity in Sub-Project -->
                <button class="btn btn-sm addActivityInSubBtn buttonHover" title="Add an activity" style="background-color:rgb(144, 144, 144);"
                    data-sub-project-id="{{ $subProject->id }}" 
                    data-sub-project-name="{{ $subProject->name }}" data-bs-toggle="modal" data-bs-target="#addActivityInSubModal"><i class="fas fa-plus" style= "color: #FFFFFF; -webkit-text-stroke: 1px white;"></i>
                </button>

                <!-- Edit Sub-Project -->
                <button class="btn btn-sm editSubProjectBtn buttonHover" title="Edit sub-project name" style="background-color: rgb(144, 144, 144);"
                    data-sub-project-id="{{ $subProject->id }}" 
                    data-sub-project-name="{{ $subProject->name }}" data-bs-toggle="modal" data-bs-target="#editSubProjectModal"><i class="fas fa-edit" style= "color: #FFFFFF;"></i>
                </button>

                <!-- Delete Sub-Project -->
                <button class="btn btn-sm deleteSubProjectBtn buttonHover" title="Delete sub-project" style="background-color: rgb(144, 144, 144);"
                    data-sub-project-id="{{ $subProject->id }}"
                    data-url="{{ route('deleteSubProject') }}"><i class="fas fa-trash" style= "color: #FFFFFF;"></i>
                </button>
            </td>

                <!-- Activities in Sub-Project -->
                <tr>
                    @foreach($subProject->activities as $activity)
                        <td class="text-left" hidden>{{ $activity->id }}</td>
                        <td class="text-left ps-5 border border-muted">&nbsp;&nbsp;&nbsp;{{ $activity->name }}</td>
                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->successIndicator }}</td>
                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->quality }}</td>
                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->efficiency }}</td>
                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->timeliness }}</td>
                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->remarks }}</td>
                        <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->remarks }}</td>
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
                @endforeach
            @endforeach
        </tr>

        <tr>
            @foreach($project->activities as $activity)
                <td class="text-left border border-muted" hidden>{{ $activity->id }}</td>
                <td class="text-left ps-5 border border-muted">{{ $activity->name }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->successIndicator }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->quality }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->efficiency }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->timeliness }}</td>
                <td class="text-left border border-muted"style="white-space: pre-wrap;">{{ $activity->remarks }}</td>
                <td class="text-center border border-muted"style="white-space: pre-wrap;">OPCR</td>
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
        @endforeach
        @endforeach
        @endforeach
    </tbody>
</table>