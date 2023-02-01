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
Route::post('/surveyor/profile', [App\Http\Controllers\Api\Surveyor\AccountController::class, 'profile']);

Route::post('/surveyor/home', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'index']);
Route::post('/surveyor/accepted-assignments', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'accepted_assignments']);
Route::post('/surveyor/file-upload', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'file_upload']);
Route::post('/surveyor/survey-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'survey_store']);
Route::post('/surveyor/field-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'field_store']);

Route::post('/surveyor/assignments-requests', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'assignments_requests']);
Route::post('/surveyor/assignments-requests-status', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'assignments_requests_status']);

Route::post('/surveyor/notifications', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'notifications']);

Route::post('/surveyor/accepted-reassignments', [App\Http\Controllers\Api\Surveyor\Homepage::class, 'accepted_reassignments']);
Route::get('/surveyor/field-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'get_field_study']);
Route::get('/surveyor/survey-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'get_survey_study']);

Route::put('/surveyor/field-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'update_field_study']);
Route::put('/surveyor/survey-study-report', [App\Http\Controllers\Api\Surveyor\SurveyReportController::class, 'update_survey_study']);




