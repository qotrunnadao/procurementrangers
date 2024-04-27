<?php

namespace App\Models\Master;

use App\Models\Master\Bank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'master_vendor';

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'id_bank');
    }
}
