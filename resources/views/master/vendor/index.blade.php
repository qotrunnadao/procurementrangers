@extends('layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="#" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#addvendor">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Vendor</span>
        </a>
        <h6 class="m-0 font-weight-bold text-primary">Data Vendor</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered general-datatable" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%">No.</th>
                        <th style="width:10%">Kode Vendor</th>
                        <th style="width:15%">Nama Vendor</th>
                        <th style="width:20%">Alamat Vendor</th>
                        <th style="width:15%">Email</th>
                        <th style="width:15%">Telp</th>
                        <th style="width:10%">Nama Bank</th>
                        <th style="width:15%">No. rek</th>
                        <th style="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$vendors as $vendor )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $vendor->kode_vendor }}</td>
                        <td>{{ $vendor->nama_vendor }}</td>
                        <td>{{ $vendor->alamat_vendor }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td class="text-center">{{ $vendor->telepon}}</td>
                        <td class="text-center">{{ $vendor->bank->nama_bank }}</td>
                        <td>{{ $vendor->nomor_rekening }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editvendor" data-id='{{ $vendor->id }}' data-kode-vendor='{{ $vendor->kode_vendor }}' data-nama-vendor='{{ $vendor->nama_vendor }}' data-alamat-vendor='{{ $vendor->alamat_vendor }}' data-email='{{ $vendor->email }}' data-telepon='{{ $vendor->telepon }}' data-bank='{{ $vendor->id_bank }}' data-rekening='{{ $vendor->nomor_rekening }}'><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="btn-group">
                                {{ Form::open(['route' => ['master.vendor.destroy', $vendor->id], 'class' => 'm-0']) }}
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
@include('master.vendor.create')
@include('master.vendor.edit')
@endsection
@section('script')
<script>
    $('#editvendor').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var kode_vendor = button.data('kode-vendor')
    var nama_vendor = button.data('nama-vendor')
    var alamat_vendor = button.data('alamat-vendor')
    var email = button.data('email')
    var telepon = button.data('telepon')
    var bank = button.data('bank')
    var nomor_rekening = button.data('rekening')
    var modal = $(this)

    modal.find(".modal-body input[name='kode_vendor']").val(kode_vendor)
    modal.find(".modal-body input[name='nama_vendor']").val(nama_vendor)
    modal.find(".modal-body textarea[name='alamat_vendor']").val(alamat_vendor);
    modal.find(".modal-body input[name='email']").val(email)
    modal.find(".modal-body input[name='telepon']").val(telepon)
    modal.find(".modal-body select[name='id_bank']").val(bank)
    modal.find(".modal-body input[name='nomor_rekening']").val(nomor_rekening)
    modal.find(".modal-body form").attr("action",'/master/vendor/update/'+id)
    })
</script>
@endsection