@extends('layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-icon-split float-right">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Transaksi</span>
        </a>
        <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered general-datatable" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%">No.</th>
                        <th style="width:10%">Kode Transaksi</th>
                        <th style="width:15%">Tanggal Transaksi</th>
                        <th style="width:20%">Kode Item</th>
                        <th style="width:15%">Nama Item</th>
                        <th style="width:15%">Qty</th>
                        <th style="width:10%">Total Harga</th>
                        <th style="width:15%">Total Harga + ppn</th>
                        <th style="width:15%">Nama order</th>
                        <th style="width:15%">Email</th>
                        <th style="width:15%">Nama Bank</th>
                        <th style="width:15%">Nomor Rekening</th>
                        <th style="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$transaksi as $order )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->kode_transaksi }}</td>
                        <td>{{ date('d/m/Y', strtotime($order->tanggal_transaksi)) }}</td>
                        <td>{{ $order->kode_item }}</td>
                        <td>{{ $order->nama_item }}</td>
                        <td class="text-center">{{ $order->kuantitas}}</td>
                        <td class="text-center">{{number_format($order->total_harga, 2) }}</td>
                        <td>{{ number_format($order->total_harga_ppn, 2) }}</td>
                        <td>{{ $order->nama_vendor }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->nama_bank }}</td>
                        <td>{{ $order->nomor_rekening }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                {{ Form::open(['route' => ['transaksi.destroy', $order->id], 'class' => 'm-0']) }}
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
@endsection