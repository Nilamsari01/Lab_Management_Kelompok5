@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Form Peminjaman Alat</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('peminjaman.store') }}">
    @csrf

    @foreach($alat as $a)
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="alat_{{ $a->id }}" name="alat_id[]" value="{{ $a->id }}">
                    <label class="form-check-label" for="alat_{{ $a->id }}">
                        {{ $a->nama_alat }} ({{ $a->kategori }})
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="jumlah[{{ $a->id }}]" min="1" placeholder="Jumlah" value="1">
            </div>
            <div class="col-md-3 text-end">
                <span class="text-muted">Stok: {{ $a->stok }}</span>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Ajukan Peminjaman</button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
@endsection