@extends('admin.layout.main')

@section('title', 'Data Pesanan')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Harap Konfirmasi Pesanan Anda</h6>
            </div>
            <div class="card-body">
                <a href="" class="btn btn-success mb-3">Konfirmasi Pesanan</a>
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
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle;">
                                    @php($no = 1)
                                    @foreach ($data as $row)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <td>{{ $row->nama_menu }}</td>
                                        <td>{{ $row->harga_jual }}</td>
                                        <td>{{ $row->jumlah }}</td>
                                        <td>{{ $row->total_harga }}</td>

                                        <td>
                                            <a href="" class="btn btn-warning m-1">Edit</a>
                                            <a href="" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
