@extends('admin.layout.main')

@section('title', 'Form Member')

@section('container')
<form action="{{ isset($member) ? route('member.tambah.update', $member->id) : route('member.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($member) ? 'Form Edit Member' : 'Form Tambah Member' }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_member">Kode Member</label>
                        <input type="text" class="form-control" id="id_member" name="id_member" value="{{ isset($member) ? $member->id_member : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_member">Nama Member</label>
                        <input type="text" class="form-control" id="nama_member" name="nama_member" value="{{ isset($member) ? $member->nama_member : '' }}">
                    </div>

                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($member) ? 'Ubah Data' : 'Simpan' }}</button>
                    <a href="{{route('member')}}" class="btn btn-primary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
