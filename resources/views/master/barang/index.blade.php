@extends('layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="#" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#addbarang">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Barang</span>
        </a>
        <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered general-datatable" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%">No.</th>
                        <th style="width:10%">Kode Item</th>
                        <th style="width:20%">Nama Item</th>
                        <th style="width:10%">Available Date</th>
                        <th style="width:15%">Harga Item</th>
                        <th style="width:10%">Berat (Kg)</th>
                        <th style="width:15%">Kategori Item</th>
                        <th style="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$barangs as $barang )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->kode_item }}</td>
                        <td class="text-center">{{ $barang->nama_item}}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($barang->available_date)) }}</td>
                        <td class="text-center">{{ number_format($barang->harga_item, 2)}}</td>
                        <td class="text-center">{{ $barang->berat_kg}}</td>
                        <td class="text-center">{{ $barang->kategori->nama_kategori}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editbarang" data-id='{{ $barang->id }}' data-kode-item='{{ $barang->kode_item }}' data-nama-item='{{ $barang->nama_item }}' data-available='{{ $barang->available_date }}' data-harga='{{ $barang->harga_item }}' data-berat='{{ $barang->berat_kg }}' data-kategori='{{ $barang->id_kategori }}'><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="btn-group">
                                {{ Form::open(['route' => ['master.barang.destroy', $barang->id], 'class' => 'm-0']) }}
                                @method('DELETE')
                                <a href="#" class="btn btn-sm btn-danger align-items-center show_confirm" data-bs-toggle="tooltip" data-bs-original-title="Delete" aria-label="Delete" data-confirm-yes="delete-form"><i class="fa fa-trash text-white text-white"></i></a>
                                {{ Form::close() }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('master.barang.create')
@include('master.barang.edit')
@endsection
@section('script')
<script>
    $('#editbarang').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var kode_item = button.data('kode-item')
    var nama_item = button.data('nama-item')
    var available = button.data('available')
    var harga = button.data('harga')
    var berat = button.data('berat')
    var kategori = button.data('kategori')
    var modal = $(this)

    modal.find(".modal-body input[name='kode_item']").val(kode_item)
    modal.find(".modal-body input[name='nama_item']").val(nama_item)
    modal.find(".modal-body input[name='available_date']").val(available)
    modal.find(".modal-body input[name='harga_item']").val(harga)
    modal.find(".modal-body input[name='berat_kg']").val(berat)
    modal.find(".modal-body select[name='id_kategori']").val(kategori)
    modal.find(".modal-body form").attr("action",'/master/barang/update/'+id)
    })
</script>
@endsection