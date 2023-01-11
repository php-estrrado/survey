<?php

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
    return view('/welcome');
});

Auth::routes();

// Route::get('/', [App\Http\Controllers\Superadmin\AdminController::class, 'index']);

//  Route::view('/home', 'home')->middleware('auth');
 
// Route::get('/testmail', [App\Http\Controllers\Superadmin\AdminController::class, 'sendmail']);
// Route::get('/credits-cron', [App\Http\Controllers\CreditCronController::class, 'validateCredit']);
// Route::get('/credits-days-cron', [App\Http\Controllers\CreditCronController::class, 'validateCreditDays']);
// foreach (glob(__DIR__ . '/admin/*.php') as $filename) { require_once($filename); }
// foreach (glob(__DIR__ . '/seller/*.php') as $filename) { require_once($filename); }


// Route::post('/admin/getDropdown', [App\Http\Controllers\Superadmin\HomeController::class, 'dropdownData']);

// Route::get('/lockscreen', [App\Http\Controllers\HomeController::class, 'lockscreen'])->name('admin.lock');
// Route::get('/site-config', [App\Http\Controllers\HomeController::class, 'configSet'])->name('admin.config');
// Route::post('/admin/save-config', [App\Http\Controllers\HomeController::class, 'saveSet']);
// Route::get('/admin/clear-cache', [App\Http\Controllers\HomeController::class, 'clearSettings']);
// Route::post('/admin/unlock-password', [App\Http\Controllers\HomeController::class, 'unlockpwd']);

// Route::stripeWebhooks('stripe-webhook');

