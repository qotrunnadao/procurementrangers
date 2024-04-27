<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Master\Bank;
use Illuminate\Http\Request;
use App\Models\Master\Barang;
use App\Models\Master\Vendor;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barangs = Barang::whereDate('available_date', '>=', date('Y-m-d'))->get();
        $vendors = Vendor::all();
        return view('transaksi.create', compact('barangs', 'vendors'));
    }

    public function store(Request $request)
    {

        $today = date('Y-m-d');
        $jumlah_barang_sehari = Transaksi::where('id_barang', $request->id_barang)->whereDate('created_at', $today)->sum('kuantitas');
        $limit = $jumlah_barang_sehari + $request->kuantitas;
        if ($limit > 2) {
            Alert::warning('Barang sudah dipesan sebanyak ' . $jumlah_barang_sehari . ' hari ini!', 'silahkan kurangi kuantitas barang agar tidak melebihi limit');
            $request->flash();
            return redirect()->back();
        } else {
            $data['kode_transaksi']     = $request->kode_transaksi;
            $data['tanggal_transaksi'] = cleanDateFormat($request->tanggal_transaksi);
            $data['id_barang'] = $request->id_barang;
            $barang = Barang::find($request->id_barang);
            $data['kode_item'] = $barang->kode_item;
            $data['nama_item'] = $barang->nama_item;
            $data['kuantitas'] = $request->kuantitas;
            $data['total_harga'] = cleanMoneyFormat($request->total_harga);
            $data['total_harga_ppn'] = cleanMoneyFormat($request->total_harga_ppn);
            $data['id_vendor'] = $request->id_vendor;
            $vendor = Vendor::find($request->id_vendor);
            $data['nama_vendor'] = $vendor->nama_vendor;
            $data['email'] = $request->email;
            $data['nama_bank'] = $request->nama_bank;
            $data['nomor_rekening'] = $request->nomor_rekening;

            if (Transaksi::create($data)) {
                toast('Data transaksi berhasil disimpan!', 'success');
            } else {
                toast('Data transaksi gagal disimpan!', 'error');
            }

            return redirect()->route('transaksi.index');
        }
    }

    public function destroy($id)
    {
        if (Transaksi::where('id', $id)->delete()) {
            toast('Data transaksi berhasil dihapus!', 'success');
        } else {
            toast('Data transaksi gagal dihapus!', 'error');
        }

        return redirect()->back();
    }

    public function cekLimit($id)
    {
        dd($id);
    }
}
