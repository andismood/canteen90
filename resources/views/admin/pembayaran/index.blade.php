@extends('admin.layout.main')

@section('title', '')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Harap Konfirmasi Pesanan </h6>
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
                                    <input class="form-control form-control-sm" type="date" id="tgl" name="tgl" value="{{ empty($tgl) ? 'Y-d-m' : $tgl  }}">
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
                                        <th>TENANT</th>
                                        <th>KONFIRMASI</th>
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
                                        <td>{{ "Rp. ".$row->total_bayar }}</td>
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
                                            @if($row->status_bayar === "0")
                                            <span class="text-black bg-warning ps-2 pe-2 py-1" style="border-radius: 20px">BELUM</span>
                                            @else
                                            <span class="text-white bg-success ps-2 pe-2 py-1" style="border-radius: 20px">SUDAH</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if(auth()->user()->id_type_user != "mbr")
                                            <small type="button" class="btn btn-sm btn-outline-dark aksi" transaksi="{{$row->no_transaksi}}" sts="{{$row->status_bayar}}">konfirmasi</small>
                                            @endif
                                            <small type="button" class="btn btn-sm btn-outline-primary m-1 detail-pesanan" transaksi="{{$row->no_transaksi}}" use="{{$row->id_member}}" tenan=" {{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#detailModal">Detail</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if($data->hasPages())
            <div class="card-footer">
                {{ $data->links() }}
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

        $('.aksi').click(function() {
            var sts = $(this).attr('sts');
            if (sts == 1) {
                return Swal.fire({
                    position: "top-center",
                    icon: "warning",
                    title: "Informasi",
                    text: "Data sudah terkonfirmasi",
                    showConfirmButton: false,
                    timer: 1900
                });
            }
            var idTransaksi = $(this).attr('transaksi');
            Swal.fire({
                title: 'Apakah anda ingin',
                text: "mengkonfirmasi ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
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

                        $('#modal-date').text(response.tanggal);
                        $('#nama_member').text("Nama : " + response.nama_member);
                        $('#kelas').text("kelas : " + response.id_kelas);
                        $('#keterangan').text(response.keterangan);
                        var orderHtml = "";
                        var orders = [];
                        response.pesanan.menus.forEach(function(menu) {
                            menu.pesanan.forEach(function(order) {
                                orders.push({
                                    jumlah: order.jumlah,
                                    nama_menu: menu.nama_menu,
                                    harga: order.total_harga
                                })

                            })
                        });
                        var allTenantsHtml = '';
                        orders.forEach(function(order) {
                            var orderHtml = '<div class="row">' +
                                '<div class="col-8">' + order.jumlah + ' ' + order.nama_menu + '</div>' +
                                '<div class="col">' + "Rp. " + order.harga + '</div>' +
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
                        text: 'error saat konfirmasi data karena ' + error
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
