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
                                        <th><i>Tenant</i></th>
                                        <th>Kalori</th>
                                        <th>Status</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                {{-- $row->id_jenis_menu == 1 it's 'makanan', if 4 then it's 'minuman' --}}
                                {{-- $row->status_menu == 0 it's 'Tersedia', if 1 then it's 'Habis', if 2 then it's 'Tidak Tersedia' --}}
                                <tbody style="vertical-align: middle;">
                                    @php($no = 1)
                                    @foreach ($data as $row)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <td>{{ $row->nama_menu }}</td>
                                        <td>{{ $row->id_jenis_menu == 1 ? 'makanan' : 'minuman' }}</td>
                                        <td>{{ 'Rp' . number_format($row->harga_jual, 0, ',', '.') }}</td>
                                        <td>{{ $row->nama_tenant }}</td>
                                        <td>{{ $row->nama_kantin }}</td>
                                        <td>{{ $row->kalori }}</td>
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
