@extends('admin.layout.main')

@section('title', 'Data Jenis Menu')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Jenis Menu</h6>
            </div>
            <div class="card-body">
                <a href="{{route('jenis-menu.tambah')}}" class="btn btn-primary mb-3">Tambah</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Jenis Menu</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php($no = 1)
                            @foreach ($data as $row)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $row->nama_jenis_menu }}</td>
                                <td>
                                    <a href="{{ route('jenis-menu.edit', $row->id_jenis_menu) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('jenis-menu.hapus', $row->id_jenis_menu) }}" class="btn btn-danger">Hapus</a>
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
@endsection
