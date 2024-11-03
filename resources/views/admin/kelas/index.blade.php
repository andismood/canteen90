@extends('admin.layout.main')
@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Data Kelas</h6>
            </div>
            <div class="card-body">
                <a href="{{route('kelas.tambah')}}" class="btn btn-sm btn-success mb-3">Tambah</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Keterangan Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($no = 1)
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->id_kelas }}</td>
                                <td>{{ $row->nama_kelas }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td>
                                    <a href="{{ route('kelas.edit', $row->id_kelas) }}" class="btn btn-sm btn-warning">Ubah</a>
                                    <a href="{{ route('kelas.hapus', $row->id_kelas) }}" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection
