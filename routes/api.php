<?php

use App\Http\Controllers\auth_controller;
use App\Http\Controllers\cv_controller;
use App\Http\Controllers\freeLancerController;
use App\Http\Controllers\jobsController;
use App\Http\Controllers\lecturersController;
use App\Http\Controllers\servicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmailController;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\sicialController;

use App\Http\Controllers\PaymentController;

Route::post('/cancel-subscription', [PaymentController::class, 'cancelSubscription']);


//authuntucation
Route::post('/register', [auth_controller::class, 'register']);
Route::post('/verify-email', [auth_controller::class, 'verifyEmail'])->name('verification.verify');
Route::post('forgot-password', [auth_controller::class, 'sendResetCode']);
Route::post('reset-password-code', [auth_controller::class, 'reset']);
Route::post('reset-password', [auth_controller::class, 'resetPassword'])->name('password.reset');
Route::post('/resend-verification-email', [auth_controller::class, 'resendVerificationEmail']);
Route::post('/login', [auth_controller::class, 'login']);
//login with facebook and google
Route::get('auth', [sicialController::class, 'redirectToAuth']);
Route::get('facebook_auth', [sicialController::class, 'redirectToFacebook']);
//get information user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
});

//admin panel
// Route for testing environment variables
Route::get('/test-env', function () {
    return [
        'vendor_id' => env('PADDLE_VENDOR_ID'),
        'api_key' => env('PADDLE_API_KEY'),
        'client_side_token' => env('PADDLE_CLIENT_SIDE_TOKEN'),
    ];
});

//user
Route::get('/users/get', [auth_controller::class, 'get_users']);
Route::post('/users/update/{id}', [auth_controller::class, 'update_users']);
Route::post('/users/delete/{id}', [auth_controller::class, 'delete_users']);
Route::middleware('auth:sanctum')->post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession']);





// route need token or login

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/buy', [PaymentController::class, 'buy'])->name('buy');

    Route::post('/payment/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payment.callback');

    //bo zanene away ka am usera active a yan na wata  am user paymente krdwa yan na
    Route::post('/user/subscription-status', [PaymentController::class, 'checkSubscriptionStatus']);


    // ama bas bo free plan a ta  fib payment e nawe  har asay 3 mange bo bkretawa
    Route::post('/payment/freePlan', [PaymentController::class, 'freePlan']);


    Route::post('/payment/create', [PaymentController::class, 'createPayment']);
    Route::get('/payment/status/{paymentId}', [PaymentController::class, 'checkPaymentStatus']);

//bo garandaaway paraka agar user westy
    Route::post('/payment/refund/{paymentId}', [PaymentController::class, 'refundPayment']);


    Route::post('/logout', [auth_controller::class, 'logout']);
    //freelancer route
    Route::post('/freelancer/insert', [freeLancerController::class, 'freelancer_insert']);
    Route::post('/freelancers/{id}/review', [FreeLancerController::class, 'addReview']);
    Route::get('/freelancers/{id}/average-review', [FreeLancerController::class, 'getAverageReview']);
    Route::get('/freelancer/update/details', [freeLancerController::class, 'freelancer_updateDetails']);
    Route::post('/freelancer/update', [freeLancerController::class, 'freelancer_update']);
    Route::get('/freelancer/details/{id}', [freeLancerController::class, 'freelancer_details']);

    //addmin panel 
    Route::post('/freelancer/update/admin/{id}', [freeLancerController::class, 'freelancer_admin_update']);
    Route::post('/freelancer/delete/{id}', [freeLancerController::class, 'freelancer_delete']);
    //jobs route
    Route::post('/job/insert', [jobsController::class, 'job_insert']);
    Route::get('/job/details/{id}', [jobsController::class, 'job_details']);
    //addmin panel
    Route::post('/job/update/{id}', [jobsController::class, 'job_update']);
    Route::post('/job/delete/{id}', [jobsController::class, 'job_delete']);
    //sevices route
    Route::post('/services/insert', [servicesController::class, 'services_insert']);
    Route::post('/services/update', [servicesController::class, 'services_update']);
    Route::get('/services/update/details/', [servicesController::class, 'services_updateDetails']);
    Route::get('/services/details/{id}', [servicesController::class, 'services_details']);
    Route::get('/services/get/{id}', [servicesController::class, 'services_details']);

    //addmin panel
    Route::post('/services/update/admin/{id}', [servicesController::class, 'services_admin_update']);
    Route::post('/services/delete/{id}', [servicesController::class, 'services_delete']);
    // lecturers
    Route::post('/lecturers/insert', [lecturersController::class, 'lecturers_insert']);
    Route::post('/lecturers/update', [lecturersController::class, 'lecturers_update']);
    // admin panel
    Route::post('/lecturers/admin/update/{id}', [lecturersController::class, 'lecturers_admin_update']);
    Route::post('/lecturers/delete/{id}', [lecturersController::class, 'lecturers_delete']);
    Route::get('/lecturers/details/{id}', [lecturersController::class, 'lecturers_details']);
    Route::get('/lecturers/update/details', [lecturersController::class, 'lecturers_updateDetails']);

    //notification_controller
    Route::post('/send-email', [SendEmailController::class, 'sendJobAlertToAllUsers']);

    Route::get('user/reviews/freelancer/{freelancerId}', [FreeLancerController::class, 'getUserReviews']);
});





