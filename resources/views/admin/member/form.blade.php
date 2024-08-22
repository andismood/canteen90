@extends('admin.layout.main')

@section('title', '')

@section('container')
<form action="{{ isset($member) ? route('member.tambah.update', $member->id_member) : route('member.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white ">{{ isset($member) ? 'Form Edit Siswa' : 'Form Tambah Siswa' }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="id_member">NIS</label>
                        <input type="text" class="form-control form-control-sm @error('id_member')is-invalid @enderror" id=" id_member" name="id_member" value="{{ isset($member) ? $member->id_member: '' }}" {{ isset($member) ? "readonly" : '' }}>
                        @error('id_member')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_member">Nama Siswa</label>
                        <input type="text" class="form-control form-control-sm @error('nama_member')is-invalid @enderror" id=" nama_member" name="nama_member" value="{{ isset($member) ? $member->nama_member : '' }}">
                        @error('nama_member')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="id_kelas">Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-select form-select-sm form-select-sm @error('id_kelas')is-invalid @enderror">
                            <option value="" selected disabled hidden>-- Pilih Kelas --</option>
                            @foreach ($kelas as $row)
                            <option value="{{ $row->id_kelas }}" {{ isset($member) ? ($member->id_kelas == $row->id_kelas ? 'selected' : '') : '' }}>{{$row->id_kelas}} - {{$row->nama_kelas}} </option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($member) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('member')}}" class="btn btn-sm btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
