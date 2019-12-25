<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id', 'no_transaksi', 'tunai'];

    public function detail()
    {
        return $this->hasMany('App\Model\Invoice_detail');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
