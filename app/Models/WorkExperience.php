<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class);
    }
}
