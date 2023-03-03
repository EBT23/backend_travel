<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/role', [Admin::class, 'role'])->middleware(['auth:sanctum']);

Route::post('/login', [AuthController::class, 'login']);
