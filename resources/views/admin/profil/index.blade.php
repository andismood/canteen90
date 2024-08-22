@extends('admin.layout.main')

@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')
@section('container')
<form action="{{route('profil.update')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header  bg-success  py-3">
                    <h6 class="m-0 font-weight-bold text-white">Form Profil</h6>
                </div>
                <div class="card-body">
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="form-group mb-2">
                        <label for="id_member">NIS</label>
                        <input type="text" class="form-control form-control-sm" id="id_user" name="id_user" value="{{ isset($member) ? $member->id_member: '' }}" readonly>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_member">Nama Siswa</label>
                        <input type="text" class="form-control form-control-sm" id="nama_member" name="nama_member" value="{{ isset($member) ? $member->nama_member : '' }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="id_kelas">Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-select form-select-sm">
                            <option value="" selected disabled hidden>-- Pilih Kelas --</option>
                            @foreach ($kelas as $row)
                            <option value="{{ $row->id_kelas }}" {{ isset($member) ? ($member->id_kelas === $row->id_kelas ? 'selected' : '') : '' }}>{{$row->id_kelas}} - {{$row->nama_kelas}} </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($member) ? 'Ubah Data' : 'Simpan' }}</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reset">Ubah Password</button>
                    <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- modal ubah password -->
<div class="modal fade" tabindex="-1" id="reset" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered p-3">
        <div class="modal-content">

            <div class="modal-header bg-secondary white-color">
                <div class="bill">
                    <div class="judul">
                        <!-- <Label>Canteen Connect</Label> -->
                    </div>
                </div>

            </div>
            <div class="modal-body ">
                <!-- <div class="row  mb-2">
                    <div class=" col-4">
                        Password Lama
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="password_lama" name="password_lama" value="">
                    </div>
                </div> -->
                <div class="row mb-2">
                    <div class="col-4">
                        Password Baru
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="password" name="password" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Konfirmasi Password
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="konfirmasi_password" name="konfirmasi_password" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <small class="btn btn-sm btn-primary px-3 ubah">Ubah kata sandi</small>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
@endsection


<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.ubah').on('click', function() {
            let pass = $('#password').val().trim();
            let idUser = $('#id_user').val().trim();
            let konfir = $('#konfirmasi_password').val().trim();
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
