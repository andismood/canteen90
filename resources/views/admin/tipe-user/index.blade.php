@extends('admin.layout.main')

@section('title', 'Data Tipe User')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Tipe User</h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Tipe User</th>
                                <th>Nama Tipe User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($no = 1)
                            @foreach ($data as $row)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $row->id_type_user }}</td>
                                <td>{{ $row->nama_type_user }}</td>

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
