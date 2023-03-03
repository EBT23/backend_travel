<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class Admin extends Controller
{
    public function role()
    {
        $role = Role::all();
        return response()->json([
            'data' => $role
        ]);
    }
}
