<?php

use Illuminate\Support\Facades\Route;

//Country
Route::post('/surveyor/country', [App\Http\Controllers\Api\Customer\OrderController::class, 'get_country']);
Route::post('/surveyor/state', [App\Http\Controllers\Api\Customer\OrderController::class, 'get_state']);
Route::post('/surveyor/city', [App\Http\Controllers\Api\Customer\OrderController::class, 'get_city']);

Route::post('/surveyor/country/find-by-name', [App\Http\Controllers\Api\Customer\OrderController::class, 'findCountryByName']);
Route::post('/surveyor/state/find-by-name', [App\Http\Controllers\Api\Customer\OrderController::class, 'findStateByName']);
Route::post('/surveyor/city/find-by-name', [App\Http\Controllers\Api\Customer\OrderController::class, 'findCityByName']);

Route::post('/surveyor/login-email/send/otp', [App\Http\Controllers\Api\Surveyor\SurveyorAuth_Api::class, 'loginSendotpemail']);
Route::post('/surveyor/login-email/verify/otp', [App\Http\Controllers\Api\Surveyor\SurveyorAuth_Api::class, 'loginVerifyotpemail']);

Route::post('/surveyor/home', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'index']);
Route::post('/surveyor/accepted-assignments', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'accepted_assignments']);
Route::post('/surveyor/survey-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReport::class, 'survey_store']);




