<?php

namespace App\Models;

use App\Models\Master\Barang;
use App\Models\Master\Vendor;
use App\Models\Master\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_transaksi';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }
}
