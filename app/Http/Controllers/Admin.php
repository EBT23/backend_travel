<?php

namespace App\Http\Controllers;

use App\Models\Persediaan_tiket;
use App\Models\Role;
use App\Models\Shuttle;
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
    public function shuttle()
    {
        $shuttle = DB::table('shuttle')
            ->join('jenis_mobil', 'shuttle.id_jenis_mobil', '=', 'jenis_mobil.id')
            ->join('fasilitas', 'shuttle.id_fasilitas', '=', 'fasilitas.id')
            ->select('shuttle.id', 'jenis_mobil.jenis_mobil', 'fasilitas.nama_fasilitas')
            ->get();

        return response()->json($shuttle);
    }
    public function tambah_shuttle(Request $request)
    {
        $validated = $request->validate([
            'id_jenis_mobil' => 'required',
            'id_fasilitas' => 'required',
        ]);

        $cek = DB::table('shuttle')
            ->where('id_jenis_mobil', '=', $request->id_jenis_mobil)
            ->where('id_fasilitas', '=', $request->id_fasilitas)
            ->count();

        if ($cek > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan karena sudah ada',
            ]);
        }

        $shuttle = DB::table('shuttle')->insert([
            'id_jenis_mobil' => $request->id_jenis_mobil,
            'id_fasilitas' => $request->id_fasilitas
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shuttle berhasil dibuat',
            'data' => $shuttle
        ], Response::HTTP_OK);
    }

    public function update_shuttle(Request $request, $id)
    {
        $shuttle = Shuttle::findOrFail($id);
        $shuttle->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Shuttle berhasil dirubah',
            'data' => $shuttle
        ]);
    }
    public function delete_shuttle($id)
    {
        $shuttle = Shuttle::findOrFail($id);
        $shuttle->delete();
        return response()->json([
            'success' => true,
            'message' => 'Shuttle berhasil dihapus',
            'data' => $shuttle
        ]);
    }
    public function persediaan_tiket()
    {
        $persediaan_tiket = Persediaan_tiket::all();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditampilkan',
            'data' => $persediaan_tiket
        ]);
    }
    public function tambah_persediaan_tiket(Request $request)
    {
        $validated = $request->validate([
            'tgl_keberangkatan' => 'required',
            'asal' => 'required',
            'tujuan' => 'required',
            'kuota' => 'required',
        ]);

        $persediaan_tiket = DB::table('persediaan_tiket')->insert([
            'tgl_keberangkatan' => $request->tgl_keberangkatan,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'kuota' => $request->kuota,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Persediaan tiket berhasil dibuat',
            'data' => $persediaan_tiket
        ], Response::HTTP_OK);
    }
}
