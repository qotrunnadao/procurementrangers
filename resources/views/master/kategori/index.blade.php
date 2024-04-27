@extends('layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="#" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#addkategori">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Kategori</span>
        </a>
        <h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered general-datatable" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%">No.</th>
                        <th style="width:40%">Kategori Barang</th>
                        <th style="width:15%">Deskripsi</th>
                        <th style="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$kategoris as $kategori )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td class="text-center">{{ $kategori->deskripsi}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editkategori" data-id='{{ $kategori->id }}' data-nama-kategori='{{ $kategori->nama_kategori }}' data-deskripsi='{{ $kategori->deskripsi }}'><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="btn-group">
                                {{ Form::open(['route' => ['master.kategori.destroy', $kategori->id], 'class' => 'm-0']) }}
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
@include('master.kategori.create')
@include('master.kategori.edit')
@endsection
@section('script')
<script>
    $('#editkategori').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var nama_kategori = button.data('nama-kategori')
    var deskripsi = button.data('deskripsi')
    var modal = $(this)

    modal.find(".modal-body input[name='nama_kategori']").val(nama_kategori)
    modal.find(".modal-body input[name='deskripsi']").val(deskripsi)
    modal.find(".modal-body form").attr("action",'/master/kategori/update/'+id)
    })
</script>
@endsection