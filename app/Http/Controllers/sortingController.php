<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Activity;
use App\Models\SubActivity;

class sortingController extends Controller
{
    public function moveProgram($id, $direction) {
        $program = Program::findOrFail($id);

        $swapProgram = Program::where('order', $direction === 'up'
        ? '<' : '>', $program->order)->orderBy('order', $direction === 'up' ? 'desc' : 'asc')->first();

        if ($swapProgram) {
            [$program->order, $swapProgram->order] = [$swapProgram->order, $program->order];
            $program->save();
            $swapProgram->save();
        }

        return back()->with('scrolled_id', 'program-' . $program->id);
    }

    public function moveActivity($id, $direction) {
        $activity = Activity::findOrFail($id);

        $swapActivity = Activity::where('order', $direction === 'up'
        ? '<' : '>', $activity->order)->orderBy('order', $direction === 'up' ? 'desc' : 'asc')->first();

        if ($swapActivity) {
            [$activity->order, $swapActivity->order] = [$swapActivity->order, $activity->order];
            $activity->save();
            $swapActivity->save();
        }

        return back()->with('scrolled_id', 'activity-' . $activity->id);
    }

    public function moveSubActivity($id, $direction) {
        $subActivity = SubActivity::findOrFail($id);

        $swapSubActivity = SubActivity::where('order', $direction === 'up'
        ? '<' : '>', $subActivity->order)->orderBy('order', $direction === 'up' ? 'desc' : 'asc')->first();

        if ($swapSubActivity) {
            [$subActivity->order, $swapSubActivity->order] = [$swapSubActivity->order, $subActivity->order];
            $subActivity->save();
            $swapSubActivity->save();
        }

        return back()->with('scrolled_id', 'subActivity-' . $subActivity->id);
    }
}
