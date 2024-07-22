@extends('admin.layout.main')

@section('title', 'Data Tenant')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Tenant</h6>
            </div>
            <div class="card-body">
                <a href="{{route('tenant.tambah')}}" class="btn btn-primary mb-3">Tambah</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tenant</th>
                                <th>Nama Kantin</th>
                                <th>User Login</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php($no = 1)
                            @foreach ($data as $row)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $row->nama_tenant }}</td>
                                <td>{{ $row->nama_kantin }}</td>
                                <td>{{ $row->id_user }}</td>
                                <td>
                                    <a href="{{ route('tenant.edit', $row->id_tenant) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('tenant.hapus', $row->id_tenant) }}" class="btn btn-danger">Hapus</a>
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
