@extends('admin.layout.main')

@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Harap Periksa Pesanan Anda</h6>
            </div>
            <div class="card-body">
                <!-- <a href="" class="btn btn-success mb-3">Konfirmasi Pesanan</a> -->

                <div class="rxjs-table">
                    <div className="rxjs-table-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%; text-align: center; border-collapse: collapse;" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total Pembayaran</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle;">
                                    @php($no = 1)
                                    @foreach ($data as $row)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <td>{{ $row->nama_menu }}</td>
                                        <td>{{ 'Rp' . number_format($row->harga_jual, 0, ',', '.') }}</td>
                                        <td>{{ $row->jumlah }}</td>
                                        <td>{{ 'Rp' . number_format($row->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $row->catatan_menu }}</td>
                                        <td class="hps">
                                            <!-- <a href="" class="btn btn-sm btn-warning m-1">Edit</a> -->
                                            <!-- <a href="" class="btn btn-sm btn-danger">Hapus</a> -->
                                            <small class="btn btn-sm btn-danger px-2" data-tnt="{{$row->id_tenant}}" data-mn="{{$row->id_menu}}">Hapus</small>
                                            {{-- TODO: Add 'ubah' button to edit order, instead of deleting order and create a correct order --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-inline-flex py-2">

                            <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary px-3 mx-2">Kembali</a>

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
                    {{ $data->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>


</div>
@endsection

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.hps .btn', function() {
            var id_menu = $(this).data('mn');
            var id_tenant = $(this).data('tnt');
            Swal.fire({
                title: 'Peringatan',
                text: "Apakah Anda yakin untuk menghapus pesanan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pesanan.hapus') }}",
                        method: "DELETE",
                        data: {
                            id_menu: id_menu,
                            id_tenant: id_tenant,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                position: "top-center",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1900
                            });
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'An unknown error occurred.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                errorMessage = xhr.responseText;
                            }
                            Swal.fire({
                                icon: 'error',
                                width: 300,
                                title: 'GAGAL',
                                text: errorMessage
                            });
                        }
                    });
                }
            });

        });
    });
</script>
