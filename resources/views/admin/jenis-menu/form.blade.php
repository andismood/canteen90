@extends('admin.layout.main')

@section('title', 'Form Jenis Menu')

@section('container')
<form action="{{ isset($jenisMenu) ? route('jenis-menu.tambah.update', $jenisMenu->id_jenis_menu) : route('jenis-menu.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($jenisMenu) ? 'Form Edit Jenis Menu' : 'Form Tambah Jenis Menu' }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_jenis_menu">Nama Jenis Menu</label>
                        <input type="text" class="form-control" id="nama_jenis_menu" name="nama_jenis_menu" value="{{ isset($jenisMenu) ? $jenisMenu->nama_jenis_menu : '' }}">
                    </div>

                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($jenisMenu) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('jenis-menu')}}" class="btn btn-primary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
