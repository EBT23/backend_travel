<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/role', [Admin::class, 'role']);
    Route::post('/tambah_role', [Admin::class, 'tambah_role']);
    Route::put('/update_role/{id}', [Admin::class, 'update_role']);
    Route::delete('/delete_role/{id}', [Admin::class, 'delete_role']);
});
