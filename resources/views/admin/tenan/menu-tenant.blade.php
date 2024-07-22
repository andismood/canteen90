@extends('admin.layout.main')

@section('title', '')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Menu Tenant</h6>
            </div>
            <div class="card-body">

                <div class="portfolio">
                    <div class="row mb-4">
                        <div class="col-sm-3  mb-2">
                            <img src=" {{ $data[0]->url_gambar }}" alt="{{ $data[0]->nama_tenant }}" class="imgTenent">
                        </div>
                        <div class="col-sm-6 ">
                            <div class="row menuNama">
                                <h3> {{$data[0]->nama_kantin}}</h3>
                            </div>
                        </div>
                    </div>
                    <hr>

                    @foreach ($data as $row)
                    <div class=" d-flex flex-row mb-3">
                        <div class="p-2">
                            <img src="{{ $row->nama_gambar }}" alt="{{ $row->nama_menu }}" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="p-2">
                            {{ $row->nama_jenis_menu }}<br>
                            <span class="text-white bg-success ps-2 pe-2">Rp. {{$row->harga_jual}}</span><br>
                            <!-- <button type="button" class="btn btn-outline-info mt-2" id="{{$row->id_menu}}" id2="{{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Pesan</button> -->
                            <div>
                                <small class="btn btn-sm btn-outline-info menuPesan mt-2" id="{{$row->id_menu}}" id2="{{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Pesan</small>
                            </div>
                        </div>

                    </div>
                    <hr>
                    @endforeach

                </div>
            </div>
            <div class="card-footer">
                <div class="d-inline-flex">
                    <div class=" py-2">
                        <a href="{{route('dashboard')}}" class="btn btn-sm btn-primary px-3 mx-2">kembali</a>
                    </div>

                    <div class="py-2">
                        <small class="btn btn-sm btn-primary px-3" id="bill" data-bs-toggle="modal" data-bs-target="#billModal">Lihat Pesanan</small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" tabindex="-1" id="billModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog p-3">
        <div class="modal-content">

            <form action="" method="">
                <div class="modal-body m-3">

                    <div class="row bill">
                        <div class="container text-center">
                            <div class="row judul">
                                <Label>Canteen Connect</Label>
                            </div>
                            <div class="row content">
                                <Label>Nama : Lauran Anan</Label>
                            </div>
                            <div class="row content mb-3">
                                <Label>Kelas : B204</Label>
                            </div>
                            <div class="row warning mb-1">
                                <Label>Tolong Cek Kembali Pesanan Anda</Label>
                            </div>
                        </div>


                        <hr>


                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-sm" id="catatan" name="catatan" placeholder="Notes">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="exampleModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog p-3">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title">Menu Makanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
            <form action="" method="">
                <div class="modal-body m-3">

                    <div class="row portfolio">
                        <div class="row">
                            <img class="imgTenent" id="modalMenuImage" src="" alt="Gambar Menu" style="max-width: 50%; height: auto;">
                        </div>
                        <div class="row">
                            <input type="hidden" id="id_menu" name="id_menu" />
                            <input type="hidden" id="id_tenant" name="id_tenant" />
                            <h4 id="modalMenuName" name="modal_nama_menu">Nama Menu</h4>
                            <div class="col">
                                <span class="text-white bg-success ps-2 pe-2">
                                    <label id="modalMenuPrice" name="modal_harga_jual">Harga Menu</label>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="d-inline-flex">
                        <div class=" py-2">
                            <small class="btn btn-sm btn-primary px-3 mx-1" id="kurang">-</small>
                        </div>
                        <div class="py-2 col-2">
                            <input type="text" value="0" style="text-align: center;" class="form-control form-control-sm" id="jumlah" name="jumlah" width="10" readonly>
                        </div>
                        <div class="py-2">
                            <small class="btn btn-sm btn-primary px-3 mx-1" id="tambah">+</small>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm" id="catatan" name="catatan" placeholder="Notes">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.menuPesan').click(function() {
            var id_menu = $(this).attr('id');
            var id_tenant = $(this).attr('id2');

            $.ajax({
                url: "{{ route('menu.by-id') }}",
                method: "GET",
                data: {
                    id_menu: id_menu,
                    _token: "{{ csrf_token() }}" // Tambahkan token CSRF
                },

                success: function(response) {

                    $('#modalMenuImage').attr('src', response.menu.nama_gambar); // Mengatur sumber gambar

                    // Contoh lain untuk menampilkan informasi lainnya di modal
                    $('#modalMenuName').text(response.menu.nama_menu);
                    $('#modalMenuPrice').text("Rp. " + response.menu.harga_jual);
                    $('#id_menu').text(id_menu);
                    $('#id_tenant').text(id_tenant);
                },
                error: function(xhr, status, error) {
                    window.alert('Error:', error);
                }
            });
        });
        $('#tambah').click(function() {
            var value = parseInt($('#jumlah').val());
            $('#jumlah').val(value + 1);
        });
        $('#kurang').click(function() {
            var value = parseInt($('#jumlah').val());
            if (value > 0) {
                $('#jumlah').val(value - 1);
            }
        });
        $('#exampleModal').on('hidden.bs.modal', function() {
            bersih();
        });
        $('form').on('submit', function(e) {
            e.preventDefault();
            var jumlah = parseInt($('#jumlah').val());
            if (jumlah > 0) {
                simpan();
            } else {
                Swal.fire({
                    icon: 'error',
                    width: 300,
                    title: 'GAGAL',
                    text: 'Jumlah Minimal 1 Pesanan'
                });
            }
        });

        function bersih() {
            $('#jumlah').val('0'); // Set input value to empty string
            $('#catatan').val('');
        }

        function simpan() {
            var id_menu = $('#id_menu').text();
            var id_tenant = $('#id_tenant').text();
            var harga = parseFloat($('#modalMenuPrice').text().replace('Rp. ', '').replace('.', '').replace(',', '.')); // Mengambil harga dan mengubah formatnya ke float
            var jumlah = parseInt($('#jumlah').val());
            var catatan = $('#catatan').val();
            var total = harga * jumlah;


            $.ajax({
                url: "{{ route('dashboard.by-id.simpan') }}",
                method: "POST",
                data: {
                    id_menu: id_menu,
                    id_tenant: id_tenant,
                    harga: harga,
                    jumlah: jumlah,
                    total_harga: total,
                    catatan_menu: catatan,
                    _token: "{{ csrf_token() }}" // Tambahkan token CSRF
                },

                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    bersih();
                    $('#exampleModal').modal('hide');
                },
                error: response => {
                    console.log(response);
                    Swal.fire({
                        icon: 'error',
                        title: 'GAGAL',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                    });
                }

            });
        }
    });
</script>
