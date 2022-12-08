<?php

use App\Http\Controllers\PersonalInformationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/records/personal-information/{personalInformation}/get', [PersonalInformationController::class, 'getPersonalInformation'])->name('records.get-personal-information');
Route::post('/records/personal-information/create', [PersonalInformationController::class, 'createPersonalInformation'])->name('records.create-personal-information');
Route::post('/records/personal-information/{personalInformation}/update', [PersonalInformationController::class, 'updatePersonalInformation'])->name('records.update-personal-information');