<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailPreferences extends Model
{
    use HasFactory;

    public function personalInformation()
    {
        $this->belongsTo(PersonalInformation::class);
    }
}
