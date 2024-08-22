@extends('admin.layout.main')

@section('title', '')

@section('container')
<form action="{{ isset($kelas) ? route('kelas.tambah.update', $kelas->id_kelas) : route('kelas.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white">{{ isset($kelas) ? 'Form Edit Kelas' : 'Form Tambah Kelas' }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="kode_kelas">Kode Kelas</label>
                        <input type="text" class="form-control form-control-sm @error('id_kelas')is-invalid @enderror" id="id_kelas" name="id_kelas" value="{{ isset($kelas) ? $kelas->id_kelas : '' }}" {{ isset($kelas) ? "readonly" : '' }}>
                        @error('id_kelas')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control form-control-sm @error('nama_kelas')is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ isset($kelas) ? $kelas->nama_kelas : '' }}">
                        @error('nama_kelas')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group mb-2">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control form-control-sm " id="keterangan" name="keterangan" value="{{ isset($kelas) ? $kelas->keterangan : '' }}">
                    </div>
                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($kelas) ? 'Ubah Kelas' : 'Simpan' }}</button>
                    <a href="{{route('kelas')}}" class="btn btn-sm btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
