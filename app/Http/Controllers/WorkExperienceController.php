<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\WorkExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function getWorkExperience(Request $request, PersonalInformation $personalInformation)
    {
        return $personalInformation->workExperience()->orderBy('start_date', 'desc')->get();
    }

    public function createWorkExperience(Request $request, PersonalInformation $personalInformation)
    {
        $request->validate([
            'company_name' => 'required|max:100',
            'position' => 'required|max:100',
            'currently_working' => 'required|bool',
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'end_date' => 'required_if:currently_working,false',
        ],[
            'end_date.required_if' => 'End date is required if currently not working.'
        ]);

        if(!$request->get('currently_working')) {
            $request->validate([
                'end_date' => 'date|date_format:Y-m-d|after_or_equal:start_date',
            ]);
        }

        $workExperience = new WorkExperience;
        $workExperience->personal_information_id = $personalInformation->id;
        $workExperience->company_name = $request->get('company_name');
        $workExperience->position = $request->get('position');
        $workExperience->start_date = Carbon::parse($request->get('start_date'));
        $workExperience->end_date = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : null;
        $workExperience->currently_working = $request->get('currently_working');
        $workExperience->save();
    }

    public function deleteWorkExperience(WorkExperience $workExperience)
    {
        $workExperience->delete();
    }
}
