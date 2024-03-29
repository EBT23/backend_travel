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

//cek persediaan tiket
Route::post('/cek_persediaan_tiket', [Admin::class, 'cek_persediaan']);

//PEMESANAN
Route::get('/pemesanan', [Admin::class, 'pemesanan']);
Route::post('/tambah_pemesanan', [Admin::class, 'tambah_pemesanan']);
Route::delete('/delete_pemesanan', [Admin::class, 'delete_pemesanan']);

Route::post('/riwayat_tiket', [Admin::class, 'riwayat_tiket']);

Route::post('/cek_transaksi', [Admin::class, 'cek_transaksi']);
Route::post('/cetak_tiket', [Admin::class, 'cetak_tiket']);

Route::post('/updateTransaksi', [Admin::class, 'updateTransaksi']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    //PROFILE
    Route::post('/profile', [Admin::class, 'profile']);

    //ROLE
    Route::get('/role', [Admin::class, 'role']);
    Route::post('/tambah_role', [Admin::class, 'tambah_role']);
    Route::put('/update_role/{id}', [Admin::class, 'update_role']);
    Route::delete('/delete_role/{id}', [Admin::class, 'delete_role']);
    Route::get('/get_role/{id}', [Admin::class, 'get_role']);
    //SHUTTLE
    Route::get('/shuttle', [Admin::class, 'shuttle']);
    Route::post('/tambah_shuttle', [Admin::class, 'tambah_shuttle']);
    Route::put('/update_shuttle/{id}', [Admin::class, 'update_shuttle']);
    Route::delete('/delete_shuttle/{id}', [Admin::class, 'delete_shuttle']);
    Route::get('/get_shuttle/{id}', [Admin::class, 'get_shuttle']);
    //PERSEDIAAN TIKET
    Route::get('/persediaan_tiket', [Admin::class, 'persediaan_tiket']);
    Route::post('/tambah_persediaan_tiket', [Admin::class, 'tambah_persediaan_tiket']);
    Route::put('/update_persediaan_tiket/{id}', [Admin::class, 'update_persediaan_tiket']);
    Route::delete('/delete_persediaan_tiket/{id}', [Admin::class, 'delete_persediaan_tiket']);
    Route::get('/get_persediaan/{id}', [Admin::class, 'get_persediaan']);

    //SUPIR
    Route::get('/supir', [Admin::class, 'supir']);
    Route::post('/tambah_supir', [Admin::class, 'tambah_supir']);
    Route::put('/update_supir/{id}', [Admin::class, 'update_supir']);
    Route::delete('/delete_supir/{id}', [Admin::class, 'delete_supir']);

    // KOTA
    Route::post('/tambah_kota', [Admin::class, 'tambah_kota']);
    Route::put('/update_kota/{id}', [Admin::class, 'update_kota']);
    Route::delete('/delete_kota/{id}', [Admin::class, 'delete_kota']);
    Route::get('/get_kota/{id}', [Admin::class, 'get_kota']);

    // TEMPAT AGEN
    Route::post('/tambah_tempat_agen', [Admin::class, 'tambah_tempat_agen']);
    Route::put('/update_tempat_agen/{id}', [Admin::class, 'update_tempat_agen']);
    Route::delete('/delete_tempat_agen/{id}', [Admin::class, 'delete_tempat_agen']);
    Route::get('/get_tempat_agen/{id}', [Admin::class, 'get_tempat_agen']);
});
