@extends('layout.main')

@section('container')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <form class="login-form" action="/register" method="POST">
                @csrf
                <img src={{URL::asset('/assets/image/logo.png')}} class="mb-4">
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
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
                <small class="d-block text-center mt-2"><a href="/login">Login</a>  or  <a href="/">Back to Home</a> </small>
            </form>

        </div>
    </div>
</div>
<!--
<div class="row justify-content-center">
    <div class="col-md-4">
        <main class="form-registration w-100 m-auto">
            <form action="/register" method="POST">
                @csrf
                <div class="text-center">
                    <img class="mb-4" src="../assets/image/logo.png" alt="" width="100" height="100">
                </div>

                <h1 class="h3 mb-3 fw-normal">Please Registration</h1>

                <div <div class="form-floating">
                    <input type="number" class="form-control  rounded-top @error('id_member')is-invalid @enderror" id="id_member" name="id_member" placeholder="Nomor Induk Siswa" require value="{{ old('id_member') }}">
                    <label for=" floatingInput">Nis</label>
                    @error('id_member')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control @error('nama')is-invalid @enderror" id="nama" name="nama" placeholder="Nama" require value="{{ old('nama') }}">
                    <label for="floatingInput">Nama</label>
                    @error('nama')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control @error('password')is-invalid @enderror" id="password" name="password" placeholder="Password" require value="{{ old('password') }}">
                    <label for="floatingPassword">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control rounded-bottom @error('konfirmasi-password')is-invalid @enderror" id="konfirmasi-password" name="konfirmasi-password" placeholder="Password" require value="{{ old('konfirmasi-password') }}">
                    <label for="floatingPassword">Konfirmasi Password</label>
                    @error('konfirmasi-password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100 py-2 mt-4" type="submit">Register</button>

            </form>
            <small class="d-block text-center mt-2 mb-4">Already Login ? <a href="/login">Login</a> </small>
        </main>
    </div>
</div> -->



@endsection
