@extends('admin.layout.main')

@section('title', 'Halo '.$nama .' ('.$tipe->nama_type_user.')')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header bg-success py-3">
                <h6 class="m-0 font-weight-bold text-white">Data Menu</h6>
            </div>
            <div class="card-body">
                <a href="{{route('menu.tambah')}}" class="btn btn-sm btn-success mb-3">Tambah</a>
                <div class="rxjs-table">
                    <div className="rxjs-table-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%; text-align: center; border-collapse: collapse;" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        <th>Jenis Menu</th>
                                        <th>Harga</th>
                                        <th>Pemilik</th>
                                        <th>Tenant</th>
                                        <th>Status</th>
                                        <th>gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle;">
                                    @php($no = 1)
                                    @foreach ($data as $row)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <td>{{ $row->nama_menu }}</td>
                                        <td>{{ $row->id_jenis_menu == 1 ? 'makanan' : 'minuman' }}</td>
                                        <td>{{ $row->harga_jual }}</td>
                                        <td>{{ $row->nama_tenant }}</td>
                                        <td>{{ $row->nama_kantin }}</td>
                                        <td>
                                            @if($row->status_menu == 0)
                                            Tersedia
                                            @elseif($row->status_menu == 1)
                                            Habis
                                            @else
                                            Tidak Tersedia
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ URL::asset('/images/'.$row->nama_gambar) }}" alt="{{ $row->nama_menu }}" style="max-width: 80px; max-height: 80px;">
                                        </td>

                                        <td>
                                            <a href="{{ route('menu.edit', $row->id_menu) }}" class="btn btn-sm btn-warning m-1">Ubah</a>
                                            @if(auth()->user()->id_type_user === "adm")
                                            <a href="{{ route('menu.hapus', $row->id_menu) }}" class="btn btn-sm btn-danger">Hapus</a>
                                            @endif
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


</div>
@endsection
