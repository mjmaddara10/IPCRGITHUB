<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Project;
use App\Models\SubProject;
use App\Models\Program;
use App\Models\Employee;
use App\Models\Division;

class pdfController extends Controller
{
    public function generatePdf($id, Request $request) {

        $employee = Employee::with([
            'activities.program.divisions',
            'activities.subActivities',
            'subActivities.activity.program.divisions',
            'subActivities.activity'
        ])->find($id);

        $role = $employee->role;
        $targets = [];
        $gassPrograms = [];
        $groupedGassProgramsBySignatory = [];
        $groupedTargetsBySignatory = [];
    
        // 🔹 FOR DEPARTMENT HEAD — get ALL programs, activities, sub-activities
        if ($role === 'Department Head') {
            $allPrograms = Program::with([
                'divisions',
                'activities.subActivities'
            ])->get();
    
            foreach ($allPrograms as $program) {
                foreach ($program->activities as $activity) {
                    $programData = [
                        'program_id' => $program->id,
                        'program_name' => $program->name,
                        'program_order' => $program->order ?? 0,
                        'program_division' => $program->divisions->pluck('name')->toArray(),
                        'program_budget' => $program->budget,
                        'program_success_indicator' => $program->successIndicator,
                        'program_quality' => $program->quality,
                        'program_efficiency' => $program->efficiency,
                        'program_timeliness' => $program->timeliness,
                        'program_remarks' => $program->remarks,
                        'activity_id' => $activity->id,
                        'activity_name' => $activity->name,
                        'activity_order' => $activity->order ?? 0,
                        'activity_success_indicator' => $activity->successIndicator,
                        'activity_quality' => $activity->quality,
                        'activity_efficiency' => $activity->efficiency,
                        'activity_timeliness' => $activity->timeliness,
                        'activity_remarks' => $activity->remarks,
                        'sub_activity_id' => null,
                        'sub_activity_name' => null,
                        'sub_activity_success_indicator' => null,
                        'sub_activity_quality' => null,
                        'sub_activity_efficiency' => null,
                        'sub_activity_timeliness' => null,
                        'sub_activity_remarks' => null,
                        'sub_activity_order' => null,
                        'gass_id' => $program->gass_id,
                        'gass_name' => $program->gass ? $program->gass->name : null,
                        'gass_budget' => $program->gass ? $program->gass->budget : null,
                    ];

                    if (!is_null($program->gass_id)) {
                        $programData['gass_id'] = $program->gass_id;
                        $programData['gass_name'] = $program->gass ? $program->gass->name : null;
                        $gassPrograms[] = $programData;
                    } else {
                        $targets[] = $programData;
                    }
                }
            }
        } elseif ($role === 'Division Chief') {
            $divisionId = $employee->division_id; // Get division of the logged-in chief

            $programs = Program::whereHas('divisions', function ($query) use ($divisionId) {
                $query->where('divisions.id', $divisionId);
            })
            ->with([
                'divisions',
                'activities.subActivities.employees',
                'activities.employees',
                'gass'
            ])
            ->get();

            

            

            foreach ($programs as $program) {
                foreach ($program->activities as $activity) {
                    $activityEmployees = $activity->employees->map(function ($emp) {
                        return $emp->username;
                    })->toArray();

                    if ($activity->subActivities->isEmpty()) {
                        // Add only activity-level entry
                        $programData = [
                            'program_id' => $program->id,
                            'program_name' => $program->name,
                            'program_order' => $program->order ?? 0,
                            'program_division' => $program->divisions->pluck('name')->toArray(),
                            'program_budget' => $program->budget,
                            'program_success_indicator' => $program->successIndicator,
                            'program_quality' => $program->quality,
                            'program_efficiency' => $program->efficiency,
                            'program_timeliness' => $program->timeliness,
                            'program_remarks' => $program->remarks,
                            'activity_id' => $activity->id,
                            'activity_name' => $activity->name,
                            'activity_order' => $activity->order ?? 0,
                            'activity_success_indicator' => $activity->successIndicator,
                            'activity_quality' => $activity->quality,
                            'activity_efficiency' => $activity->efficiency,
                            'activity_timeliness' => $activity->timeliness,
                            'activity_remarks' => $activity->remarks,
                            'activity_employees' => $activityEmployees,
                            'sub_activity_employees' => $subActivityEmployees,
                            'sub_activity_id' => null,
                            'sub_activity_name' => null,
                            'sub_activity_success_indicator' => null,
                            'sub_activity_quality' => null,
                            'sub_activity_efficiency' => null,
                            'sub_activity_timeliness' => null,
                            'sub_activity_remarks' => null,
                            'sub_activity_order' => null,
                            'gass_id' => $program->gass_id,
                            'gass_name' => $program->gass->name ?? null,
                            'gass_budget' => $program->gass->budget ?? null,
                        ];

                        if ($program->gass_id) {
                            $gassPrograms[] = $programData;
                        } else {
                            $targets[] = $programData;
                        }
                    } else {
                        // Include all sub-activities
                        foreach ($activity->subActivities as $sub) {
                            $subActivityEmployees = $sub->employees->map(function ($emp) {
                                return $emp->username;
                            })->toArray();

                            $programData = [
                                'program_id' => $program->id,
                                'program_name' => $program->name,
                                'program_order' => $program->order ?? 0,
                                'program_division' => $program->divisions->pluck('name')->toArray(),
                                'program_budget' => $program->budget,
                                'program_success_indicator' => $program->successIndicator,
                                'program_quality' => $program->quality,
                                'program_efficiency' => $program->efficiency,
                                'program_timeliness' => $program->timeliness,
                                'program_remarks' => $program->remarks,
                                'activity_id' => $activity->id,
                                'activity_name' => $activity->name,
                                'activity_order' => $activity->order ?? 0,
                                'activity_success_indicator' => $activity->successIndicator,
                                'activity_quality' => $activity->quality,
                                'activity_efficiency' => $activity->efficiency,
                                'activity_timeliness' => $activity->timeliness,
                                'activity_remarks' => $activity->remarks,
                                'activity_employees' => $activityEmployees,
                                'sub_activity_employees' => $subActivityEmployees,
                                'sub_activity_id' => $sub->id,
                                'sub_activity_name' => $sub->name,
                                'sub_activity_order' => $sub->order ?? 0,
                                'sub_activity_success_indicator' => $sub->successIndicator,
                                'sub_activity_quality' => $sub->quality,
                                'sub_activity_efficiency' => $sub->efficiency,
                                'sub_activity_timeliness' => $sub->timeliness,
                                'sub_activity_remarks' => $sub->remarks,
                                'gass_id' => $program->gass_id,
                                'gass_name' => $program->gass->name ?? null,
                                'gass_budget' => $program->gass->budget ?? null,
                            ];

                            if ($program->gass_id) {
                                $gassPrograms[] = $programData;
                            } else {
                                $targets[] = $programData;
                            }
                        }
                    }
                }
            }
        }
        // 🔹 FOR STAFF or DIVISION CHIEF — only get what they are assigned to
        else {
            foreach ($employee->subActivities as $subActivity) {
                $activity = $subActivity->activity;

                if (!$activity) {
                    \Log::error("Missing activity for SubActivity ID: " . $subActivity->id);
                    continue;
                }

                $program = $activity->program;

                $pivotData = $subActivity->employees->where('id', $employee->id)->first()?->pivot;

                if (!$pivotData || !$pivotData->signatory_id) {
                    \Log::warning("No signatory assigned for employee ID {$employee->id} in sub-activity ID {$subActivity->id}");
                    continue;
                }

                $signatory = Employee::find($pivotData->signatory_id);
                if (!$signatory) {
                    \Log::warning("Signatory not found for ID {$pivotData->signatory_id}");
                    continue;
                }

                $signatoryName = strtoupper(
                    $signatory->firstName . ' ' .
                    ($signatory->middleName ? substr($signatory->middleName, 0, 1) . '. ' : '') .
                    $signatory->lastName
                );

                if (!isset($groupedTargetsBySignatory[$signatoryName])) {
                    $groupedTargetsBySignatory[$signatoryName] = [
                        'signatoryPosition' => $signatory->position,
                        'targets' => [],
                    ];
                }

                // Get employees assigned to the activity
                $activityEmployees = $activity->employees->map(function ($emp) {
                    return $emp->username;
                })->toArray();

                $subActivityEmployees = $subActivity->employees->map(function ($emp) {
                    return $emp->username;
                })->toArray();

                if (!is_null($program->gass_id)) {
                    $groupedGassProgramsBySignatory[$signatoryName]['targets'][] = [
                        'signatoryPosition' => $signatory->position,
                        'program_id' => $program->id,
                        'program_name' => $program->name,
                        'program_order' => $program->order ?? 0,
                        'program_division' => $program->divisions->pluck('name')->toArray(),
                        'program_budget' => $program->budget,
                        'program_success_indicator' => $program->successIndicator,
                        'program_quality' => $program->quality,
                        'program_efficiency' => $program->efficiency,
                        'program_timeliness' => $program->timeliness,
                        'program_remarks' => $program->remarks,
                        'activity_id' => $activity->id,
                        'activity_name' => $activity->name,
                        'activity_order' => $activity->order ?? 0,
                        'activity_success_indicator' => $activity->successIndicator,
                        'activity_quality' => $activity->quality,
                        'activity_efficiency' => $activity->efficiency,
                        'activity_timeliness' => $activity->timeliness,
                        'activity_remarks' => $activity->remarks,
                        'activity_employees' => $activityEmployees,
                        'sub_activity_employees' => $subActivityEmployees,
                        'sub_activity_id' => $subActivity->id,
                        'sub_activity_name' => $subActivity->name,
                        'sub_activity_success_indicator' => $subActivity->successIndicator,
                        'sub_activity_quality' => $subActivity->quality,
                        'sub_activity_efficiency' => $subActivity->efficiency,
                        'sub_activity_timeliness' => $subActivity->timeliness,
                        'sub_activity_remarks' => $subActivity->remarks,
                        'sub_activity_order' => $subActivity->order ?? 0,
                        'gass_id' => $program->gass_id,
                        'gass_name' => $program->gass ? $program->gass->name : null,
                        'gass_budget' => $program->gass ? $program->gass->budget : null,
                    ];
                } else {
                    // Otherwise, push to targets
                    $groupedTargetsBySignatory[$signatoryName]['targets'][] = [
                        'signatoryPosition' => $signatory->position,
                        'program_id' => $program->id,
                        'program_name' => $program->name,
                        'program_order' => $program->order ?? 0,
                        'program_budget' => $program->budget,
                        'activity_id' => $activity->id,
                        'activity_name' => $activity->name,
                        'activity_order' => $activity->order ?? 0,
                        'activity_employees' => $activityEmployees,
                        'sub_activity_employees' => $subActivityEmployees,
                        'sub_activity_id' => $subActivity->id,
                        'sub_activity_name' => $subActivity->name,
                        'sub_activity_success_indicator' => $subActivity->successIndicator,
                        'sub_activity_quality' => $subActivity->quality,
                        'sub_activity_efficiency' => $subActivity->efficiency,
                        'sub_activity_timeliness' => $subActivity->timeliness,
                        'sub_activity_remarks' => $subActivity->remarks,
                        'sub_activity_order' => $subActivity->order ?? 0,
                    ];
                }
            }
        }

        // dd($groupedGassProgramsBySignatory);
        $dateRange = request()->get('dateRange');
        $chiefInfo = json_decode($request->input('chiefInfo'), true);

        $user = auth()->user();

        $data = [
            'title' => $employee->lastName. ', ' .$employee->firstName,
            'content' => 'Hello, this is the content!',
            'employee' => $employee,
            'chiefInfo' => $chiefInfo,
            'targets' => $targets,
            'gasses' => $gassPrograms,
            'user' => $user,
            'dateRange' => $dateRange,
            'groupedGassProgramsBySignatory' => $groupedGassProgramsBySignatory,
            'groupedTargetsBySignatory' => $groupedTargetsBySignatory,
        ];

        

        if ($employee->role === 'Department Head') {
            $pdf = PDF::loadView('pdf.opcr', $data)->setPaper([0, 0, 936.0, 612.0]);
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
        } elseif ($employee->role === 'Division Chief') {
            $pdf = PDF::loadView('pdf.dpcr', $data)->setPaper([0, 0, 936.0, 612.0]);
            $pdf->set_option("isPhpEnabled", true);
            $pdf->set_option("isHtml5ParserEnabled", true);
            $pdf->set_option("isRemoteEnabled", true);
        } else {
            $pdf = PDF::loadView('pdf.ipcr', $data)->setPaper([0, 0, 936.0, 612.0]);
            $pdf->set_option("isPhpEnabled", true);
            $pdf->set_option("isHtml5ParserEnabled", true);
            $pdf->set_option("isRemoteEnabled", true);
        }

        // Get Dompdf instance BEFORE rendering
        $domPdf = $pdf->getDomPDF();

        // Get font metrics and canvas before render
        $fontMetrics = $domPdf->getFontMetrics();
        $canvas = $domPdf->getCanvas();
        $font = $fontMetrics->getFont('Helvetica', 'normal');

        // Attach the page script BEFORE calling render or stream
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas) use ($font, $fontMetrics) {
            $canvas->text(50, 50, "Page $pageNumber of $pageCount", $font, 20);
        });

        // Now render the PDF (this processes the page script)
        $domPdf->render();

        // Optional: get total page count after render if you want it separately
        $pageCount = $domPdf->getCanvas()->get_page_count();
        
        if ($role === 'Department Head') {
            return $pdf->stream($employee->lastName. ', ' .$employee->firstName. ' (OPCR).pdf');
        }else if ($role === 'Division Chief' || $role === 'Assistant Department Head'){
            return $pdf->stream($employee->lastName. ', ' .$employee->firstName. ' (DPCR).pdf');
        }else{
            return $pdf->stream($employee->lastName. ', ' .$employee->firstName. ' (IPCR).pdf');
        }
    }
}