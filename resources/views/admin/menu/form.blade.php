@extends('admin.layout.main')

@section('title', 'Form Menu')

@section('container')
<form action="{{ isset($menu) ? route('menu.tambah.update', $menu->id_menu) : route('menu.tambah.simpan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($menu) ? 'Form Edit Menu' : 'Form Tambah Menu' }}</h6>
                </div>
                <div class="card-body">

                    <div class="col-md-4 mb-2">
                        <label for="id_jenis_menu">Jenis Menu</label>
                        <select name="id_jenis_menu" id="id_jenis_menu" class="form-select form-select-sm">
                            <option value="" selected disabled hidden>-- Pilih Jenis Menu --</option>
                            @foreach ($jenisMenu as $row)
                            <option value="{{ $row->id_jenis_menu }}" {{ isset($menu) ? ($menu->id_jenis_menu == $row->id_jenis_menu ? 'selected' : '') : '' }}>{{ $row->nama_jenis_menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control form-control-sm" id="nama_menu" name="nama_menu" value="{{ isset($menu) ? $menu->nama_menu : '' }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="harga_jual">harga</label>
                        <input type="text" class="form-control form-control-sm" id="harga_jual" name="harga_jual" value="{{ isset($menu) ? $menu->harga_jual : '' }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="id_tenant">Tenant</label>
                        <select name="id_tenant" id="id_tenant" class="form-select form-select-sm">
                            <option value="" selected disabled hidden>-- Pilih Tenant --</option>
                            @foreach ($tenant as $row)
                            <option value="{{ $row->id_tenant }}" {{ isset($menu) ? ($menu->id_tenant == $row->id_tenant ? 'selected' : '') : '' }}>{{ $row->nama_tenant }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="status_menu">Status Menu</label>
                        <select name="status_menu" id="status_menu" class="form-select form-select-sm">
                            <option value="" selected disabled hidden>-- Pilih Status Menu --</option>
                            <option value="0">Tesedia</option>
                            <option value="1">Habis</option>
                            <option value="2">Sedang Tidak Tersedia</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="nama_gambar" class="form-label">Gambar</label>
                        <input class="form-control form-control-sm @error('nama_gambar')is-invalid @enderror" id="nama_gambar" name="nama_gambar" value="{{ isset($menu) ? $menu->nama_gambar : '' }}" type="file" accept="image/*">
                        @error('nama_gambar')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($menu) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('menu')}}" class="btn btn-primary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
