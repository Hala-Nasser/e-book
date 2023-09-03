<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Mail\AdminWelcomeMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('dashboard/')->middleware('guest:admin')->group( function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('dashboard.login');
    Route::post('login', [LoginController::class, 'login']);

});

Route::prefix('dashboard/')->middleware('auth:admin')->group( function(){
    Route::get('verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('verification-notification', [EmailVerificationController::class, 'send'])->name('verification.send');
    Route::get('verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});

Route::middleware(['auth:admin', 'verified'])->prefix('dashboard/')->group( function () {
    Route::get('home',[Controller::class, 'index'])->name('home');
    Route::resource('category', CategoryController::class);
    Route::resource('book', BookController::class);
    Route::resource('admin', AdminController::class);
    Route::get('logout',[LogoutController::class, 'logout'])->name('admin.logout');
    Route::get('change-password',[ChangePasswordController::class, 'showChangePassword'])->name('admin.change-password');
    Route::post('change-password',[ChangePasswordController::class, 'changePassword']);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);

    Route::get('role/{role}/permissions', [RoleController::class, 'editRolePermissions'])->name('role.edit-permissions');
    Route::put('role/{role}/permissions', [RoleController::class, 'updateRolePermissions']);

});