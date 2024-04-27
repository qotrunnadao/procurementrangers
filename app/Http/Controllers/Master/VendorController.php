<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Bank;
use Illuminate\Http\Request;
use App\Models\Master\Vendor;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = vendor::latest()->get();
        $banks = Bank::all();
        return view('master.vendor.index', compact('vendors', 'banks'));
    }

    public function store(Request $request)
    {
        if (Vendor::create($request->all())) {
            toast('Data vendor berhasil disimpan!', 'success');
        } else {
            toast('Data vendor gagal disimpan!', 'error');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        Vendor::where('id', $id)->update($request->except('_method', '_token'));

        toast('Data vendor berhasil diupdate!', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (Vendor::where('id', $id)->delete()) {
            toast('Data vendor berhasil dihapus!', 'success');
        } else {
            toast('Data vendor gagal dihapus!', 'error');
        }

        return redirect()->back();
    }
}
