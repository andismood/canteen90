@extends('admin.layout.main')

@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Data Siswa</h6>
            </div>
            <div class="card-body">
                <a href="{{route('member.tambah')}}" class="btn btn-sm btn-success mb-3">Tambah</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>ID Kelas</th>
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
                                <td>{{ $row->id_kelas}}</td>
                                <td>
                                    <a href="{{ route('member.edit', $row->id_member) }}" class="btn btn-sm btn-warning">Ubah</a>
                                    <a href="{{ route('member.hapus', $row->id_member) }}" class="btn btn-sm btn-danger">Hapus</a>
                                    {{-- TODO: Tombol Hapus harus menampilkan konfirmasi bahwa data akan dihapus --}}
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
