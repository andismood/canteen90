@extends('admin.layout.main')

@section('title', '')

@section('container')

<form action="{{ isset($tenant) ? route('tenant.tambah.update', $tenant->id_tenant) : route('tenant.tambah.simpan') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white">{{ isset($tenant) ? 'Form Ubah Tenant' : 'Form Tambah Tenant' }}</h6>
                </div>
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="nama_tenant">Pemilik Tenant</label>
                        <input type="text" class="form-control form-control-sm @error('nama_tenant')is-invalid @enderror" id="nama_tenant" name="nama_tenant" value="{{ isset($tenant) ? $tenant->nama_tenant : '' }}">
                        @error('nama_tenant')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-2 ">
                        <label for="nama_kantin">Nama Tenant</label>
                        <input type="text" class="form-control form-control-sm @error('nama_kantin')is-invalid @enderror" id="nama_kantin" name="nama_kantin" value="{{ isset($tenant) ? $tenant->nama_kantin : '' }}">
                        @error('nama_kantin')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="id_user">Nama Pengguna</label>
                        <input type="text" class="form-control form-control-sm @error('id_user')is-invalid @enderror" id="id_user" name="id_user" value="{{ isset($tenant) ? $tenant->id_user : '' }}" {{ isset($tenant) ? "readonly" : '' }}>
                        @error('id_user')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label for="flag_aktif">Status Aktif</label>
                        <select name="flag_aktif" id="flag_aktif" class="form-select form-select-sm @error('flag_aktif')is-invalid @enderror">
                            <option value="" selected disabled hidden>-- Pilih Status Aktif --</option>
                            <option value="0" {{ isset($tenant) && $tenant->flag_aktif == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="1" {{ isset($tenant) && $tenant->flag_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                        </select>
                        @error('flag_aktif')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label for="nm_gambar" class="form-label">Logo Tenant</label>
                        <input class="form-control form-control-sm @error('nm_gambar')is-invalid @enderror" id="nm_gambar" name="nm_gambar" value="{{ isset($tenant) ? $tenant->url_gambar : '' }}" type="file" accept="image/*">
                        @error('nm_gambar')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-2">
                        <label for="qrcode_image" class="form-label">Gambar QRIS</label>
                        <input class="form-control form-control-sm @error('qrcode_image')is-invalid @enderror" id="qrcode_image" name="qrcode_image" value="{{ isset($tenant) ? $tenant->qrcode_image : '' }}" type="file" accept="image/*">
                        @error('qrcode_image')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class=" card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ isset($tenant) ? 'Ubah Data' : 'Simpan' }}</button>
                    @if(auth()->user()->id_type_user === "tnt")
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reset">Ubah Password</button>
                    @endif
                    @if(auth()->user()->id_type_user === "adm")
                    <a href="{{route('tenant')}}" class="btn btn-sm btn-secondary">Batal</a>
                    @else
                    <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary">Batal</a>
                    @endif

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
