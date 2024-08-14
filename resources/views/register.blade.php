@extends('layout.main')

@section('container')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form class="login-form" action="/register" method="POST">
                @csrf
                <img src="{{URL::asset('logo/logo.png')}}" class="mb-4">
                @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('error')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="col mb-2">
                    <input type="number" class="form-control  rounded-top @error('id_member')is-invalid @enderror" id="id_member" name="id_member" placeholder="Nomor Induk Siswa" require value="{{ old('id_member') }}">
                    @error('id_member')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="col mb-2">
                    <input type="text" class="form-control @error('nama')is-invalid @enderror" id="nama" name="nama" placeholder="Nama" require value="{{ old('nama') }}">
                    @error('nama')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col mb-2">
                    <select name="id_kelas" id="id_kelas" class="form-select form-select-sm @error('id_kelas')is-invalid @enderror">
                        <option value="" selected disabled hidden>-- Pilih Kelas --</option>
                        @foreach ($kelas as $row)
                        <option value="{{$row->id_kelas}}"> {{$row->id_kelas.' - '.$row->nama_kelas}}</option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col mb-2">
                    <input type="password" class="form-control @error('password')is-invalid @enderror" id="password" name="password" placeholder="Password" require value="{{ old('password') }}">
                    @error('password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="col mb-2">
                    <input type="password" class="form-control rounded-bottom @error('konfirmasi-password')is-invalid @enderror" id="konfirmasi-password" name="konfirmasi-password" placeholder="konfirmasi Password" require value="{{ old('konfirmasi-password') }}">

                    @error('konfirmasi-password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
                <small class="d-block text-center mt-2"><a href="/login">Masuk</a> atau <a href="/">Kembali Halaman Utama</a> </small>
            </form>

        </div>
    </div>
</div>




@endsection
