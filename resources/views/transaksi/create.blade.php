@extends('layouts.main')
@section('content')
{{ Form::open(['route' => 'transaksi.store', 'id' => 'form-transaksi']) }}
@csrf
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Transaksi</label>
                            <input type="text" class="form-control" name="kode_transaksi" id="kode_transaksi" value="{{ old('kode_transaksi') ? old('kode_transaksi') : 'TRX-'.time() }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            {{ Form::date('tanggal_transaksi', old('tanggal_transaksi', date('Y-m-d')), [
                            'class' => 'form-control',
                            'id' => 'tanggal_transaksi', 'readonly', 'required'
                            ]) }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Item / Barang</label>
                            <select class="form-control select2" name="barang" id="barang" style="width:100%" onchange="getDetailBarang()" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}|{{ $barang->harga_item }}" {{ old('id_barang')==$barang->id ? 'selected' : '' }}>
                                    {{ $barang->kode_item }} - {{ $barang->nama_item }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="hidden" name="id_barang" id="id_barang" value="{{ old('id_barang') }}">
                            <label>Harga Satuan</label>
                            <input type="text" name="harga_item" id="harga_item" class="form-control money" value="{{ old('harga_item') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kuantitas</label>
                            <div class="form-group input-group">
                                <input type="number" name="kuantitas" id="kuantitas" class="form-control" oninput="totalHarga()" value="{{ old('kuantitas') }}" required>
                                <span class="input-group-text">pcs</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Harga</label>
                            <input type="text" name="total_harga" id="total_harga" class="form-control money" value="{{ old('total_harga') }}" required readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Harga (Include PPN 11%)</label>
                            <input type="text" name="total_harga_ppn" id="total_harga_ppn" class="form-control money" value="{{ old('total_harga_ppn') }}" required readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Vendor</label>
                            <select class="form-control select2" name="vendor" id="vendor" style="width:100%" onchange="getDetailVendor()" required>
                                <option value="">Pilih Vendor</option>
                                @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}|{{ $vendor->email }}|{{ $vendor->bank->nama_bank }}|{{ $vendor->nomor_rekening }}" {{ old('id_vendor')==$vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->kode_vendor }} - {{ $vendor->nama_vendor }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="id_vendor" id="id_vendor" value="{{ old('id_vendor') }}">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Bank</label>
                            <input type="text" name="nama_bank" id="nama_bank" class="form-control" value="{{ old('nama_bank') }}" required readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" value="{{ old('nomor_rekening') }}" required readonly>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('transaksi.index') }}';" class="btn btn-light">
    <input type="submit" value="Submit" class="btn btn-primary" id="btn-submit-transaksi">
</div>
{{ Form::close() }}
@endsection

@section('script')
<script>
    function getDetailBarang() {
    var barang = $("#barang").val();
    const arrBarang = barang.split("|");
    $("#id_barang").val(arrBarang[0]);
    $("#harga_item").val(arrBarang[1]);
}


function getDetailVendor() {
	var vendor = $(`#vendor`).val();
	const arrVendor = vendor.split("|");
    $(`#id_vendor`).val(arrVendor[0]);
	$(`#email`).val(arrVendor[1]);
    $(`#nama_bank`).val(arrVendor[2]);
    $(`#nomor_rekening`).val(arrVendor[3]);
}

function totalHarga() {
	var kuantitas = $(`#kuantitas`).val();
	var harga_satuan = $(`#harga_item`).val();

	kuantitas = parseFloat(kuantitas) || 0;
	harga_satuan = parseFloat(harga_satuan) || 0;

    if(kuantitas > 2){
        Swal.fire({
            icon: "warning",
            title: "Barang tidak dapat dipesan lebih dari 2 dalam sehari!",
        });
    }else{
        var total_harga = kuantitas * harga_satuan;
        var total_harga_ppn = total_harga + (total_harga * 11/100);

        if(total_harga >= 5000000){
            Swal.fire({
                icon: "warning",
                title: "Total harga item harus kurang dari 5juta!",
            });
            $(`#btn-submit-transaksi`).prop("disabled", true);
            $(`#total_harga`).css('background-color', 'red');
            $(`#total_harga_ppn`).css('background-color', 'red');
        }else{
            $(`#btn-submit-transaksi`).prop("disabled", false);
            $(`#total_harga`).css('background-color', '');
            $(`#total_harga_ppn`).css('background-color', '');
        }

        $(`#total_harga`).val(total_harga);
        $(`#total_harga_ppn`).val(total_harga_ppn);
    }
}

</script>

@endsection