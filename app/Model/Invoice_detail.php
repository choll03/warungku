<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    protected $fillable = ['invoice_id', 'barang_id', 'nama', 'qty', 'harga', 'harga_beli'];

    public function barang()
    {
        return $this->belongsTo('App\Model\Barang');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Model\Invoice');
    }
}
