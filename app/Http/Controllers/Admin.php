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
    public function tambah_role(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'roles' => 'required',
        ]);

        // simpan data ke database
        $data = new Role;
        $data->roles = $validated['roles'];
        $data->save();

        // kirim response
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ]);
    }
    public function update_role(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return response()->json($role, 200);
    }
    public function delete_role($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
