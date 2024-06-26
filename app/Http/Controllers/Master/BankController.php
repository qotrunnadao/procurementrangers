<?php

namespace App\Http\Controllers\Master;

use Exception;
use App\Models\Master\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::latest()->get();
        return view('master.bank.index', compact('banks'));
    }

    public function store(Request $request)
    {
        if (Bank::create($request->all())) {
            toast('Data bank berhasil disimpan!', 'success');
        } else {
            toast('Data bank gagal disimpan!', 'error');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        Bank::where('id', $id)->update($request->except('_method', '_token'));

        toast('Data bank berhasil diupdate!', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            Bank::where('id', $id)->delete();
            toast('Data bank berhasil dihapus!', 'success');
        } catch (Exception $e) {
            toast('Data tidak dapat dihapus karena data bank telah digunakan!', 'error');
        }

        return redirect()->back();
    }
}
