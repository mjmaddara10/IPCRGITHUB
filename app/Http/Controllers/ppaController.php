<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ppaController extends Controller
{
    public function updateActivity(Request $request)
    {
        // Find the activity and update it
        $activity = Activity::findOrFail($request->activityId);
        $activity->update([
            'name' => $request->editActivityName,
            'successIndicator' => $request->editSuccessIndicator,
            'quality' => $request->editQuality,
            'efficiency' => $request->editEfficiency,
            'timeliness' => $request->editTimeliness,
        ]);

        // Return a response (this is what your AJAX call will use)
        return response()->json(['message' => 'Activity updated successfully!']);
    }
}
