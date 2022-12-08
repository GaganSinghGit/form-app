<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;

class PersonalInformationController extends Controller
{
    public function getPersonalInformation(Request $request, PersonalInformation $personalInformation)
    {
        return $personalInformation;
    }

    public function createPersonalInformation(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:30',
            'first_name' => 'required|string|max:30',
            'date_of_birth' => 'required|date|before:today'
        ]);
        
        $personalInformation = new PersonalInformation;
        $personalInformation->first_name = $request->get('first_name');
        $personalInformation->last_name = $request->get('last_name');
        $personalInformation->date_of_birth = $request->get('date_of_birth');
        $personalInformation->save();
    }

    public function updatePersonalInformation(Request $request, PersonalInformation $personalInformation)
    {
        $request->validate([
            'first_name' => 'required|string|max:30',
            'first_name' => 'required|string|max:30',
            'date_of_birth' => 'required|date|before:today'
        ]);
        
        $personalInformation->first_name = $request->get('first_name');
        $personalInformation->last_name = $request->get('last_name');
        $personalInformation->date_of_birth = $request->get('date_of_birth');
        $personalInformation->save();
    }
}