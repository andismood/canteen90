@extends('admin.layout.main')

@section('title', '')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Daftar Menu Tenant</h6>
            </div>
            <div class="card-body">

                <div class="portfolio">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-2">
                            <input type="hidden" id="url_any" name="url_any" value="{{URL::asset('/')}}" />
                            @if(isset($data[0]->url_gambar))
                            <img src="{{URL::asset('/privates/'.$data[0]->url_gambar)}}" alt="{{ $data[0]->nama_tenant }}" class="imgTenent">
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-3 menuNama">
                                @if(isset($data[0]->nama_kantin))
                                <h3> {{$data[0]->nama_kantin}}</h3>
                                @else
                                <h3> Menu belum tersedia</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>

                    @foreach ($data as $row)
                    <div class=" d-flex flex-row mb-3">
                        <div class="p-2">
                            <img src="{{URL::asset('/images/'.$row->nama_gambar)}}" alt="{{ $row->nama_menu }}" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="p-2 mt-1">
                            <div class="mb-1" style="vertical-align: middle; font-family: 'Trebuchet MS', sans-serif; font-size: 18px;">{{ $row->nama_menu }}</div>
                            <span class="text-white bg-success ps-2 pe-2 py-1" style="border-radius: 20px">Rp. {{$row->harga_jual}}</span><br>
                            <!-- <button type="button" class="btn btn-outline-info mt-2" id="{{$row->id_menu}}" id2="{{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Pesan</button> -->

                            @if(auth()->user()->id_type_user === "mbr")
                            <div>
                                <small class="btn btn-sm btn-outline-info menuPesan mt-2" id="{{$row->id_menu}}" id2="{{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Pesan</small>
                            </div>
                            @endif

                        </div>

                    </div>
                    <hr>
                    @endforeach

                </div>
            </div>
            <div class="card-footer">
                <div class="d-inline-flex">
                    <div class=" py-2">
                        <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary px-3 mx-2">kembali</a>
                    </div>
                    @if(auth()->user()->id_type_user === "mbr")
                    <div class="py-2">
                        <small class="btn btn-sm btn-primary px-3" id="bill" data-bs-toggle="modal" data-bs-target="#billModal">Lihat Pesanan</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<!-- modal bill -->
<div class="modal fade" tabindex="-1" id="billModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered p-3">
        <div class="modal-content">

            <!-- <form action="" method=""> -->
            <div class="modal-body ">

                <div class="row bill">
                    <div class="container text-center">
                        <div class="row judul">
                            <Label>Canteen Connect</Label>
                        </div>
                        <div class="row content">
                            <Label id="nama_member"></Label>
                        </div>
                        <div class="row content mb-3">
                            <Label id="kelas">Kelas : </Label>
                        </div>
                        <div class="row warning mb-1">
                            <Label>Tolong Cek Kembali Pesanan Anda</Label>
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="data">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{route('pesanan')}}" class="btn btn-sm btn-primary" type="button">Ubah Pesanan</a>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<!-- modal pesan menu -->
<div class="modal fade" tabindex="-1" id="exampleModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered p-3">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title">Menu Makanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> -->
            <form action="" method="" id="myForm2">
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
                                <span class="text-white bg-success ps-2 pe-2 py-1" style="border-radius: 20px">
                                    <label id="modalMenuPrice" name="modal_harga_jual">Harga Menu</label>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="d-inline-flex">
                        <div class=" py-2">
                            <small class="btn btn-sm btn-outline-primary px-3 mx-1" id="kurang">-</small>
                        </div>
                        <div class="py-2 col-2">
                            <input type="text" value="0" style="text-align: center;" class="form-control form-control-sm" id="jumlah" name="jumlah" width="10" readonly>
                        </div>
                        <div class="py-2">
                            <small class="btn btn-sm btn-outline-primary px-3 mx-1" id="tambah">+</small>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm"  id="catatan" name="catatan" placeholder="Notes">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Tambah Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal qrcode -->
