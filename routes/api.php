<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalInformationController;

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

Route::get('/records-api/personal-information/{personalInformation}/get', [PersonalInformationController::class, 'getPersonalInformation'])->name('records.get-personal-information');
Route::post('/records-api/personal-information/create', [PersonalInformationController::class, 'createPersonalInformation'])->name('records.create-personal-information');
Route::post('/records-api/personal-information/{personalInformation}/update', [PersonalInformationController::class, 'updatePersonalInformation'])->name('records.update-personal-information');