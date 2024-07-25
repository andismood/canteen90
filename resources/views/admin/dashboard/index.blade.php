@extends('admin.layout.main')

@section('title', '')

@section('container')


<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pilih Tenant</h6>
    </div>
    <section class="portfolio" id="portfolio">
        <div class="container fluid">
            <row>
                <div class="row">
                    @foreach ($data as $row)
                    <div class="col-sm-3 ">
                        <a class="gambar">
                            <!-- <div class="oval-image">
                                <img src=" {{ $row->url_gambar }}" alt="{{ $row->nama_tenant }}">
                            </div> -->
                            <a href="{{route('tenant.menu-tenant',$row->id_tenant)}}"><img src="{{URL::asset('/images/'.$row->url_gambar)}}"  alt=" {{ $row->nama_tenant }}"></a>
                            <span> </span>
                            <!-- <div class="namaTenant">{{$row->nama_kantin}}</div> -->
                            <div class="menuNama mb-3">{{$row->nama_kantin}}</div>
                            <!-- <div class="menuHarga">{{"Rp. " .$row->harga_jual}}</div> -->

                            <!-- @if ($row->status_menu == "0")
                            <div class="menuPesan">
                                <small class="btn btn-sm btn-success pesanMenu" id="{{$row->id_menu}}" id2="{{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Pesan</small>
                            </div>
                            @elseif($row->status_menu == "1")
                            <div class="soldOut"><img src="{{URL::asset('/images/icon/sold-out.png')}}" class="imgSold"></div>
                            @else

                            @endif -->
                        </a>
                    </div>
                    @endforeach
                </div>
            </row>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" id="exampleModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Menu Makanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-3">
                            <img id="modalMenuImage" src="" alt="Gambar Menu" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="col-6">
                            <input type="hidden" id="id_menu" name="id_menu" />
                            <input type="hidden" id="id_tenant" name="id_tenant" />
                            <h4 id="modalMenuName" name="modal_nama_menu">Nama Menu</h4>
                            <h4 id="modalMenuPrice" name="modal_harga_jual">Harga Menu</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control form-control-sm" id="jumlah" name="jumlah">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="catatan" name="catatan">
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

@endsection

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $("#exampleModal").on("show.bs.modal", function(event) {
        $('.pesanMenu').click(function() {
            var id_menu = $(this).attr('id');
            var id_tenant = $(this).attr('id2');

            $.ajax({
                url: "{{ route('dashboard.by-id') }}",
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
                    console.error('Error:', error);
                }
            });

        });

        $('form').on('submit', function(e) {
            e.preventDefault();
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



        });

    });
</script>
