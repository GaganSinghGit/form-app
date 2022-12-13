<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Http\Request;

class EmailPreferencesController extends Controller
{
    public function getEmailPreferences(PersonalInformation $personalInformation)
    {
        if(!PersonalInformation::where('id', $personalInformation->id)->exists()) {
            abort(304);
        }
        return $personalInformation->emailPreferences;
    }
    public function updateEmailPreferences(Request $request, PersonalInformation $personalInformation)
    {
        $request->validate([
            'marketing' => 'required|bool',
            'special_deals' =>'required|bool',
            'news_letter' => 'required|bool' 
        ]);
        $personalInformation->emailPreferences()->update([
            'marketing' => $request->get('marketing'),
            'special_deals' => $request->get('special_deals'),
            'news_letter' => $request->get('news_letter'),
        ]);
    }
}
