<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['warung_id', 'nama', 'harga_beli', 'harga_jual', 'stok'];
}
