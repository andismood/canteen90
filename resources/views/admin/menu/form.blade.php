@extends('admin.layout.main')

@section('title', '')

@section('container')
<form action="{{ isset($menu) ? route('menu.tambah.update', $menu->id_menu) : route('menu.tambah.simpan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white">{{ isset($menu) ? 'Form Edit Menu' : 'Form Tambah Menu' }}</h6>
                </div>
                <div class="card-body">

                    <div class="col-md-4 mb-2">
                        <label for="id_jenis_menu">Jenis Menu</label>
                        <select name="id_jenis_menu" id="id_jenis_menu" class="form-select form-select-sm @error('id_jenis_menu')is-invalid @enderror" require value="{{ old('id_jenis_menu') }}">
                            <option value="" selected disabled hidden>-- Pilih Jenis Menu --</option>
                            @foreach ($jenisMenu as $row)
                            <option value="{{ $row->id_jenis_menu }}" {{ isset($menu) ? ($menu->id_jenis_menu == $row->id_jenis_menu ? 'selected' : '') : '' }}>{{ $row->nama_jenis_menu }}</option>
                            @endforeach
                        </select>
                        @error('id_jenis_menu')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control form-control-sm @error('nama_menu')is-invalid @enderror" id="nama_menu" name="nama_menu" value="{{ isset($menu) ? $menu->nama_menu : '' }}" require value="{{ old('nama_menu') }}">
                        @error('nama_menu')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="harga_jual">harga</label>
                        <input type="text" class="form-control form-control-sm @error('harga_jual')is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ isset($menu) ? $menu->harga_jual : '' }}" require value="{{ old('harga_jual') }}">
                        @error('harga_jual')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="id_tenant">Pemilik Tenant</label>
                        <select name="id_tenant" id="id_tenant" class="form-select form-select-sm @error('id_tenant')is-invalid @enderror" require value="{{ old('id_tenant') }}">
                            <option value="" selected disabled hidden>-- Pilih Tenant --</option>
                            @foreach ($tenant as $row)
                            <option value="{{ $row->id_tenant }}" {{ isset($menu) ? ($menu->id_tenant == $row->id_tenant ? 'selected' : '') : '' }}>{{ $row->nama_tenant.' - '.$row->nama_kantin }}</option>
                            @endforeach
                        </select>
                        @error('id_tenant')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="status_menu">Status Menu</label>
                        <select name="status_menu" id="status_menu" class="form-select form-select-sm @error('status_menu')is-invalid @enderror" require value="{{ old('status_menu') }}">
                            <option value="" selected disabled hidden>-- Pilih Status Menu --</option>
                            <option value="0" {{isset($menu) ? ($menu->status_menu === '0' ? 'selected' : '') : '' }}>Tesedia</option>
                            <option value="1" {{isset($menu) ? ($menu->status_menu === '1' ? 'selected' : '') : '' }}>Habis</option>
                            <option value="2" {{isset($menu) ? ($menu->status_menu === '2' ? 'selected' : '') : '' }}>Sedang Tidak Tersedia</option>
                        </select>
                        @error('status_menu')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
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
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($menu) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('menu')}}" class="btn btn-sm btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
