<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

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

Route::middleware(['pagesetup'])->group(function () {

    Route::get('/', [StudentController::class, "index"])->name('home');
    Route::post('/signup', [StudentController::class, "store"]);
    Route::post('/signin', [pageController::class, "studentLogin"]);

    Route::get('/admin/login', function () {
        return view('admin/login');
    })->name('login');
    Route::post('/admin/login', [pageController::class, "adminLogin"]);
    Route::middleware(['studentauth'])->group(function () {

        /**
         * STUDENT DASHBOARD ROUTE
         *
         * This is where the route for payment, document upload
         * and clearance signing are defined. This includes the get and post request
         */
        Route::get("/dashboard", [StudentController::class, "dashboardProgress"]);

        //Document route
        Route::middleware(['docauth'])->group(function () {
            Route::get("/documents", [DocumentController::class, "index"]);
            Route::post("/documents/upload", [DocumentController::class, "store"]);
            Route::post("/documents/delete/{id}", [DocumentController::class, "destroy"]);
            Route::get("/documents/edit/{id}", [DocumentController::class, "edit"]);
            Route::post("/documents/edit", [DocumentController::class, "update"]);
        });

        //Payment Route
        Route::get("/payments", [PaymentController::class, "index"]);
        Route::post("/payment/confirm", [PaymentController::class, "confirmMsg"]);
        Route::post("/payment", [PaymentController::class, "verifyPayment"]);

        Route::get("/payments/details/{id}", [PaymentController::class, "paymentDetails"]);

        Route::get("/notifications/{id?}", [StudentController::class, "Notification"]);
        Route::get("/logout", [StudentController::class, "studentLogout"]);
    });
    /**
     *
     * ADMIN CPANEL ROUTES
     *
     */
    Route::middleware(['adminauth'])->group(function () {
        Route::post('/admin/session', [pageController::class, 'createSession']);
        Route::get('/admin/dashboard', [StudentController::class, "adminDashboard"]);

        Route::get('/admin/students/{level}', [StudentController::class, "show"]);
        Route::get('/admin/student/{stdid}', [StudentController::class, "studentRecord"]);

        Route::post('/admin/documents/verify/{id}', [DocumentController::class, 'verifyDocument']);
        Route::post('/admin/documents/decline/{id}', [DocumentController::class, 'declineDocument']);

        Route::get('/admin/setting', [SettingsController::class, 'showSet']);
        Route::get('/admin/settings/{level?}', [SettingsController::class, 'create'])->name('settings');
        Route::post('/admin/settings/add', [SettingsController::class, 'store']);

        Route::post('/admin/changepassword', [AdminController::class, 'changePassword']);
        Route::get('/admin/logout', [AdminController::class, 'adminLogout']);

        Route::get('/admin/transactions/{}', [PaymentController::class, 'showTransaction']);

        Route::post('/admin/notification', [StudentController::class, 'sendNotification']);
    });
});
