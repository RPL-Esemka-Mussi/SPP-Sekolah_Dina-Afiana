<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
     public function index()
    {
        $spp = Spp::all();

        return view('spp.index', compact('spp'));
    }
    public function tambah()
    {
        return view('spp.tambah');
    }

    public function simpan(Request $request)
    {
        try {
            Spp::create([
                'tahun' => $request->tahun,
                'nominal' => $request->nominal,
            ]);

            return redirect('spp')->with('sukses', 'Data berhasil ditambahkan✅.');
        } catch (\exception $e) {
            return redirect('spp')->with('gagal', 'Data gagal ditambahkan❎.');
        }
    }

    public function edit($id)
    {
        try {
            $spp = Spp::findOrFail($id);

            return view('spp.edit', compact('spp'));
        } catch (\Exception $e) {
            return redirect('spp')->with('gagal', 'Data tidak ditambahkan❎.');
        }
    }

    public function update(Request $request)
    {
        try {
                Spp::where('id', $request->id)->update([
                    'tahun' => $request->tahun,
                    'nominal' => $request->nominal,

                ]);

                Spp::where('id', $request->id)->update([
                    'tahun' => $request->tahun,
                    'nominal' => $request->nominal,

                ]);
            return redirect('spp')->with('sukses', 'Data Berhasil Diupdate✅.');
        } catch (\Exception $e) {
            return redirect('spp')->with('gagal', 'Data Gagal Diupdate❎.');
        }
    }

    public function hapus($id)
    {
        try {
            Spp::findOrFail($id);
            Spp::destroy($id);

            return redirect('spp')->with('sukses', 'Data Berhasil Dihapus✅.');
        } catch (\Exception $e) {
            return redirect('spp')->with('gagal', 'Data Gagal Dihapus❎.');
        }
    }
}
