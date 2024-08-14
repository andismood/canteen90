@extends('admin.layout.main')

@section('title', '')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Harap cek Pesanan Anda</h6>
            </div>
            <div class="card-body">
                <div class="row bill">
                    <div class="container text-center">
                        <div class="row judul">
                            <Label>Canteen Connect</Label>
                        </div>
                        <div class="row content">
                            <Label id="nama_member">Nama : {{$user->nama_member}}</Label>
                        </div>
                        <div class="row content mb-3">
                            <Label id="kelas">Kelas : {{$kelas->id_kelas}}</Label>
                        </div>
                        <div class="row warning mb-1">
                            <Label>Tolong Cek Kembali Pesanan Anda</Label>
                        </div>
                    </div>
                    <hr>

                    @if($tenants->isEmpty())
                    <p>No orders found for the specified user.</p>
                    @else
                    @foreach($tenants as $tenant)
                    <div class="tenant-container mb-4">
                        <h4>{{ $tenant->nama_kantin }}</h4>

                        @php
                        $totals = 0;
                        @endphp

                        @foreach($tenant->menus as $menu)
                        @foreach($menu->pesanan as $pesananItem)
                        @if($pesananItem->id_user == "1234")
                        @php
                        $totals += $pesananItem->total_harga;
                        @endphp
                        <div class="row">
                            <div class="col-8">{{ $pesananItem->jumlah }} {{ $menu->nama_menu }}</div>
                            <div class="col-4">Rp. {{ number_format($pesananItem->total_harga, 0, ',', '.') }}</div>
                        </div>
                        @endif
                        @endforeach
                        @endforeach

                        <div class="row mt-2">
                            <div class="col-8"></div>
                            <div class="col-4">
                                <span class="text-white bg-success ps-2 pe-2 bordered-span">
                                    Total Rp. {{ number_format($totals, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-primary me-3" onclick="cash({{ $tenant->id }})">Cash</button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="qris({{ $tenant->id }})">Qris</button>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>


</div>
@endsection
