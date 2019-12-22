<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Model\Invoice_detail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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


    public function store(Request $request)
    {
        $user = $request->user();
        
        $no_transaksi = date('Ymd') . '001';

        $last_invoice = $user->invoice()->orderByDesc('id')->first();

        if($last_invoice){
            $last_nomor = $last_invoice->no_transaksi;
            if(substr($last_nomor, 0, 6) == date("Ym")){
                $no_transaksi = $last_nomor + 1;
            }
        }

        DB::beginTransaction();
        try {

            $invoice = $user->invoice()->create([
                'no_transaksi'  => $no_transaksi,
                'tunai'        => $request->tunai
            ]);
    
            foreach($request->nama as $key => $value)
            {
                $invoice_detail = $invoice->detail()->create([
                    'barang_id'     => $key,
                    'nama'          => $value,
                    'qty'           => $request->qty[$key],
                    'harga'         => $request->harga[$key] / $request->qty[$key]
                ]);
    
                $barang = $invoice_detail->barang()->find($key);
    
                $barang->stok = $barang->stok - $request->qty[$key];
                $barang->save();
            }
            DB::commit();
            return response()->json([
                'message'   => 'Transaksi berhasil dibuat',
                'data'      => $invoice
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th->getMessage(), 403);
        }
        
    }

    public function laporan()
    {
        $user = auth()->user();

        $invoice = $user->invoice()->selectRaw('invoices.*, (SELECT SUM(harga * qty) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id) as total')->get();

        dd($invoice);
        return view('transaksi.laporan', ['data' => $invoice]);
    }

    public function print($id)
    {
        $user = auth()->user();
        return view('pdf.invoice', [
            'warung'    => $user->warung,
            'invoice'   => $user->invoice()->with('detail')->where('id', $id)->first()
        ]);
    }
}
