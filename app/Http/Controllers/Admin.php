<?php

namespace App\Http\Controllers;

use App\Models\Persediaan_tiket;
use App\Models\Role;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Kota;
use App\Models\Pemesanan;
use App\Models\TempatAgen;
use App\Models\User;


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

        return response()->json([
            'success' => true,
            'data' => $shuttle
        ]);
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
            'estimasi_perjalanan' => 'required',
            'harga' => 'required',
        ]);

        $persediaan_tiket = DB::table('persediaan_tiket')->insert([
            'tgl_keberangkatan' => $request->tgl_keberangkatan,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'kuota' => $request->kuota,
            'estimasi_perjalanan' => $request->estimasi_perjalanan,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Persediaan tiket berhasil dibuat',
            'data' => $persediaan_tiket
        ], Response::HTTP_OK);
    }
    public function update_persediaan_tiket(Request $request, $id)
    {
        $persediaan_tiket = Persediaan_tiket::findOrFail($id);
        $persediaan_tiket->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Persediaan tiket berhasil dirubah',
            'data' => $persediaan_tiket
        ]);
    }
    public function delete_persediaan_tiket($id)
    {
        $persediaan_tiket = Persediaan_tiket::findOrFail($id);
        $persediaan_tiket->delete();
        return response()->json([
            'success' => true,
            'message' => 'Persediaan tiket berhasil dihapus',
            'data' => $persediaan_tiket
        ]);
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

    public function pemesanan()
    {
        $pemesanan = Pemesanan::all();
        return response()->json([
            'status' => true,
            'data' => $pemesanan
        ], Response::HTTP_OK);
    }
    public function tambah_pemesanan(Request $request)
    {
        $validated = $request->validate([
            'id_persediaan' => 'required',
            'nama_pemesan' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'nama_penumpang' => 'required',
        ]);

        $pemesanan = DB::table('pemesanan')->insert([
            'id_persediaan' => $request->id_persediaan,
            'nama_pemesan' => $request->nama_pemesan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'nama_penumpang' => $request->nama_penumpang,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil dipesan',
            'data' => $pemesanan
        ], Response::HTTP_OK);
    }
    public function cek_persediaan(Request $request)
    {
        $asal = $request->input('asal');
        $tujuan = $request->input('tujuan');
        $tgl_keberangkatan = date('Y-m-d', strtotime($request->input('tgl_keberangkatan')));

        $persediaan_tiket = DB::table('persediaan_tiket')
            ->join('tempat_agen AS t', 't.id', '=', 'persediaan_tiket.asal')
            ->join('tempat_agen', 'tempat_agen.id', '=', 'persediaan_tiket.tujuan')
            ->select('persediaan_tiket.tgl_keberangkatan', 'persediaan_tiket.kuota', 'persediaan_tiket.estimasi_perjalanan', 'persediaan_tiket.harga', 't.tempat_agen AS asal', 'tempat_agen.tempat_agen AS tujuan')
            ->where('asal', $asal)
            ->where('tujuan', $tujuan)
            ->where('tgl_keberangkatan', 'like', '%' . $tgl_keberangkatan . '%')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data tersedia',
            'data' => $persediaan_tiket
        ], Response::HTTP_OK);
    }
}
