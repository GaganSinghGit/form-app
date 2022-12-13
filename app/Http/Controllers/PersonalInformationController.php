<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Models\PersonalInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PersonalInformationController extends Controller
{
    public function getAllRecords()
    {
        return PersonalInformation::all();
    }

    public function getPersonalInformation(Request $request, PersonalInformation $personalInformation)
    {
        return $personalInformation;
    }

    public function createPersonalInformation(Request $request)
    {
        $personalInformation = PersonalInformation::create();
        return $personalInformation;
    }

    public function updatePersonalInformation(Request $request, PersonalInformation $personalInformation)
    {
        $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'date_of_birth' => 'required|date_format:Y-m-d|before:today'
        ]);
        
        $personalInformation->first_name = $request->get('first_name');
        $personalInformation->last_name = $request->get('last_name');
        $personalInformation->date_of_birth = Carbon::parse($request->get('date_of_birth'));
        $personalInformation->save();

        $personalInformation->emailPreferences()->create();
    }

    public function delete(Request $request, PersonalInformation $personalInformation)
    {
        $personalInformation->delete();
    }
}