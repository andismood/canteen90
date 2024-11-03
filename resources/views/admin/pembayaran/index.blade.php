@extends('admin.layout.main')

@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Harap Konfirmasi Pembayaran Pesanan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.bayar') }}" method="GET">
                    @csrf
                    <div class="row mb-1 mt-2">
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="tgl" class="form-label">Tanggal: </label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input class="form-control form-control-sm" type="date" id="tgl" name="tgl" value="{{ empty($tgl) ? date('Y-m-d') : $tgl  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col detail">
                                    <div class="form-group">
                                        <label for="flag" class="form-label">Status:</label>
                                        <select id="flag" name="flag" class="form-select form-select-sm" style="max-width: 200px;">
                                            <option value="" {{ empty($flag) ? 'selected' : '' }}>-- Pilih Status --</option>
                                            <option value="0" {{ $flag === "0" ? 'selected' : '' }}>Belum Konfirmasi</option>
                                            <option value="1" {{ $flag === "1" ? 'selected' : '' }}>Sudah Konfirmasi</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm ms-2">Cari</button>
                                        <!-- <small type="submit" class="btn btn-primary btn-sm ms-2">Cari</small> -->
                                        <!-- <a href="{{ route('pesanan.bayar') }}" id="cari" type="button" class="btn btn-primary btn-sm ms-2">Cari</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="rxjs-table">
                    <div className="rxjs-table-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%; text-align: center; border-collapse: collapse;font-family: 'Arial', sans-serif; font-size: 14px;" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>NAMA</th>
                                        <th>KELAS</th>
                                        <th>T. BAYAR</th>
                                        <th>JENIS</th>
                                        <th><I>TENANT</I></th>
                                        <th>KONFIRMASI</th>
                                        <th><I>PICK UP</I></th>
                                        <th>WAKTU</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle; font-family: 'Arial', sans-serif; font-size: 14px;">
                                    @php($no = 1)
                                    @foreach ($data as $row)
                                    <tr>

                                        <th>{{ $no++ }}</th>
                                        <td>{{ $row->id_member }}</td>
                                        <td>{{ $row->nama_member }}</td>
                                        <td>{{ $row->id_kelas }}</td>
                                        <td>{{ "Rp" . number_format($row->total_bayar, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($row->jenis_bayar === 'qris')
                                            <a href="#" class="view-image" image-url="{{URL::asset('/gambar-qris/'. $row->qrcode) }}" data-bs-toggle="modal" data-bs-target="#qrisModal">
                                                <i class="fas fa-eye"></i> {{ $row->jenis_bayar }}
                                            </a>
                                            @else
                                            {{ $row->jenis_bayar }}
                                            @endif
                                        </td>
                                        <td>{{ $row->nama_kantin }}</td>
                                        <td>
                                            @if($row->status_bayar === true)
                                            <span class="text-white bg-success ps-2 pe-2 py-1" style="border-radius: 20px">SUDAH</span>
                                            @else
                                            <span class="text-black bg-warning ps-2 pe-2 py-1" style="border-radius: 20px">BELUM</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if($row->pick_up != "")
                                            <span class="text-white bg-success ps-2 pe-2 py-1" style="border-radius: 20px">SUDAH</span>
                                            @else
                                            <span class="text-black bg-warning ps-2 pe-2 py-1" style="border-radius: 20px">BELUM</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-black ps-2 pe-2 py-1" style="border-radius: 20px">{{$row->pick_up}}</span>
                                        </td>
                                        <td>
                                            @if(auth()->user()->id_type_user != "mbr")
                                            <small type="button" class="btn btn-sm btn-outline-warning pickup me-1" transaksi="{{$row->no_transaksi}}" wkt="{{$row->pick_up}}"><i>pick up</i></small>
                                            <small type="button" class="btn btn-sm btn-outline-dark aksi" transaksi="{{$row->no_transaksi}}" sts="{{$row->status_bayar}}">konfirmasi</small>
                                            @endif
                                            <small type="button" class="btn btn-sm btn-outline-primary m-1 detail-pesanan" transaksi="{{$row->no_transaksi}}" use="{{$row->id_member}}" tenan=" {{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#detailModal">detil</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if($data->total() > 0)
            <div class="form-label"><label for="pagination-info" class="form-label" style="margin-left: 15px;">
                Menampilkan data ke-{{ $data->firstItem() }} hingga ke-{{ $data->lastItem() }} dari total {{ $data->total() }} data
                </label>
            </div>
            @endif
            @if($data->hasPages())
            <div class="card-footer">
                {{ $data->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>


    <!-- modal detail menu -->
    <div class="modal fade" tabindex="-1" id="detailModal" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- <form action="" method=""> -->
                <div class="modal-body ">

                    <div class="row bill">
                        <div class="container text-center">
                            <div class="row judul">
                                <Label>Canteen Connect</Label>
                            </div>
                            <div class="row content">
                                <Label id="nama_member">Nama : </Label>
                            </div>
                            <div class="row content">
                                <Label id="kelas">Kelas : </Label>
                            </div>
                            <div class="row content mb-1">
                                <Label id="keterangan">Pesanan Anda</Label>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="data">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span id="modal-date" class="text-muted" style="font-size:12px"> {{ date('d-m-Y') }}</span>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
                <!-- </form> -->
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
                            <img class="qrimageTenent" id="hasilQris" src="" alt="Gambar ">
                        </div>
                        <div class="row">
                            <input type="hidden" id="qr-result" name="qr-result" />
                            <!-- <h4 id="modal_nama_tenant" name="modal_nama_tenant"></h4> -->
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-sm-12">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <!-- <button type="button" onclick="sendQris()" class="btn btn-sm btn-primary ">Pesan</button> -->
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.pickup').click(function() {
            var wkt = $(this).attr('wkt');
            if (wkt != "") {
                return Swal.fire({
                    position: "top-center",
                    icon: "warning",
                    title: "Pengambilan Pesanan",
                    text: "Pesanan sudah diambil",
                    showConfirmButton: false,
                    timer: 1900
                });
            }
            var idTransaksi = $(this).attr('transaksi');
            Swal.fire({
                title: 'Pengambilan Pesanan',
                text: "Apakah pembeli ingin mengambil pesanannya?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pesanan.pickup') }}",
                        method: "POST",
                        data: {
                            no_transaksi: idTransaksi,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-center",
                                    icon: "success",
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1900
                                });
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    position: "top-center",
                                    icon: 'error',
                                    width: 300,
                                    title: 'GAGAL',
                                    text: 'Error konfirmasi pengambilan pesanan'
                                });
                            }

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                width: 300,
                                title: 'GAGAL',
                                text: 'error saat konfirmasi pengambilan pesanan karena ' + error
                            });
                        }
                    });
                }
            });


        })

        $('.aksi').click(function() {
            var sts = $(this).attr('sts');
            if (sts == 1) {
                return Swal.fire({
                    position: "top-center",
                    icon: "warning",
                    title: "Konfirmasi Pembayaran",
                    text: "Pembayaran sudah terkonfirmasi",
                    showConfirmButton: false,
                    timer: 1900
                });
            }
            var idTransaksi = $(this).attr('transaksi');
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: "Apakah pembayaran pesanan ini sudah diterima?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pesanan.lunas') }}",
                        method: "POST",
                        data: {
                            no_transaksi: idTransaksi,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-center",
                                    icon: "success",
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1900
                                });
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    position: "top-center",
                                    icon: 'error',
                                    width: 300,
                                    title: 'GAGAL',
                                    text: 'Error konfirmasi data'
                                });
                            }

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                width: 300,
                                title: 'GAGAL',
                                text: 'error saat konfirmasi data karena ' + error
                            });
                        }
                    });
                }
            });


        })

        $('.detail-pesanan').click(function() {
            var idTransaksi = $(this).attr('transaksi');
            var idTenant = $(this).attr('tenan');
            var member = $(this).attr('use');
            $.ajax({
                url: "{{ route('pesanan.detail') }}",
                method: "GET",
                data: {
                    id_member: member,
                    no_transaksi: idTransaksi,
                    id_tenant: idTenant,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {

                        $('#modal-date').text("Pesanan dibuat pada "+response.tanggal);
                        $('#nama_member').text("Nama : " + response.nama_member);
                        $('#kelas').text("Kelas : " + response.id_kelas);
                        $('#keterangan').text(response.keterangan);
                        var orderHtml = "";
                        var orders = [];
                        response.pesanan.menus.forEach(function(menu) {
                            menu.pesanan.forEach(function(order) {
                                orders.push({
                                    jumlah: order.jumlah,
                                    nama_menu: menu.nama_menu,
                                    harga: order.total_harga,
                                    catatan_menu: order.catatan_menu
                                })

                            })
                        });
                        var allTenantsHtml = '';
                        orders.forEach(function(order) {
                            var formattedHarga = Number(order.harga).toLocaleString('id-ID');
                            var catatanMenu = order.catatan_menu ? order.catatan_menu : '-';
                            var orderHtml = '<div class="row">' +
                                '<div class="col-8">' + order.jumlah + 'x ' + order.nama_menu + '</div>' +
                                '<div class="col">' + "Rp" + formattedHarga + '</div>' +
                                '<div class="col-8" style="font-size:12px">Catatan: ' + catatanMenu + '</div>' +
                                '</div>';
                            allTenantsHtml += orderHtml;
                        });
                        $('#data').html(allTenantsHtml);
                    } else {
                        Swal.fire({
                            position: "top-center",
                            icon: 'error',
                            width: 300,
                            title: 'GAGAL',
                            text: response.message
                        });
                    }

                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        width: 300,
                        title: 'GAGAL',
                        text: 'error detail pesanan ' + error
                    });
                }
            });


        })

        $('.view-image').click(function() {
            var $path = $(this).attr('image-url');
            $('#hasilQris').attr('src', $path);
        });


    });
</script>
