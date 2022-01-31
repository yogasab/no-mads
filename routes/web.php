<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Home\HomeController;
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

// Route::get('/', function () {
//     return view('layouts.admin');
// });

Route::get('', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});
