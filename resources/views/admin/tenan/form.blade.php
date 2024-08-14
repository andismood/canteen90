@extends('admin.layout.main')

@section('title', '')

@section('container')

<form action="{{ isset($tenant) ? route('tenant.tambah.update', $tenant->id_tenant) : route('tenant.tambah.simpan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white">{{ isset($tenant) ? 'Form Ubah Tenant' : 'Form Tambah Tenant' }}</h6>
                </div>
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="nama_tenant">Pemilik Tenant</label>
                        <input type="text" class="form-control form-control-sm @error('nama_tenant')is-invalid @enderror" id="nama_tenant" name="nama_tenant" value="{{ isset($tenant) ? $tenant->nama_tenant : '' }}">
                        @error('nama_tenant')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-2 ">
                        <label for="nama_kantin">Nama Tenant</label>
                        <input type="text" class="form-control form-control-sm @error('nama_kantin')is-invalid @enderror" id="nama_kantin" name="nama_kantin" value="{{ isset($tenant) ? $tenant->nama_kantin : '' }}">
                        @error('nama_kantin')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="id_user">Nama Pengguna</label>
                        <input type="text" class="form-control form-control-sm @error('id_user')is-invalid @enderror" id="id_user" name="id_user" value="{{ isset($tenant) ? $tenant->id_user : '' }}" {{ isset($tenant) ? "readonly" : '' }}>
                        @error('id_user')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="flag_aktif">Status Aktif</label>
                        <select name="flag_aktif" id="flag_aktif" class="form-select form-select-sm @error('flag_aktif')is-invalid @enderror">
                            <option value="" selected disabled hidden>-- Pilih Status Aktif --</option>
                            <option value="0" {{ isset($tenant) && $tenant->flag_aktif == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="1" {{ isset($tenant) && $tenant->flag_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                        </select>
                        @error('flag_aktif')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nm_gambar" class="form-label">Logo Tenant</label>
                        <input class="form-control form-control-sm @error('nm_gambar')is-invalid @enderror" id="nm_gambar" name="nm_gambar" value="{{ isset($tenant) ? $tenant->url_gambar : '' }}" type="file" accept="image/*">
                        @error('nm_gambar')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="qrcode_image" class="form-label">Gambar QRIS</label>
                        <input class="form-control form-control-sm @error('qrcode_image')is-invalid @enderror" id="qrcode_image" name="qrcode_image" value="{{ isset($tenant) ? $tenant->qrcode_image : '' }}" type="file" accept="image/*">
                        @error('qrcode_image')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($tenant) ? 'Ubah Data' : 'Simpan' }}</button>
                    @if(auth()->user()->id_type_user === "adm")
                    <a href="{{route('tenant')}}" class="btn btn-sm btn-secondary">Batal</a>
                    @else
                    <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary">Batal</a>
                    @endif

                </div>


            </div>
        </div>
    </div>
</form>
@endsection
