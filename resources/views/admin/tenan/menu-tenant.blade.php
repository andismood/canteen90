@extends('admin.layout.main')

@section('title', 'Data Tenant')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Tenant</h6>
            </div>
            <div class="card-body">

                <div class="portfolio">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-2">
                            <img src=" {{ $data[0]->url_gambar }}" alt="{{ $data[0]->nama_tenant }}">
                        </div>
                        <div class="col-sm-6 ">
                            <div class="row">
                                <h3> {{$data[0]->nama_kantin}}</h3>
                            </div>
                        </div>
                    </div>
                    <hr>

                    @foreach ($data as $row)
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2">
                            <img src="{{ $row->nama_gambar }}" alt="{{ $row->nama_menu }}" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="p-2">
                            {{ $row->nama_jenis_menu }}<br>
                            <span class="text-white bg-success ps-2 pe-2">Rp. {{$row->harga_jual}}</span><br>
                            <button type="button" class="btn btn-outline-info mt-2" id="{{$row->id_menu}}" id2="{{$row->id_tenant}}" data-bs-toggle="modal" data-bs-target="#exampleModal">Pesan</button>

                        </div>

                    </div>
                    <hr>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


</div>

<div class="modal fade" tabindex="-1" id="exampleModal" data-bs-backdrop="static" aria-hidden="true">
    <div class=" modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Menu Makanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-3">
                            <img id="modalMenuImage" src="" alt="Gambar Menu" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="col-6">
                            <input type="hidden" id="id_menu" name="id_menu" />
                            <input type="hidden" id="id_tenant" name="id_tenant" />
                            <h4 id="modalMenuName" name="modal_nama_menu">Nama Menu</h4>
                            <h4 id="modalMenuPrice" name="modal_harga_jual">Harga Menu</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control form-control-sm" id="jumlah" name="jumlah">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="catatan" name="catatan">
                            </div>
                        </div>

                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#image-thumbnail').click(function() {
            window.alert("image");
        });
    });
</script>
