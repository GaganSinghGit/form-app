<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\WorkExperienceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/records-api/records', [RecordController::class, 'getRecords'])->name('records.get-all-records');

Route::get('/records-api/personal-information/get-all', [PersonalInformationController::class, 'getAllRecords'])->name('records.get-all-personal-information-records');
Route::get('/records-api/personal-information/create', [PersonalInformationController::class, 'createPersonalInformation'])->name('records.create-personal-information');
Route::get('/records-api/personal-information/{personalInformation}/get', [PersonalInformationController::class, 'getPersonalInformation'])->name('records.get-personal-information');
Route::delete('/records-api/personal-information/{personalInformation}/delete', [PersonalInformationController::class, 'delete'])->name('records.delete');
Route::post('/records-api/personal-information/{personalInformation}/update', [PersonalInformationController::class, 'updatePersonalInformation'])->name('records.update-personal-information');

Route::get('/records-api/work-experience/{personalInformation}/get', [WorkExperienceController::class, 'getWorkExperience'])->name('records.get-work-experience');
Route::post('/records-api/work-experience/{personalInformation}/create', [WorkExperienceController::class, 'createWorkExperience'])->name('records.work-experience-create');
Route::delete('/records-api/work-experience/{workExperience}/delete', [WorkExperienceController::class, 'deleteWorkExperience'])->name('records.delete-work-experience');
Route::post('/records-api/work-experience/{workExperience}/update', [WorkExperienceController::class, 'updateWorkExperience'])->name('records.update-work-experience');

