<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Role;
use App\Models\TempatAgen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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

    // Supir
    public function supir()
    {
        $supir = DB::table('roles')
            ->join('users', 'roles.id', '=', 'users.role_id')
            ->select('users.*', 'roles.roles')
            ->where('roles.id', '=', '3')
            ->get();

        return response()->json($supir);
    }

    public function tambah_supir(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'password.min' => 'password minimal 6',
            'email.unique' => 'email sudah digunakan',
        ]);

        $users = DB::table('users')->insert([
            'nama' => $request->nama,
            'no_hp' => $request->password,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 3,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'supir berhasil ditambahkan',
            'data' => $users
        ], Response::HTTP_OK);
    }

    public function update_supir(Request $request, $id)

    {
        $data = $request->only(
            'nama',
            'no_hp',
            'email',
            'password',
            'role_id',
        );


        $supir = DB::table('users')
            ->where('id', $id)
            ->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
            ]);
        return response()->json([
            'success' => true,
            'message' => 'supir berhasil ditambahkan',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    public function delete_supir($id)
    {
        $supir = User::findOrFail($id);
        $supir->delete();
        return response()->json(null, 204);
    }

    // KOTA
    public function kota()
    {
        $kota = Kota::all();
        return response()->json([
            'data' => $kota
        ]);
    }

    public function tambah_kota(Request $request)
    {
        $validated = $request->validate([
            'nama_kota' => 'required',
        ]);

        // simpan data ke database
        $data = new Kota;
        $data->nama_kota = $validated['nama_kota'];
        $data->save();

        // kirim response
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambah'
        ]);
    }

    public function update_kota(Request $request, $id)
    {
        $kota = Kota::findOrFail($id);
        $kota->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'kota berhasil diupdate',
            'data' => $kota, 200
        ]);
    }

    public function delete_kota($id)
    {
        $kota = Kota::findOrFail($id);
        $kota->delete();
        return response()->json(null, 204);
    }

    // TEMPAT AGEN

    public function tempat_agen()
    {
        $tmagen = TempatAgen::all();
        return response()->json([
            'data' => $tmagen
        ]);
    }

    public function tambah_tempat_agen(Request $request)
    {
        $validated = $request->validate([
            'kota_id' => 'required',
            'tempat_agen' => 'required',
        ]);

        // simpan data ke database
        $data = new TempatAgen();
        $data->kota_id = $validated['kota_id'];
        $data->tempat_agen = $validated['tempat_agen'];
        $data->save();

        // kirim response
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambah'
        ]);
    }

    public function update_tempat_agen(Request $request, $id)
    {
        $tmagen = TempatAgen::findOrFail($id);
        $tmagen->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'kota berhasil diupdate',
            'data' => $tmagen, 200
        ]);
    }

    public function delete_tempat_agen($id)
    {
        $tmagen = TempatAgen::findOrFail($id);
        $tmagen->delete();
        return response()->json(null, 204);
    }
}
