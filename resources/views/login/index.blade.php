@extends('layout.main')

@section('container')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form class="login-form" action="/login" method="post">
                @csrf
                <img src={{URL::asset('/assets/image/logo.png')}}>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('id_user')is-invalid @enderror" name="id_user" id="id_user" placeholder="nis" required value="{{ old('id_user') }}" autofocus>
                    @error('id_user')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
                <small class="d-block text-center mt-2">Belum Punya Akun ? <a href="/register">Buat Sekarang</a> </small>
            </form>

        </div>
    </div>
</div>




@endsection
