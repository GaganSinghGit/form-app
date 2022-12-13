<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function getFeedback(Request $request, PersonalInformation $personalInformation)
    {
        return $personalInformation->feedback;
    }

    public function createFeedback(Request $request, PersonalInformation $personalInformation)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,10',
            'feedback_text' => 'required|string|max:200',
        ]);

        if($personalInformation->feedback()->exists()) {
            $personalInformation->feedback()->update([
                'rating' => $request->get('rating'),
                'feedback_text' => $request->get('feedback_text'),
            ]);
        };
        $personalInformation->feedback()->create([
            'rating' => $request->get('rating'),
            'feedback_text' => $request->get('feedback_text'),
        ]);
    }
}
