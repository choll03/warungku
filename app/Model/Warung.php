<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Warung extends Model
{
    protected $fillable = ['user_id', 'nama', 'alamat'];


    public function barang()
    {
        return $this->hasMany('App\Model\Barang');
    }
}
