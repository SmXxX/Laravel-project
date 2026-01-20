<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\GetCarInfoAndRepairsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\RepairController as AdminRepairController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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

// Redirect root to appropriate dashboard based on role
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Clients Management
    Route::get('/clients', [AdminClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [AdminClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [AdminClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{id}', [AdminClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/{id}/edit', [AdminClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{id}', [AdminClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [AdminClientController::class, 'destroy'])->name('clients.destroy');

    // Cars Management
    Route::get('/cars', [AdminCarController::class, 'index'])->name('cars.index');
    Route::get('/cars/create', [AdminCarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [AdminCarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{id}', [AdminCarController::class, 'show'])->name('cars.show');
    Route::get('/cars/{id}/edit', [AdminCarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{id}', [AdminCarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{id}', [AdminCarController::class, 'destroy'])->name('cars.destroy');

    // Repairs Management
    Route::get('/repairs', [AdminRepairController::class, 'index'])->name('repairs.index');
    Route::get('/repairs/create', [AdminRepairController::class, 'create'])->name('repairs.create');
    Route::post('/repairs', [AdminRepairController::class, 'store'])->name('repairs.store');
    Route::get('/repairs/{id}/edit', [AdminRepairController::class, 'edit'])->name('repairs.edit');
    Route::put('/repairs/{id}', [AdminRepairController::class, 'update'])->name('repairs.update');
    Route::delete('/repairs/{id}', [AdminRepairController::class, 'destroy'])->name('repairs.destroy');

    // Admin Users Management (Super Admin only)
    Route::middleware(['super-admin'])->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

    // AJAX endpoint for getting cars by client
    Route::get('/api/clients/{clientId}/cars', [AdminRepairController::class, 'getCarsByClient'])->name('api.clients.cars');

    // AJAX endpoint for car info and repairs
    Route::post('/get-car-info-and-repairs', [GetCarInfoAndRepairsController::class, 'CarInfoAndRepairs']);
});

/*
|--------------------------------------------------------------------------
| Client Portal Routes
|--------------------------------------------------------------------------
*/
Route::prefix('client')->middleware(['auth'])->name('client.')->group(function () {

    // Client Dashboard - view own cars and repairs
    Route::get('/dashboard', [ClientPortalController::class, 'dashboard'])->name('dashboard');

    // Repair History
    Route::get('/repairs', [ClientPortalController::class, 'repairHistory'])->name('repairs');

    // AJAX endpoint for car info
    Route::post('/get-car-info-and-repairs', [ClientPortalController::class, 'getCarInfoAndRepairs'])->name('car.info');
});

/*
|--------------------------------------------------------------------------
| Legacy Routes (keeping for backwards compatibility during transition)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('serviceAdmin')->group(function () {
        return Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    });
});

Auth::routes();
