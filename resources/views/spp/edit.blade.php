@extends('main.bootstrap')
@section('content')
    <div class="text-center py-5 bg-dark text-light">
        <h3>Kelola SPP</h3>
    </div>
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <div>
                <h4>Edit SPP</h4>
            </div>
            <a href="{{ url('spp.index') }}" class="btn btn-warning">Kembali</a>
        </div>
        <hr>
        <form action="{{ url('spp/update') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $spp->id }}">
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" name="tahun" id="tahun" class="form-control" value="{{ $spp->tahun }}" required>
            </div>
            <div class="form-group">
                <label for="nominal">Nominal</label>
                <input type="number" name="nominal" id="nominal" class="form-control" value="{{ $spp->nominal }}" required>
            </div>
            <div class="mt-4 text-end">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="simpan" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
@endsection
