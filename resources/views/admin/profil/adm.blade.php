@extends('admin.layout.main')

@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')
@section('container')
<form action="" method="">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header  bg-success  py-3">
                    <h6 class="m-0 font-weight-bold text-white">Form Profil</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="id_member">User</label>
                        <input type="text" class="form-control form-control-sm" id="id_user" name="id_user" value="{{ isset($user) ? $user: '' }}" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_member">Password Baru</label>
                        <input type="text" class="form-control form-control-sm" id="password" name="password">
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_member">konfirmasi Password baru</label>
                        <input type="text" class="form-control form-control-sm" id="konfirmasi" name="konfirmasi">
                    </div>
                </div>
                <div class=" card-footer">
                    <button type="button" class="btn btn-sm btn-outline-danger ganti">Ubah Password</button>
                    <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.ganti').on('click', function() {
            let pass = $('#password').val().trim();
            let idUser = $('#id_user').val().trim();
            let konfir = $('#konfirmasi').val().trim();
            let cal = pass.length;
            if (pass != konfir) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Password tidak sama ',
                });
            } else if (cal <= 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Password harus lebih dari 3 karakter',
                });
            } else {
                $.ajax({
                    url: "{{ route('user.ubah') }}",
                    method: "PUT",
                    data: {
                        id_user: idUser,
                        password: pass,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response, textStatus, xhr) {
                        if (xhr.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                type: 'success',
                                title: 'Success',
                                text: response.message,
                            });

                            $('#reset').modal('hide');
                            $('#password').val('');
                            $('#konfirmasi').val('');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                type: 'error',
                                title: 'Gagal',
                                text: response.message,
                            });
                        }

                    },
                    error: function(response) {
                        let errorMessage = 'An unknown error occurred.';

                        try {
                            let response = JSON.parse(xhr.responseText);

                            if (response.message) {
                                errorMessage = response.message;
                            } else if (response.errors && response.errors.qrcode && response.errors.qrcode.length > 0) {
                                errorMessage = response.errors.qrcode[0];
                            }
                        } catch (e) {
                            console.error('Error parsing the response:', e);
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'GAGAL',
                            text: errorMessage,
                        });
                    }
                });
            }
        });
    });
</script>
