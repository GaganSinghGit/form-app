<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    public function workExperience()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function emailPreferences()
    {
        return $this->hasOne(EmailPreferences::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
