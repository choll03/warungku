<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
// Use Alert;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('transaksi.index');
    }


    public function getData()
    {
        $user = auth()->user();
        return Datatables::of($user->barang)
        ->addColumn('actions', function ($data) {
            return '
                <button type="button" class="increment btn btn-sm btn-success" data-barang='. var_export(json_encode($data), true) .' >+</button>
                <button type="button" class="decrement btn btn-sm btn-danger" data-barang='. var_export(json_encode($data), true) .'>-</button>
            ';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }
}
