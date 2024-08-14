@extends('layout.main')

@section('container')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form class="login-form">
                <img src="{{URL::asset('/logo/logo.png')}}">

                <div class="judul mt-3">
                    Kantin SMA Labschool Kebayoran
                </div>
                <div class="slogan mb-3">
                    " Makan Bergizi "
                </div>
                <div class="d-grid">
                    <a href="{{('/login')}}" class="btn btn-primary mb-3">Masuk</a>
                </div>

                <div class="d-grid">
                    <a href="{{('/register')}}" class="btn btn-primary mb-3">Daftar</a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
