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

Auth::routes();

Route::get('/', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm']);
Route::get('/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm'])->name('login');

Route::get('/customer', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm']);

Route::get('/customer/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showAdminLoginForm']);
Route::post('/customer/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'adminLogin']);

Route::get('/customer/register', [App\Http\Controllers\Customer\RegisterController::class, 'index']);
Route::post('/customer/register', [App\Http\Controllers\Customer\RegisterController::class, 'register']);

Route::get('/customer/forgotPassword', [App\Http\Controllers\Customer\Auth\LoginController::class, 'forgotPassword']);

Route::post('/customer/send_otp', [App\Http\Controllers\Customer\Auth\LoginController::class, 'send_otp']);
Route::post('/customer/verify_otp', [App\Http\Controllers\Customer\Auth\LoginController::class, 'verify_otp']);

Route::post('/customer/update_password', [App\Http\Controllers\Customer\Auth\LoginController::class, 'update_password']);

Route::middleware('role:customer','revalidate')->group(function () {

    Route::get('/customer/logout', [App\Http\Controllers\Customer\AdminController::class, 'adminLogout']);

    Route::get('/customer/notifications', [App\Http\Controllers\Customer\AdminController::class, 'notifications']);
    Route::post('/customer/mark-notifications', [App\Http\Controllers\Customer\AdminController::class, 'marknotifications']);
    // Route::view('/admin', 'admin.admin');
    Route::get('/customer/profile', [App\Http\Controllers\Customer\AdminController::class, 'profile'])->name('customer.profile');
    Route::post('/customer/edit_profile', [App\Http\Controllers\Customer\AdminController::class, 'edit_profile']);
    Route::post('customer/validate/profile', [App\Http\Controllers\Customer\AdminController::class, 'validateUser']);

    Route::get('/customer/dashboard', [App\Http\Controllers\Customer\AdminController::class, 'index']);

    Route::post('/customer/search', [App\Http\Controllers\Customer\AdminController::class, 'search'])->name('customer.search');

    //Hydrographic survey
    Route::get('/customer/hydrographic_survey', [App\Http\Controllers\Customer\HydrographicsurveyController::class, 'index'])->name('customer.hydrographic_survey');
    Route::get('/customer/hydrographic_survey/create', [App\Http\Controllers\Customer\HydrographicsurveyController::class, 'create'])->name('hydrographic_survey.create');
    Route::post('/customer/hydrographic_survey/save', [App\Http\Controllers\Customer\HydrographicsurveyController::class, 'saveSurvey']);

        //Bathymetry Survey
    Route::get('/customer/bathymetry_survey', [App\Http\Controllers\Customer\BathymetrySurveyController::class, 'index'])->name('customer.bathymetry_survey');
    Route::get('/customer/bathymetry_survey/create', [App\Http\Controllers\Customer\BathymetrySurveyController::class, 'create'])->name('bathymetry_survey.create');
    Route::post('/customer/bathymetry_survey/save', [App\Http\Controllers\Customer\BathymetrySurveyController::class, 'saveSurvey']);


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
    
    Route::get('/customer/request_service_performa_invoice/{id}/{status}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'request_service_performa_invoice']);
    Route::get('/customer/request_service_invoice/{id}/{status}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'request_service_invoice']);

    Route::get('/customer/customer_invoice_download/{id}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'customer_invoice_download']);

    Route::post('/customer/customer_receipt_upload', [App\Http\Controllers\Customer\RequestedServicesController::class, 'customer_receipt_upload']);

    Route::get('/customer/invoice_received', [App\Http\Controllers\Customer\RequestedServicesController::class, 'invoice_received']);
    Route::get('/customer/performa_invoice_received', [App\Http\Controllers\Customer\RequestedServicesController::class, 'performa_invoice_received']);

    Route::post('/customer/performa_invoice_remarks', [App\Http\Controllers\Customer\RequestedServicesController::class, 'performa_invoice_remarks']);
    Route::post('/customer/performa_invoice_reject', [App\Http\Controllers\Customer\RequestedServicesController::class, 'performa_invoice_reject']);

    Route::get('/customer/receipt_rejected/{id}/{status}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'receipt_rejected']);

    Route::get('/customer/edit_survey_request/{survey_id}/{service_id}/{service_request_id}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'edit_survey_request']);

    Route::get('/customer/survey_report/{survey_id}/{status}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'survey_report']);
    Route::get('/customer/survey_file_download/{id}', [App\Http\Controllers\Customer\RequestedServicesController::class, 'survey_file_download'])->name('customer.survey_file_download');

    Route::get('/customer/help', [App\Http\Controllers\Customer\HelpController::class, 'help']);
    Route::get('/customer/help_detail/{id}', [App\Http\Controllers\Customer\HelpController::class, 'help_detail']);

    Route::post('/customer/saveHelp', [App\Http\Controllers\Customer\HelpController::class, 'saveHelp']);
    Route::post('/customer/sendReply', [App\Http\Controllers\Customer\HelpController::class, 'sendReply']);

    Route::post('/customer/getCity', [App\Http\Controllers\Customer\CityController::class, 'getCity']);

    Route::get('/customer/logout', [App\Http\Controllers\Customer\AdminController::class, 'adminLogout']);
});


//Superadmin

Route::get('/superadmin', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'superadmin']);
Route::get('/superadmin/login', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'superadmin']);
Route::post('/superadmin/sendotpemail', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/superadmin/regVerifyotpemail', [App\Http\Controllers\Superadmin\Auth\LoginController::class, 'regVerifyotpemail']);

Route::get('/all/mark-notifications', [App\Http\Controllers\AdminController::class, 'marknotifications']);

Route::middleware('role:superadmin','revalidate')->group(function () {
    Route::get('/superadmin/dashboard', [App\Http\Controllers\Superadmin\AdminController::class, 'index']);

Route::post('/superadmin/dashboard/services', [App\Http\Controllers\Superadmin\AdminController::class, 'services'])->name('dashboard.services');
Route::post('/superadmin/dashboard/search', [App\Http\Controllers\Superadmin\AdminController::class, 'search'])->name('dashboard.search');

    Route::get('/superadmin/notifications', [App\Http\Controllers\Superadmin\AdminController::class, 'notifications']);

    Route::post('/superadmin/mark-notifications', [App\Http\Controllers\Superadmin\AdminController::class, 'marknotifications']);

    Route::get('/superadmin/profile', [App\Http\Controllers\Superadmin\AdminController::class, 'profile'])->name('superadmin.profile');
    Route::post('/superadmin/edit_profile', [App\Http\Controllers\Superadmin\AdminController::class, 'edit_profile']);

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
    Route::get('/superadmin/suboffice/{id}', [App\Http\Controllers\Superadmin\OfficeController::class, 'suboffice'])->name('superadmin.suboffice');

    Route::get('/superadmin/customers', [App\Http\Controllers\Superadmin\CustomerController::class, 'index'])->name('superadmin.customers');
    Route::get('/superadmin/customers/create', [App\Http\Controllers\Superadmin\CustomerController::class, 'createCustomers']);
    Route::post('/superadmin/customers/customerSave', [App\Http\Controllers\Superadmin\CustomerController::class, 'customerSave']);
    Route::get('/superadmin/customers/view/{id}', [App\Http\Controllers\Superadmin\CustomerController::class, 'viewCustomer']);

    Route::get('/superadmin/service-master', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'service_master'])->name('superadmin.service_master');
    Route::get('/superadmin/new_service_requests', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'new_service_requests'])->name('superadmin.new_service_requests');
    Route::get('/superadmin/new_service_request_detail/{id}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'new_service_request_detail'])->name('superadmin.new_service_request_detail');
    Route::post('/superadmin/assign_survey', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_survey']);
    Route::post('/superadmin/edit_service_rate', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'edit_service_rate']);

    Route::get('/superadmin/requested_services', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'requested_services'])->name('superadmin.requested_services');
    Route::get('/superadmin/requested_service_detail/{id}/{status}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'requested_service_detail'])->name('superadmin.requested_service_detail');

    Route::get('/superadmin/verify_field_study/{id}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'verify_field_study']);
    Route::post('/superadmin/assign_draftsman', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_draftsman']);

    Route::post('/superadmin/send_performa_invoice_customer', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'send_performa_invoice_customer']);
    Route::post('/superadmin/reject_performa_invoice', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_performa_invoice']);

    Route::post('/superadmin/assign_draftsman_invoice', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_draftsman_invoice']);
    Route::post('/superadmin/reject_invoice', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_invoice']);
    Route::post('/superadmin/send_invoice_customer', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'send_invoice_customer']);

    Route::post('/superadmin/send_rejected_receipt_customer', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'send_rejected_receipt_customer']);

    Route::post('/superadmin/assign_survey_study', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_survey_study']);
    Route::post('/superadmin/assign_draftsman_final', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'assign_draftsman_final']);

    Route::post('/superadmin/reject_fieldstudy', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_fieldstudy']);
    Route::post('/superadmin/reject_surveystudy', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_surveystudy']);
    
    Route::post('/superadmin/verify_final_report', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'verify_final_report']);
    Route::post('/superadmin/reject_final_report', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_final_report']);

    Route::post('/superadmin/reject_close', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_close']);
    Route::post('/superadmin/reject_open', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'reject_open']);

    Route::get('/superadmin/help', [App\Http\Controllers\Superadmin\HelpController::class, 'help']);
    Route::get('/superadmin/help_detail/{id}', [App\Http\Controllers\Superadmin\HelpController::class, 'help_detail']);

    Route::post('/superadmin/sendReply', [App\Http\Controllers\Superadmin\HelpController::class, 'sendReply']);

    Route::post('/superadmin/getAdmin', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'getAdmin']);

    Route::get('/superadmin/logout', [App\Http\Controllers\Superadmin\AdminController::class, 'adminLogout']);
});


//Admin

Route::get('/admin', [App\Http\Controllers\Admin\Auth\LoginController::class, 'admin']);
Route::get('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'admin']);
Route::post('/admin/sendotpemail', [App\Http\Controllers\Admin\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/admin/regVerifyotpemail', [App\Http\Controllers\Admin\Auth\LoginController::class, 'regVerifyotpemail']);

Route::middleware('role:admin','revalidate')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index']);

    Route::get('/admin/notifications', [App\Http\Controllers\Admin\AdminController::class, 'notifications']);
    Route::post('/admin/mark-notifications', [App\Http\Controllers\Admin\AdminController::class, 'marknotifications']);
    Route::get('/admin/profile', [App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/edit_profile', [App\Http\Controllers\Admin\AdminController::class, 'edit_profile']);

    Route::get('/admin/logout', [App\Http\Controllers\Admin\AdminController::class, 'adminLogout']);

    Route::get('/admin/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers');
    Route::get('/admin/customers/create', [App\Http\Controllers\Admin\CustomerController::class, 'createCustomers']);
    Route::post('/admin/customers/customerSave', [App\Http\Controllers\Admin\CustomerController::class, 'customerSave']);
    Route::get('/admin/customers/view/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'viewCustomer']);

    Route::get('/admin/new_service_requests', [App\Http\Controllers\Admin\ServicerequestsController::class, 'new_service_requests'])->name('admin.new_service_requests');
    Route::get('/admin/new_service_request_detail/{id}/{status}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'new_service_request_detail'])->name('admin.new_service_request_detail');
    
    Route::post('/admin/assign_surveyor', [App\Http\Controllers\Admin\ServicerequestsController::class, 'assign_surveyor']);
    Route::post('/admin/assign_surveyor_survey', [App\Http\Controllers\Admin\ServicerequestsController::class, 'assign_surveyor_survey']);

    Route::post('/admin/reschedule_field_surveyor', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reschedule_field_surveyor']);
    Route::post('/admin/reschedule_surveyor_survey', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reschedule_surveyor_survey']);

    Route::post('/admin/reject_fieldstudy_reschedule', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_fieldstudy_reschedule']);
    Route::post('/admin/reject_surveystudy_reschedule', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_survey_reschedule']);

    Route::post('/admin/reject_fieldstudy', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_fieldstudy']);

    Route::get('/admin/requested_services', [App\Http\Controllers\Admin\ServicerequestsController::class, 'requested_services'])->name('admin.requested_services');
    Route::get('/admin/repository-management', [App\Http\Controllers\Admin\ServicerequestsController::class, 'services_repository'])->name('admin.services_repository');

        Route::get('/admin/repository-management/create', [App\Http\Controllers\Admin\ServicerequestsController::class, 'createRepository']);
        Route::post('/admin/repository-management/save', [App\Http\Controllers\Admin\ServicerequestsController::class, 'saveRepository']);

    // Route::get('/admin/repository-management/edit/{role}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'editAdmin']);
    // Route::get('/admin/repository-management/view/{admin}', [App\Http\Controllers\Superadmin\ServicerequestsController::class, 'viewAdmin']);

    Route::get('/admin/repository-management-detail/{id}/{status}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'services_repository_detail'])->name('admin.services_repository_detail');

    Route::get('/admin/repository-management-download/{file}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'repository_file_download'])->name('admin.repository_file_download');

    Route::get('/admin/requested_service_detail/{id}/{status}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'requested_service_detail'])->name('admin.requested_service_detail');

    Route::get('/admin/createETA/{id}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'createETA']);
    Route::post('/admin/add_eta', [App\Http\Controllers\Admin\ServicerequestsController::class, 'add_eta']);

    Route::get('/admin/editETA/{id}', [App\Http\Controllers\Admin\ServicerequestsController::class, 'editETA']);
    Route::post('/admin/update_eta', [App\Http\Controllers\Admin\ServicerequestsController::class, 'update_eta']);

    Route::post('/admin/verify_performa_invoice', [App\Http\Controllers\Admin\ServicerequestsController::class, 'verify_performa_invoice']);
    Route::post('/admin/reject_performa_invoice', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_performa_invoice']);

    Route::post('/admin/verify_invoice', [App\Http\Controllers\Admin\ServicerequestsController::class, 'verify_invoice']);
    Route::post('/admin/reject_invoice', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_invoice']);
    
    Route::post('/admin/verify_survey_study', [App\Http\Controllers\Admin\ServicerequestsController::class, 'verify_survey_study']);
    Route::post('/admin/reject_surveystudy', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_surveystudy']);

    Route::post('/admin/verify_final_report', [App\Http\Controllers\Admin\ServicerequestsController::class, 'verify_final_report']);
    Route::post('/admin/reject_final_report', [App\Http\Controllers\Admin\ServicerequestsController::class, 'reject_final_report']);

    Route::get('/admin/help', [App\Http\Controllers\Admin\HelpController::class, 'help']);
    Route::get('/admin/help_detail/{id}', [App\Http\Controllers\Admin\HelpController::class, 'help_detail']);
    Route::post('/admin/sendReply', [App\Http\Controllers\Admin\HelpController::class, 'sendReply']);
    
});

//Draftsman

Route::get('/draftsman', [App\Http\Controllers\Draftsman\Auth\LoginController::class, 'admin']);
Route::get('/draftsman/login', [App\Http\Controllers\Draftsman\Auth\LoginController::class, 'admin']);
Route::post('/draftsman/sendotpemail', [App\Http\Controllers\Draftsman\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/draftsman/regVerifyotpemail', [App\Http\Controllers\Draftsman\Auth\LoginController::class, 'regVerifyotpemail']);

Route::middleware('role:draftsman','revalidate')->group(function () {
    Route::get('/draftsman/dashboard', [App\Http\Controllers\Draftsman\AdminController::class, 'index']);

    Route::get('/draftsman/notifications', [App\Http\Controllers\Draftsman\AdminController::class, 'notifications']);
    Route::post('/draftsman/mark-notifications', [App\Http\Controllers\Draftsman\AdminController::class, 'marknotifications']);
    Route::get('/draftsman/profile', [App\Http\Controllers\Draftsman\AdminController::class, 'profile'])->name('draftsman.profile');
    Route::post('/draftsman/edit_profile', [App\Http\Controllers\Draftsman\AdminController::class, 'edit_profile']);

    Route::get('/draftsman/logout', [App\Http\Controllers\Draftsman\AdminController::class, 'adminLogout']);    

    Route::get('/draftsman/service_requests', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'requested_services'])->name('draftsman.requested_services');
    Route::get('/draftsman/service_requests_detail/{id}/{status}', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'requested_service_detail'])->name('draftsman.requested_service_detail');

    Route::get('/draftsman/create_performa_invoice/{id}', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'create_performa_invoice']);
    Route::post('/draftsman/save_performa_invoice', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'save_performa_invoice']);

    Route::get('/draftsman/create_invoice/{id}', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'create_invoice']);
    Route::post('/draftsman/save_invoice', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'save_invoice']);

    Route::get('/draftsman/edit_performa_invoice/{id}', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'edit_performa_invoice']);
    Route::get('/draftsman/edit_invoice/{id}', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'edit_invoice']);

    Route::get('/draftsman/download_report/{id}', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'download_report']);
    
    Route::post('/draftsman/upload_final_report', [App\Http\Controllers\Draftsman\ServicerequestsController::class, 'upload_final_report']);

});

//Accountant

Route::get('/accountant', [App\Http\Controllers\Accountant\Auth\LoginController::class, 'admin']);
Route::get('/accountant/login', [App\Http\Controllers\Accountant\Auth\LoginController::class, 'admin']);
Route::post('/accountant/sendotpemail', [App\Http\Controllers\Accountant\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/accountant/regVerifyotpemail', [App\Http\Controllers\Accountant\Auth\LoginController::class, 'regVerifyotpemail']);

Route::middleware('role:accountant','revalidate')->group(function () {
    Route::get('/accountant/dashboard', [App\Http\Controllers\Accountant\AdminController::class, 'index']);
    Route::post('/accountant/remove-avatar', [App\Http\Controllers\Accountant\AdminController::class, 'removeAvatar']);
    Route::get('/accountant/notifications', [App\Http\Controllers\Accountant\AdminController::class, 'notifications']);
    Route::post('/accountant/mark-notifications', [App\Http\Controllers\Accountant\AdminController::class, 'marknotifications']);
    Route::get('/accountant/profile', [App\Http\Controllers\Accountant\AdminController::class, 'profile'])->name('accountant.profile');
    Route::post('/accountant/edit_profile', [App\Http\Controllers\Accountant\AdminController::class, 'edit_profile']);

    Route::get('/accountant/logout', [App\Http\Controllers\Accountant\AdminController::class, 'adminLogout']);    

    Route::get('/accountant/service_requests', [App\Http\Controllers\Accountant\ServicerequestsController::class, 'requested_services'])->name('accountant.requested_services');

    Route::get('/accountant/receipt_received/{id}', [App\Http\Controllers\Accountant\ServicerequestsController::class, 'receipt_received'])->name('accountant.receipt_received');

    Route::post('/accountant/verify_customer_receipt', [App\Http\Controllers\Accountant\ServicerequestsController::class, 'verify_customer_receipt'])->name('accountant.verify_customer_receipt');
    Route::post('/accountant/reject_customer_receipt', [App\Http\Controllers\Accountant\ServicerequestsController::class, 'reject_customer_receipt'])->name('accountant.reject_customer_receipt');
});

//Surveyor

Route::get('/surveyor', [App\Http\Controllers\Surveyor\Auth\LoginController::class, 'admin']);
Route::get('/surveyor/login', [App\Http\Controllers\Surveyor\Auth\LoginController::class, 'admin']);
Route::post('/surveyor/sendotpemail', [App\Http\Controllers\Surveyor\Auth\LoginController::class, 'loginSendotpemail']);
Route::post('/surveyor/regVerifyotpemail', [App\Http\Controllers\Surveyor\Auth\LoginController::class, 'regVerifyotpemail']);

Route::middleware('role:surveyor','revalidate')->group(function () {
    Route::get('/surveyor/dashboard', [App\Http\Controllers\Surveyor\AdminController::class, 'index']);
    
    Route::get('/surveyor/notifications', [App\Http\Controllers\Surveyor\AdminController::class, 'notifications']);
    Route::post('/surveyor/mark-notifications', [App\Http\Controllers\Surveyor\AdminController::class, 'marknotifications']);
    Route::get('/surveyor/profile', [App\Http\Controllers\Surveyor\AdminController::class, 'profile'])->name('surveyor.profile');
    Route::post('/surveyor/edit_profile', [App\Http\Controllers\Surveyor\AdminController::class, 'edit_profile']);

    Route::get('/surveyor/logout', [App\Http\Controllers\Surveyor\AdminController::class, 'adminLogout']);    

    Route::get('/surveyor/service_requests', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'requested_services'])->name('surveyor.requested_services');
    Route::get('/surveyor/requested_service_detail/{id}/{status}', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'requested_service_detail']);

    Route::post('/surveyor/upload_fieldstudy', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'upload_fieldstudy'])->name('fieldstudy.upload');
    Route::post('/surveyor/upload_surveystudy', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'upload_surveystudy'])->name('surveystudy.upload');

    Route::post('/surveyor/storeMedia', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'storeMedia'])->name('survey.storeMedia');

    // Route::get('/surveyor/dropzone', [App\Http\Controllers\ServicerequestsController::class, 'index']);

    Route::post('/surveyor/dropzone/upload', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'upload'])->name('dropzone.upload');

    Route::get('/surveyor/dropzone/fetch', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'fetch'])->name('dropzone.fetch');

    Route::get('/surveyor/dropzone/delete', [App\Http\Controllers\Surveyor\ServicerequestsController::class, 'delete'])->name('dropzone.delete');
});

// Route::get('dropzone', [App\Http\Controllers\DropzoneController::class, 'index']);

// Route::post('dropzone/upload', [App\Http\Controllers\DropzoneController::class, 'upload'])->name('dropzone.upload');

// Route::get('dropzone/fetch', [App\Http\Controllers\DropzoneController::class, 'fetch'])->name('dropzone.fetch');

// Route::get('dropzone/delete', [App\Http\Controllers\DropzoneController::class, 'delete'])->name('dropzone.delete');

//Default Pages

// Route::get('/{page}', [App\Http\Controllers\AdminController::class, 'index']);
// Route::get('/superadmin/{page}', [App\Http\Controllers\AdminController::class, 'superadmin']);
// Route::get('/admin/{page}', [App\Http\Controllers\AdminController::class, 'admin']);
// Route::get('/surveyor/{page}', [App\Http\Controllers\AdminController::class, 'surveyor']);
// Route::get('/accountant/{page}', [App\Http\Controllers\AdminController::class, 'accountant']);
// Route::get('/draftsman/{page}', [App\Http\Controllers\AdminController::class, 'draftsman']);