<div class="modal fade" tabindex="-1" id="qrisModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered p-3">
        <div class="modal-content">
            <div class="modal-body m-3">

                <div class="row qrimage">
                    <div class="row justify-content-center">
                        <img class="qrimageTenent" id="modalQris" src="" alt="Gambar Menu">
                    </div>
                    <div class="row">
                        <input type="hidden" id="id_tenant_qr" name="id_tenant_qr" />
                        <h4 id="modal_nama_tenant" name="modal_nama_tenant">Nama Tenant</h4>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="col mb-2">
                            <label for="nama_gbr_qr" class="form-label">Gambar</label>
                            <input class="form-control form-control-sm @error('nama_gbr_qr')is-invalid @enderror" id="nama_gbr_qr" name="nama_gbr_qr" type="file" accept="image/*">
                            @error('nama_gbr_qr')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" onclick="sendQris()" class="btn btn-sm btn-primary ">Pesan</button>
            </div>
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
            var $path = $('#url_any').val() + "images/";
            $.ajax({
                url: "{{ route('menu.by-id') }}",
                method: "GET",
                data: {
                    id_menu: id_menu,
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {

                    $('#modalMenuImage').attr('src', $path + response.menu.nama_gambar);

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
                cekPilihPesanan();
            } else {
                Swal.fire({
                    icon: 'error',
                    width: 300,
                    title: 'GAGAL',
                    text: 'Jumlah Minimal 1 Pesanan'
                });
            }
            event.preventDefault();
        });

        $('#bill').click(function() {
            cekPesanan();
        });


        function cekPilihPesanan() {
            var id_menu = $('#id_menu').text();
            $.ajax({
                url: "{{ route('pesanan.pilihan') }}",
                method: "GET",
                data: {
                    id_menu: id_menu,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Pemberitahuan',
                            text: response.message,
                        });
                    } else {
                        simpan();
                    }
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'GAGAL',
                        text: 'Terjadi kesalahan saat mendapatkan data.' + response,
                    });
                }
            });
        }


        function cekPesanan() {
            $.ajax({
                url: "{{ route('pesanan.cek') }}",
                method: "GET",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        var user_id = response.user_id;
                        var pesanan = response.menu;
                        var tenantOrders = {}; // Objek untuk menyimpan pesanan berdasarkan ID tenant
                        $('#nama_member').text("Nama : " + response.nama_member);
                        $('#kelas').text("kelas : " + response.id_kelas);

                        // Mengelompokkan pesanan berdasarkan ID tenant
                        pesanan.forEach(function(tenant) {
                            var tenant_id = tenant.id_tenant;
                            var nama_kantin = tenant.nama_kantin;
                            tenantOrders[tenant_id] = {
                                tenant_id: tenant_id,
                                nama_kantin: nama_kantin,
                                orders: []
                            };

                            tenant.menus.forEach(function(menu) {
                                menu.pesanan.forEach(function(pesan) {
                                    tenantOrders[tenant_id].orders.push({
                                        jumlah: pesan.jumlah,
                                        nama_menu: menu.nama_menu,
                                        harga: pesan.total_harga
                                    });
                                });
                            });


                        });

                        // Menampilkan pesanan berdasarkan tenant
                        var allTenantsHtml = '';

                        for (var key in tenantOrders) {
                            if (tenantOrders.hasOwnProperty(key)) {
                                var tenantData = tenantOrders[key];
                                var tenantHtml = '<div class="tenant-container pb-3 pt-3 m-2" style="background-color: LightGray ; border-radius: 10px;">' +
                                    '<h4>' + tenantData.nama_kantin + '</h4>';

                                // Menambahkan setiap pesanan untuk tenant
                                var totals = 0;
                                tenantData.orders.forEach(function(order) {
                                    var orderHtml = '<div class="row">' +
                                        '<div class="col-8">' + order.jumlah + ' ' + order.nama_menu + '</div>' +
                                        '<div class="col-4">' + "Rp. " + order.harga + '</div>' +
                                        '</div>';
                                    tenantHtml += orderHtml;
                                    totals += parseInt(order.harga);
                                });
                                var tot = '<div class="row mt-2">' +
                                    '<div class="col-12 d-flex justify-content-end">' +
                                    '<div class="total-container">' +
                                    '<span class="total-text">Rp. ' + totals + '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                tenantHtml += tot;
                                tenantHtml += '<button type="button" class="btn btn-sm btn-primary  me-3" onclick="cash(' + tenantData.tenant_id + ')">Cash</button>';
                                tenantHtml += '<button type="button" class="btn btn-sm btn-primary pe-2 ps-2"  onclick="qris(' + tenantData.tenant_id + ')">Qris</button>';
                                tenantHtml += '</div>';
                                allTenantsHtml += tenantHtml;
                            }
                        }

                        $('#data').html(allTenantsHtml);
                    }

                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'GAGAL',
                        text: 'Terjadi kesalahan saat mendapatkan data.' + response,
                    });
                }
            });
        }



        function bersih() {
            $('#jumlah').val('0'); // Set input value to empty string
            $('#catatan').val('');
            // $('#modalMenuImage').hide();
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
                        icon: 'success',
                        type: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    bersih();
                    $('#exampleModal').modal('hide');
                },
                error: response => {
                    Swal.fire({
                        icon: 'error',
                        title: 'GAGAL',
                        text: 'Terjadi kesalahan saat menyimpan data.' + response.message,
                    });
                }

            });
        }

    });



    //open modal qris
    function qris(tenantId) {
        $('#qrisModal').modal('show');
        $.ajax({
            url: "{{ route('tenant.byid') }}",
            method: "GET",
            data: {
                id_tenant: tenantId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                var $path = $('#url_any').val() + "privates/";
                $('#modalQris').attr('src', $path + response.qrcode_image);
                $('#id_tenant_qr').text(tenantId);
                $('#modal_nama_tenant').text(response.nama_kantin);

            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'GAGAL',
                    text: 'Terjadi kesalahan saat membuka .' + response.message,
                });
            }
        });
        // $('#billModal').modal('hide');

        // $('#billModal').modal('hide');
    }

    //Pembayaran melalui mode qris
    function sendQris() {
        var tenantId = $('#id_tenant_qr').text();
        if (tenantId != "") {
            const fileInput = document.getElementById('nama_gbr_qr');
            const file = fileInput.files[0];
            if (!file) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Wajib mengupload bukti bayar.',
                });
                return;
            }

            if (fileInput.files.length > 0) {
                const formData = new FormData();
                formData.append('jenis_bayar', "qris");
                formData.append('id_tenant', tenantId);
                formData.append('qrcode', file); // Gunakan nama 'file' yang sesuai dengan server
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('pesanan.konfirmasi') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#billModal').modal('hide');
                        $('#qrisModal').modal('hide');
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'GAGAL',
                            text: 'Terjadi kesalahan saat mengkonfirmasi pesanan.' + response.message,
                        });
                    }
                });
            }
        }
    }

    //Pembayaran melalui mode cash
    function cash(tenantId) {
        if (tenantId != "") {
            $.ajax({
                url: "{{ route('pesanan.konfirmasi') }}",
                method: "POST",
                data: {
                    jenis_bayar: "cash",
                    id_tenant: tenantId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    $('#billModal').modal('hide');
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'GAGAL',
                        text: 'Terjadi kesalahan saat mengkonfirmasi pesanan.' + response.message,
                    });
                }
            });
        }
    }
</script>
