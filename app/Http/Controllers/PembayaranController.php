<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\SPP;
use App\Models\User;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $keyword = null;

        if ($request->cari != null) {
            $siswa = Siswa::with('user')->whereRelation('user', 'name', 'like', "%$request->cari%")->orderBy('kelas_id', 'ASC')->get();
            $keyword = $request->cari;
        } else {
            if (auth()->user()->level == 'siswa') {
                $siswa = Siswa::where('user_id', '=', auth()->user()->id)->get();
            } else {
                $siswa = Siswa::orderBy('kelas_id', 'ASC')->get();
            }
        }
        return view('pembayaran.index', compact('siswa', 'keyword'));
    }

    public function transaksi($id)
    {
        $dibayar = 0;
        $tagihan = 0;
        $pembayaranSPP = [];

        try {
            $siswa = Siswa::findOrfail($id);
            $pembayaran = Pembayaran::where('siswa_id', $id)->get();
            $spp = SPP::get();


            foreach ($pembayaran as $data) {
                $dibayar += $data->jumlah_bayar;
            }

            foreach ($spp as $data) {
                $tagihan += $data->nominal;

                $total = Pembayaran::where('spp_id', $data->id)->where('siswa_id', $id)->sum('jumlah_bayar');
                $pembayaranSPP[] = $total;
            }


            $total = [
                'total_dibayar' => $dibayar,
                'total_belumdibayar' => $tagihan - $dibayar
            ];
        } catch (\Exception $e) {
            return redirect('pembayaran')->with('gagal', "Data tidak ditemukan❎.");
        }

        return view('pembayaran.transaksi', compact('spp', 'pembayaran', 'siswa', 'total', 'pembayaranSPP'));
    }

    public function simpan(Request $request)
    {
        try {
            Pembayaran::create([
                'user_id' => auth()->user()->id,
                'siswa_id' => $request->siswa_id,
                'spp_id' => $request->spp_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah_bayar' => $request->jumlah_bayar
            ]);

            return redirect()->back()->with('sukses', "Transaksi berhasil disimpan✅.");
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', "Transaksi gagal diproses❎." . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data = Pembayaran::findOrfail($id);
            $spp = SPP::all();
            $siswa = Siswa::all();
            $user = User::all();


            return view('pembayaran.edit', compact('data', 'spp', 'siswa', 'user'));

            return redirect('pembayaran')->with('sukses', "Data berhasil✅.");
        } catch (\Exception $e) {
            return redirect('pembayaran')->with('gagal', "Data gagal❎.");
        }
    }

    public function update(Request $request)
    {
        try {
            Pembayaran::where('id', $request->id)->update([
                'jumlah_bayar' => $request->jumlah_bayar,
            ]);

            return redirect('pembayaran')->with('sukses', "Data berhasil✅.");
        } catch (\Exception $e) {
            return redirect('pembayaran')->with('gagal', "Data gagal❎.");
        }
    }

    public function hapus($id)
    {
        try {
            Pembayaran::findOrfail($id);
            Pembayaran::destroy($id);

            return redirect()->back()->with('sukses', "Data berhasil dihapus✅.");
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', "Data gagal dihapus❎.");
        }
    }

    ///CETAK HISTORY ALL
    public function cetak()
    {
        $pembayaran = Pembayaran::all();

        return view('pembayaran.cetak', compact('pembayaran'));
    }

    ///CETAK HISTORY SISWA

    public function cetakid($id)
    {
        $siswa = Siswa::findOrFail($id);

        $pembayaran = Pembayaran::where('siswa_id', $id)->get();

        return view('pembayaran.cetakid', compact('pembayaran', 'siswa'));
    }

    
    public function history($id)
    {
        $dibayar = 0;
        $tagihan = 0;
        $pembayaranSPP = [];

        try {
            $siswa = Siswa::findOrfail($id);
            $pembayaran = Pembayaran::where('siswa_id', $id)->get();
            $spp = SPP::get();


            foreach ($pembayaran as $data) {
                $dibayar += $data->jumlah_bayar;
            }

            foreach ($spp as $data) {
                $tagihan += $data->nominal;

                $total = Pembayaran::where('spp_id', $data->id)->where('siswa_id', $id)->sum('jumlah_bayar');
                $pembayaranSPP[] = $total;
            }


            $total = [
                'total_dibayar' => $dibayar,
                'total_belumdibayar' => $tagihan - $dibayar
            ];
        } catch (\Exception $e) {
        }

        return view('pembayaran.history', compact('spp', 'pembayaran', 'siswa', 'total', 'pembayaranSPP'));
    }
}
