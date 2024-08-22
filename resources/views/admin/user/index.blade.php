@extends('admin.layout.main')
@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Data Pengguna</h6>
            </div>
            <div class="card-body">
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode </th>
                                <th>Nama </th>
                                <th>Tipe Pengguna</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php($no = 1)
                            @foreach ($data as $row)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $row->id_user }}</td>
                                <td>{{ $row->nama_user }}</td>
                                <td>{{ $row->nama_type_user }}</td>
                                <td>
                                    <a href="{{ route('user.reset', $row->id_user) }}" class="btn btn-sm btn-warning">Ganti kata sandi</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($data->hasPages())
            <div class="card-footer">
                {{ $data->links() }}
            </div>
            @endif
        </div>
    </div>


</div>
@endsection
