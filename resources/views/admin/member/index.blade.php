@extends('admin.layout.main')

@section('title', 'Data Member')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Member</h6>
            </div>
            <div class="card-body">
                <a href="{{route('member.tambah')}}" class="btn btn-primary mb-3">Tambah</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Member</th>
                                <th>Nama Member</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php($no = 1)
                            @foreach ($data as $row)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $row->id_member }}</td>
                                <td>{{ $row->nama_member }}</td>
                                <td>
                                    <a href="{{ route('member.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('member.hapus', $row->id) }}" class="btn btn-danger">Hapus</a>
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
