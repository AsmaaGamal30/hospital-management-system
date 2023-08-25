<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard_admin', [DashboardController::class, 'index']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        //user dashboard
        Route::get('/Dashboard/user', function () {
            return view('Dashboard.User.Dashboard');
        })->middleware(['auth', 'verified'])->name('Dashboard.user');

        //admin dashboard
        Route::get('/Dashboard/admin', function () {
            return view('Dashboard.Admin.Dashboard');
        })->middleware(['auth:admin', 'verified'])->name('Dashboard.admin');

        Route::middleware('auth:admin')->group(function () {
            //sections route
            Route::resource('sections', SectionController::class);
            //doctor route
            Route::resource('doctors', DoctorController::class);
        });







        require __DIR__ . '/auth.php';
    }
);