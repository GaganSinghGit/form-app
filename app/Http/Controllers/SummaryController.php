<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;

class SummaryController extends Controller
{
    public function getSummary(PersonalInformation $personalInformation)
    {
        return $personalInformation->load(['workExperience', 'emailPreferences']);
    }
}
