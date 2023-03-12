<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// KOTA
Route::get('/kota', [Admin::class, 'kota']);

// TEMPAT AGEN
Route::get('/tempat_agen', [Admin::class, 'tempat_agen']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    //ROLE
    Route::get('/role', [Admin::class, 'role']);
    Route::post('/tambah_role', [Admin::class, 'tambah_role']);
    Route::put('/update_role/{id}', [Admin::class, 'update_role']);
    Route::delete('/delete_role/{id}', [Admin::class, 'delete_role']);
    Route::get('/shuttle', [Admin::class, 'shuttle']);
    Route::post('/tambah_shuttle', [Admin::class, 'tambah_shuttle']);
    Route::put('/update_shuttle/{id}', [Admin::class, 'update_shuttle']);
    Route::delete('/delete_shuttle/{id}', [Admin::class, 'delete_shuttle']);
    Route::get('/persediaan_tiket', [Admin::class, 'persediaan_tiket']);
    Route::post('/tambah_persediaan_tiket', [Admin::class, 'tambah_persediaan_tiket']);
});