//services get
Route::get('/services/get', [servicesController::class, 'services_getAll']);

//lecturers get
Route::get('/lecturers/primary/get', [lecturersController::class, 'primary_get']);
Route::get('/lecturers/middle/get', [lecturersController::class, 'Middle_get']);
Route::get('/lecturers/high/get', [lecturersController::class, 'High_get']);
Route::get('/lecturers/get', [lecturersController::class, 'lecturers_get']);


// get all data without pagination and search  for filter search
Route::get('/lecturers/High_searchData', [lecturersController::class, 'High_searchData']);
Route::get('/lecturers/Middle_searchData', [lecturersController::class, 'Middle_searchData']);
Route::get('/lecturers/Primary_searchData', [lecturersController::class, 'Primary_searchData']);






Route::get('/services/search_get', [servicesController::class, 'get_search_services']);

//freelancer get
Route::get('/freelancer/getAll', [freeLancerController::class, 'freelancer_getAll']);
// get all data without pagination and search  for filter search
Route::get('/freelancer/getSearch', [freeLancerController::class, 'getSearch']);

//jobs/get
Route::get('/job/getAll', [jobsController::class, 'jobs_getAll']);
// get all data without pagination and search  for filter search
Route::get('/job/searchData', [jobsController::class, 'searchData']);
Route::get('/job/countSearchData', [jobsController::class, 'searchData']);


Route::get('/services/Cleaning', [servicesController::class, 'Cleaning']);


// servicves type get
Route::get('/services/cleaning', [servicesController::class, 'getCleaningServices']);
Route::get('/services/vehicle-maintenance', [servicesController::class, 'getVehicleMaintenanceServices']);
Route::get('/services/electrical-repairs', [servicesController::class, 'getElectricalRepairsServices']);
Route::get('/services/freight-forwarding', [servicesController::class, 'getFreightForwardingServices']);
Route::get('/services/home-appliance-repairs', [servicesController::class, 'getHomeApplianceRepairsServices']);
Route::get('/services/construction-of-houses', [servicesController::class, 'getConstructionOfHousesServices']);
Route::get('/services/garden-maintenance', [servicesController::class, 'getGardenMaintenanceServices']);
Route::get('/services/car-wash', [servicesController::class, 'getCarWashServices']);
Route::get('/services/carpet', [servicesController::class, 'getCarpetServices']);
Route::get('/services/post', [servicesController::class, 'getPostServices']);
Route::get('/services/hairdressing', [servicesController::class, 'getHairdressingServices']);
Route::get('/services/skincare-treatments', [servicesController::class, 'getSkincareTreatmentsServices']);
Route::get('/services/makeup', [servicesController::class, 'getMakeupServices']);
Route::get('/services/nail', [servicesController::class, 'getNailServices']);
Route::get('/services/veterinary', [servicesController::class, 'getVeterinaryServices']);
Route::get('/services/mortgage', [servicesController::class, 'getMortgageServices']);
Route::get('/services/legal-consultation', [servicesController::class, 'getLegalConsultationServices']);
Route::get('/services/photography', [servicesController::class, 'getPhotographyServices']);
Route::get('/services/tire-replacement', [servicesController::class, 'getTireReplacementServices']);
Route::get('/services/battery', [servicesController::class, 'getBatteryServices']);
Route::get('/services/Electronic', [servicesController::class, 'ElectronicServices']);
Route::get('/services/Travel-Tourism', [servicesController::class, 'Travel_Tourism']); //gashtu guzar
