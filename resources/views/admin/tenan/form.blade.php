@extends('admin.layout.main')

@section('title', 'Form Tenant')

@section('container')
<form action="{{ isset($tenant) ? route('tenant.tambah.update', $tenant->id_tenant) : route('tenant.tambah.simpan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($tenant) ? 'Form Edit Tenant' : 'Form Tambah Tenant' }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_tenant">Nama Tenant</label>
                        <input type="text" class="form-control form-control-sm" id="nama_tenant" name="nama_tenant" value="{{ isset($tenant) ? $tenant->nama_tenant : '' }}">
                    </div>
                    <div class="form-group ">
                        <label for="nama_kantin">Nama Kantin</label>
                        <input type="text" class="form-control form-control-sm" id="nama_kantin" name="nama_kantin" value="{{ isset($tenant) ? $tenant->nama_kantin : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="id_user">Nama User Login</label>
                        <input type="text" class="form-control form-control-sm" id="id_user" name="id_user" value="{{ isset($tenant) ? $tenant->id_user : '' }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nm_gambar" class="form-label">Gambar</label>
                        <input class="form-control form-control-sm @error('nm_gambar')is-invalid @enderror" id="nm_gambar" name="nm_gambar" value="{{ isset($tenant) ? $tenant->url_gambar : '' }}" type="file" accept="image/*">
                        @error('nm_gambar')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($tenant) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('tenant')}}" class="btn btn-primary">Batal</a>
                </div>


            </div>
        </div>
    </div>
</form>
@endsection
