@extends('admin.layout.main')

@section('title', '')

@section('container')
<form action="{{ isset($jenisMenu) ? route('jenis-menu.tambah.update', $jenisMenu->id_jenis_menu) : route('jenis-menu.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white">{{ isset($jenisMenu) ? 'Form Edit Jenis Menu' : 'Form Tambah Jenis Menu' }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_jenis_menu">Nama Jenis Menu</label>
                        <input type="text" class="form-control form-control-sm @error('nama_jenis_menu')is-invalid @enderror"" id=" nama_jenis_menu" name="nama_jenis_menu" value="{{ isset($jenisMenu) ? $jenisMenu->nama_jenis_menu : '' }}">
                        @error('nama_jenis_menu')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($jenisMenu) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('jenis-menu')}}" class="btn btn-sm btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
