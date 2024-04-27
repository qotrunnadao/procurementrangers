<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        $today = date('Y-m-d');
        $barangs = Barang::whereDate('available_date', '>=', $today)->get();
        return view('master.barang.index', compact('barangs', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data['kode_item']     = $request->kode_item;
        $data['nama_item'] = $request->nama_item;
        $data['available_date'] = cleanDateFormat($request->available_date);
        $data['harga_item']   = cleanMoneyFormat($request->harga_item);
        $data['berat_kg']     = $request->berat_kg;
        $data['id_kategori'] = $request->id_kategori;

        if (Barang::create($data)) {
            toast('Data barang berhasil disimpan!', 'success');
        } else {
            toast('Data barang gagal disimpan!', 'error');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        $barang->update([
            'kode_item' => $request->kode_item,
            'nama_item' => $request->nama_item,
            'available_date' => cleanDateFormat($request->available_date),
            'harga_item' => cleanMoneyFormat($request->harga_item),
            'berat_kg' => $request->berat_kg,
            'id_kategori' =>  $request->id_kategori,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        toast('Data barang berhasil diupdate!', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (Barang::where('id', $id)->delete()) {
            toast('Data barang berhasil dihapus!', 'success');
        } else {
            toast('Data barang gagal dihapus!', 'error');
        }

        return redirect()->back();
    }
}