Route::get('/', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm']);

Route::get('/customer', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm']);

Route::get('/customer/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm']);
Route::post('/customer/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'adminLogin']);

Route::get('/customer/register', [App\Http\Controllers\Customer\RegisterController::class, 'index']);
Route::post('/customer/register', [App\Http\Controllers\Customer\RegisterController::class, 'register']);

Route::middleware('role:customer')->group(function () {

    Route::get('/customer/logout', [App\Http\Controllers\Customer\AdminController::class, 'adminLogout']);

    // Route::view('/admin', 'admin.admin');
    Route::get('/customer/profile', [App\Http\Controllers\Customer\AdminController::class, 'profile']);
    Route::post('customer/validate/profile', [App\Http\Controllers\Customer\AdminController::class, 'validateUser']);

    Route::get('/customer/dashboard', [App\Http\Controllers\Customer\AdminController::class, 'index']);

    //Hydrographic survey
    Route::get('/customer/hydrographic_survey', [App\Http\Controllers\Customer\HydrographicsurveyController::class, 'index'])->name('customer.hydrographic_survey');
    Route::get('/customer/hydrographic_survey/create', [App\Http\Controllers\Customer\HydrographicsurveyController::class, 'create'])->name('hydrographic_survey.create');
    Route::post('/customer/hydrographic_survey/save', [App\Http\Controllers\Customer\HydrographicsurveyController::class, 'saveSurvey']);


    //Tidal Observation survey
    Route::get('/customer/tidal_observation', [App\Http\Controllers\Customer\TidalController::class, 'index'])->name('customer.tidal_observation');
    Route::get('/customer/tidal_observation/create', [App\Http\Controllers\Customer\TidalController::class, 'create'])->name('tidal_observation.create');
    Route::post('/customer/tidal_observation/save', [App\Http\Controllers\Customer\TidalController::class, 'saveSurvey']);


    //Bottom Sample Collection
    Route::get('/customer/bottomsample', [App\Http\Controllers\Customer\BottomsampleController::class, 'index'])->name('customer.bottomsample');
    Route::get('/customer/bottomsample/create', [App\Http\Controllers\Customer\BottomsampleController::class, 'create'])->name('bottomsample.create');
    Route::post('/customer/bottomsample/save', [App\Http\Controllers\Customer\BottomsampleController::class, 'saveSurvey']);


    //Dredging survey form
    Route::get('/customer/dredging_survey', [App\Http\Controllers\Customer\DredgingsurveyController::class, 'index'])->name('customer.dredging_survey');
    Route::get('/customer/dredging_survey/create', [App\Http\Controllers\Customer\DredgingsurveyController::class, 'create'])->name('dredging_survey.create');
    Route::post('/customer/dredging_survey/save', [App\Http\Controllers\Customer\DredgingsurveyController::class, 'saveSurvey']);


    //Underwater videography service
    Route::get('/customer/underwater_videography', [App\Http\Controllers\Customer\UnderwatervideographyController::class, 'index'])->name('customer.underwater_videography');
    Route::get('/customer/underwater_videography/create', [App\Http\Controllers\Customer\UnderwatervideographyController::class, 'create'])->name('underwater_videography.create');
    Route::post('/customer/underwater_videography/save', [App\Http\Controllers\Customer\UnderwatervideographyController::class, 'saveSurvey']);


    //Current meter observation service
    Route::get('/customer/currentmeter_observation', [App\Http\Controllers\Customer\CurrentmeterobservationController::class, 'index'])->name('customer.currentmeter_observation');
    Route::get('/customer/currentmeter_observation/create', [App\Http\Controllers\Customer\CurrentmeterobservationController::class, 'create'])->name('currentmeter_observation.create');
    Route::post('/customer/currentmeter_observation/save', [App\Http\Controllers\Customer\CurrentmeterobservationController::class, 'saveSurvey']);


    //Sub bottom profilling Service
    Route::get('/customer/subbottom_profilling', [App\Http\Controllers\Customer\SubbottomprofillingController::class, 'index'])->name('customer.subbottom_profilling');
    Route::get('/customer/subbottom_profilling/create', [App\Http\Controllers\Customer\SubbottomprofillingController::class, 'create'])->name('subbottom_profilling.create');
    Route::post('/customer/subbottom_profilling/save', [App\Http\Controllers\Customer\SubbottomprofillingController::class, 'saveSurvey']);


    //Topographic survey
    Route::get('/customer/topographic_survey', [App\Http\Controllers\Customer\TopographicsurveyController::class, 'index'])->name('customer.topographic_survey');
    Route::get('/customer/topographic_survey/create', [App\Http\Controllers\Customer\TopographicsurveyController::class, 'create'])->name('topographic_survey.create');
    Route::post('/customer/topographic_survey/save', [App\Http\Controllers\Customer\TopographicsurveyController::class, 'saveSurvey']);


    //Side scan sonar
    Route::get('/customer/sidescanningsonar_survey', [App\Http\Controllers\Customer\SidescansonarsurveyController::class, 'index'])->name('customer.sidescanningsonar_survey');
    Route::get('/customer/sidescanningsonar_survey/create', [App\Http\Controllers\Customer\SidescansonarsurveyController::class, 'create'])->name('sidescanningsonar_survey.create');
    Route::post('/customer/sidescanningsonar_survey/save', [App\Http\Controllers\Customer\SidescansonarsurveyController::class, 'saveSurvey']);


    //Hydrographic data / chart
    Route::get('/customer/hydrographic_data', [App\Http\Controllers\Customer\HydrographicdataController::class, 'index'])->name('customer.hydrographic_data');
    Route::get('/customer/hydrographic_data/create', [App\Http\Controllers\Customer\HydrographicdataController::class, 'create'])->name('hydrographic_data.create');
    Route::post('/customer/hydrographic_data/save', [App\Http\Controllers\Customer\HydrographicdataController::class, 'saveSurvey']);


    //Requested Services
    Route::get('/customer/requested_services', [App\Http\Controllers\Customer\RequestedServicesController::class, 'index'])->name('customer.requested_services');
    Route::get('/customer/request_service_detail/{id}/{status}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'request_service_detail']);
    Route::get('/customer/request_service_invoice/{id}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'request_service_invoice']);

    Route::get('/customer/customer_invoice_download/{id}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'customer_invoice_download']);

    Route::post('/customer/customer_receipt_upload', [App\Http\Controllers\Customer\RequestedServicesController::class, 'customer_receipt_upload']);


    Route::post('/customer/getCity', [App\Http\Controllers\Customer\CityController::class, 'getCity']);

    Route::get('/customer/logout', [App\Http\Controllers\Customer\AdminController::class, 'adminLogout']);
});


//Superadmin

Route::get('/superadmin', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'superadmin']);
Route::get('/superadmin/login', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'superadmin']);
Route::post('/superadmin/sendotpemail', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/superadmin/regVerifyotpemail', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'regVerifyotpemail']);

Route::middleware('role:superadmin')->group(function () {
    Route::get('/superadmin/dashboard', [App\Http\Controllers\Superadmin\AdminController::class, 'index']);

    Route::get('/superadmin/user-roles', [App\Http\Controllers\Superadmin\UserRoleController::class, 'userRole'])->name('superadmin.user-roles');
    Route::get('/superadmin/user-roles/create', [App\Http\Controllers\Superadmin\UserRoleController::class, 'createRole'])->name('userRole.create');
    Route::get('/superadmin/user-roles/edit/{role}', [App\Http\Controllers\Superadmin\UserRoleController::class, 'editRole'])->name('userRole.edit');
    Route::get('/superadmin/user-roles/view/{role}', [App\Http\Controllers\Superadmin\UserRoleController::class, 'viewRole'])->name('userRole.view');
    Route::post('/superadmin/user-roles/save', [App\Http\Controllers\Superadmin\UserRoleController::class, 'roleSave']);
    Route::post('/superadmin/user-roles/delete', [App\Http\Controllers\Superadmin\UserRoleController::class, 'roleDelete']);
    Route::post('/superadmin/user-roles/status', [App\Http\Controllers\Superadmin\UserRoleController::class, 'roleStatus']);

    Route::get('/superadmin/modules', [App\Http\Controllers\Superadmin\ModulesController::class, 'modules'])->name('superadmin.modules');
    Route::get('/superadmin/modules/create', [App\Http\Controllers\Superadmin\ModulesController::class, 'createModule'])->name('module.create');
    Route::get('/superadmin/modules/edit/{id}', [App\Http\Controllers\Superadmin\ModulesController::class, 'editModule'])->name('module.edit');
    Route::post('/superadmin/modules/save', [App\Http\Controllers\Superadmin\ModulesController::class, 'moduleSave']);
    Route::post('/superadmin/modules/delete', [App\Http\Controllers\Superadmin\ModulesController::class, 'moduleDelete']);
    Route::post('/superadmin/modules/status', [App\Http\Controllers\Superadmin\ModulesController::class, 'moduleStatus']);

    Route::get('/superadmin/admins-list', [App\Http\Controllers\Superadmin\AdminController::class, 'admins'])->name('superadmin.admins');
    Route::get('/superadmin/admins-list/create', [App\Http\Controllers\Superadmin\AdminController::class, 'createAdmin'])->name('superadmin.create');
    Route::get('/superadmin/admins-list/edit/{role}', [App\Http\Controllers\Superadmin\AdminController::class, 'editAdmin'])->name('superadmin.edit');
    Route::get('/superadmin/admins-list/view/{admin}', [App\Http\Controllers\Superadmin\AdminController::class, 'viewAdmin'])->name('superadmin.view');
    Route::post('/superadmin/admins-list/save', [App\Http\Controllers\Superadmin\AdminController::class, 'adminSave']);
    Route::post('/superadmin/admins-list/status', [App\Http\Controllers\Superadmin\AdminController::class, 'adminStatus']);
    Route::post('/superadmin/admins-list/delete', [App\Http\Controllers\Superadmin\AdminController::class, 'adminDelete']);


    Route::get('/superadmin/offices', [App\Http\Controllers\Superadmin\OfficeController::class, 'office'])->name('superadmin.offices');
    Route::post('/superadmin/offices/save', [App\Http\Controllers\Superadmin\OfficeController::class, 'officeSave']);

    Route::get('/superadmin/customers', [App\Http\Controllers\Superadmin\CustomerController::class, 'index'])->name('superadmin.customers');
    Route::get('/superadmin/customers/create', [App\Http\Controllers\Superadmin\CustomerController::class, 'createCustomers']);
    Route::post('/superadmin/customers/customerSave', [App\Http\Controllers\Superadmin\CustomerController::class, 'customerSave']);

    Route::get('/superadmin/new_service_requests', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'new_service_requests'])->name('superadmin.new_service_requests');
    Route::get('/superadmin/new_service_request_detail/{id}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'new_service_request_detail'])->name('superadmin.new_service_request_detail');
    Route::post('/superadmin/assign_survey', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_survey']);

    Route::get('/superadmin/requested_services', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'requested_services'])->name('superadmin.requested_services');
    Route::get('/superadmin/requested_service_detail/{id}/{status}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'requested_service_detail'])->name('superadmin.requested_service_detail');
    Route::get('/superadmin/verify_field_study/{id}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'verify_field_study']);
    Route::post('/superadmin/assign_draftsman', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_draftsman']);
    Route::get('/superadmin/send_invoice_customer/{id}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'send_invoice_customer']);

    Route::post('/superadmin/assign_survey_study', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_survey_study']);
    Route::post('/superadmin/assign_draftsman_final', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_draftsman_final']);

    Route::get('/superadmin/logout', [App\Http\Controllers\Superadmin\AdminController::class, 'adminLogout']);
});


//Admin

Route::get('/admin', [App\Http\Controllers\Admin\Auth\LoginController::class, 'admin']);
Route::get('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'admin']);
Route::post('/admin/sendotpemail', [App\Http\Controllers\Admin\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/admin/regVerifyotpemail', [App\Http\Controllers\Admin\Auth\LoginController::class, 'regVerifyotpemail']);

Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index']);

    Route::get('/admin/logout', [App\Http\Controllers\Admin\AdminController::class, 'adminLogout']);

    Route::get('/admin/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers');
    Route::get('/admin/customers/create', [App\Http\Controllers\Admin\CustomerController::class, 'createCustomers']);
    Route::post('/admin/customers/customerSave', [App\Http\Controllers\Admin\CustomerController::class, 'customerSave']);
    Route::get('/admin/customers/customer_details/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'customer_details']);

    Route::get('/admin/new_service_requests', [App\Http\Controllers\Admin\ServicerequestsController::class, 'new_service_requests'])->name('admin.new_service_requests');
    Route::get('/admin/new_service_request_detail/{id}/{status}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'new_service_request_detail'])->name('admin.new_service_request_detail');
    Route::post('/admin/assign_surveyor', [App\Http\Controllers\Admin\ServicerequestsController::class, 'assign_surveyor']);

    Route::get('/admin/requested_services', [App\Http\Controllers\Admin\ServicerequestsController::class, 'requested_services'])->name('admin.requested_services');
    Route::get('/admin/requested_service_detail/{id}/{status}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'requested_service_detail'])->name('admin.requested_service_detail');
});


Route::get('/{page}', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/superadmin/{page}', [App\Http\Controllers\AdminController::class, 'superadmin']);
Route::get('/admin/{page}', [App\Http\Controllers\AdminController::class, 'admin']);
Route::get('/surveyor/{page}', [App\Http\Controllers\AdminController::class, 'surveyor']);
Route::get('/accountant/{page}', [App\Http\Controllers\AdminController::class, 'accountant']);
Route::get('/draftsman/{page}', [App\Http\Controllers\AdminController::class, 'draftsman']);