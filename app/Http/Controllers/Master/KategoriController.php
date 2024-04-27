<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('master.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        if (Kategori::create($request->all())) {
            toast('Data kategori berhasil disimpan!', 'success');
        } else {
            toast('Data kategori gagal disimpan!', 'error');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        Kategori::where('id', $id)->update($request->except('_method', '_token'));

        toast('Data kategori berhasil diupdate!', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (Kategori::where('id', $id)->delete()) {
            toast('Data kategori berhasil dihapus!', 'success');
        } else {
            toast('Data kategori gagal dihapus!', 'error');
        }

        return redirect()->back();
    }
}
