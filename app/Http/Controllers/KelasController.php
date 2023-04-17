<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();

        return view('kelas.index', compact('kelas'));
    }
    public function tambah()
    {
        return view('kelas.tambah');
    }

    public function simpan(Request $request)
    {
        try {
            Kelas::create([
                'kelas' => $request->kelas,
                'kompetensi_keahlian' => $request->kompetensi_keahlian,
            ]);

            return redirect('kelas')->with('sukses', 'Data berhasil ditambahkan✅.');
        } catch (\exception $e) {
            return redirect('kelas')->with('gagal', 'Data gagal ditambahkan❎.');
        }
    }

    public function edit($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);

            return view('kelas.edit', compact('kelas'));
        } catch (\Exception $e) {
            return redirect('kelas')->with('gagal', 'Data tidak ditambahkan❎.');
        }
    }

    public function update(Request $request)
    {
        try {
                Kelas::where('id', $request->id)->update([
                    'kelas' => $request->kelas,
                    'kompetensi_keahlian' => $request->kompetensi_keahlian,

                ]);

                Kelas::where('id', $request->id)->update([
                    'kelas' => $request->kelas,
                    'kompetensi_keahlian' => $request->kompetensi_keahlian,

                ]);
            return redirect('kelas')->with('sukses', 'Data Berhasil Diupdate✅.');
        } catch (\Exception $e) {
            return redirect('kelas')->with('gagal', 'Data Gagal Diupdate❎.');
        }
    }

    public function hapus($id)
    {
        try {
            Kelas::findOrFail($id);
            Kelas::destroy($id);

            return redirect('kelas')->with('sukses', 'Data Berhasil Dihapus✅.');
        } catch (\Exception $e) {
            return redirect('kelas')->with('gagal', 'Data Gagal Dihapus❎.');
        }
    }
}
