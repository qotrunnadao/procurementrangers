@extends('layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="#" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#addbank">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Bank</span>
        </a>
        <h6 class="m-0 font-weight-bold text-primary">Data Bank</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered general-datatable" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%">No.</th>
                        <th style="width:40%">Nama Bank</th>
                        <th style="width:15%">Kode Bank</th>
                        <th style="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$banks as $bank )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bank->nama_bank }}</td>
                        <td class="text-center">{{ $bank->kode_bank }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editbank" data-id='{{ $bank->id }}' data-nama-bank='{{ $bank->nama_bank }}' data-kode-bank='{{ $bank->kode_bank }}'><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="btn-group">
                                {{ Form::open(['route' => ['master.bank.destroy', $bank->id], 'class' => 'm-0']) }}
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
@include('master.bank.create')
@include('master.bank.edit')
@endsection
@section('script')
<script>
    $('#editbank').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var nama_bank = button.data('nama-bank')
    var kode_bank = button.data('kode-bank')
    var modal = $(this)

    modal.find(".modal-body input[name='nama_bank']").val(nama_bank)
    modal.find(".modal-body input[name='kode_bank']").val(kode_bank)
    modal.find(".modal-body form").attr("action",'/master/bank/update/'+id)
    })
</script>
@endsection