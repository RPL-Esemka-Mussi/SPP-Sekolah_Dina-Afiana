@extends('main.bootstrap')
@section('content')
    <div class="text-center py-5  bg-dark text-white">
        <h3>Kelola Pembayaran</h3>
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <div>
                <h4>Data pembayaran</h4>
            </div>
            <form class="row row-cols-lg-auto g-1 align-item-center" action="{{ url('pembayaran') }}" method="get">
                <div class="col-12">
                    <input type="text" name="cari" id="cari" name="cari" value="{{ $keyword != null ? $keyword : '' }}"
                        class="form-control" placeholder="cari data... ">
                </div>
                <div class="col-12">
                    <button type="text" class="btn btn-success ms-3">Cari</button>
                </div>
            </form>
        </div>
        @if (Session::has('sukses'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong>{{ Session::get('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (Session::has('sukses'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong>{{ Session::get('gagal') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <hr>
        @can('admin')
        <div class="text-end">
            <a href="{{ url('pembayaran/cetak') }}" class="btn btn-danger">Print All</a>
            <!-- Button trigger modal -->
        </div>
        @endcan
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($siswa->count() == 0)
                    <tr class="text-center">
                        <td colspan="7">Belum ada data.</td>
                    </tr>
                @else
                    @foreach ($siswa as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nis }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->kelas->kelas }}</td>
                            <td>

                                @if (auth()->user()->level == 'siswa')
                                    <a href='{{ url("pembayaran/history/$data->id") }}' class="btn btn-info btn-sm">History</a>
                                @else
                                    <a href='{{ url("pembayaran/transaksi/$data->id") }}'
                                        class="btn btn-success btn-sm">Transaksi</a>
                                @endif
                                @can('admin')
                                    <a href='{{ url("pembayaran/cetak/$data->id") }}' class="btn btn-info btn-sm">Print Id</a>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
