<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
Use Alert;

class TransaksiController extends Controller
{
    public function index()
    {
        Alert::alert('Title', 'Message', 'Type');
        return view('transaksi.index');
    }


    public function getData()
    {
        $user = auth()->user();
        return Datatables::of($user->barang)
        ->addColumn('actions', function ($data) {
            return '
                <a href="'. route('barang.edit', $data->id) .'" class="btn btn-sm btn-primary">Order</a>
            ';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }
}
