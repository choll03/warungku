<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    protected $fillable = ['invoice_id', 'barang_id', 'nama', 'qty', 'harga'];

    public function barang()
    {
        return $this->belongsTo('App\Model\Barang');
    }
}
