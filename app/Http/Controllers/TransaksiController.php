<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Model\Invoice_detail;
use App\Model\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Item;
use App\CoreItem;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use DNS2D;

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
                    'harga'         => $request->harga[$key] / $request->qty[$key],
                    'harga_beli'    => $request->harga_beli[$key]
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

        $invoice = $user->invoice()
                    ->selectRaw('invoices.*, (SELECT SUM(harga * qty) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id) as total')
                    ->latest()
                    ->get();

        return view('transaksi.laporan', ['data' => $invoice]);
    }

    public function laporanShow($id)
    {
        $invoice = auth()->user()->invoice()->with('detail')->where('id', $id)->first();
        $barcode = DNS2D::getBarcodeHTML( route('transaksi.print_barcode', $id) , "QRCODE");
        return view('transaksi.detail', [
            'data'      => $invoice,
            'barcode'   => $barcode
        ]);
    }

    public function print($id)
    {
        $user = auth()->user();

        $warung = $user->warung;
        $invoice =  $user->invoice()->with('detail')->where('id', $id)->first();

        try {
            $ip = "127.0.0.1";
            // $ip = "127.0.0.1";
            $connector = new WindowsPrintConnector("smb://". $ip ."/POS-58");
            $printer = new Printer($connector);

            $total = 0;
            /* Date is kept the same for testing */
            // $date = date('l jS \of F Y h:i:s A');
            // date_default_timezone_set('Asia/Jakarta');
            date_default_timezone_set("Asia/Jakarta");
            $date = date("d m Y H:i:s");
            
            /* Start the printer */
            // $logo = EscposImage::load("resources/escpos-php.png", false);
            // $printer = new Printer($connector);
            
            /* Print top logo */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            // $printer -> graphics($logo);
            
            /* Name of shop */
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text(strtoupper($warung->nama . "\n"));
            $printer->selectPrintMode();
            $printer->text($warung->alamat);
            $printer->feed();
            $printer->setEmphasis(false);
            
            
            /* Items */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->text(new CoreItem('Nomor', $invoice->no_transaksi));
            $printer->text(new CoreItem('Tanggal', $invoice->created_at->format("d/m/Y")));
            $printer->feed();

            $printer->setEmphasis(false);
            foreach ($invoice->detail as $item) {
                $total += ($item->harga * $item->qty);
                $printer->text(new Item($item->nama, $item->qty ,($item->harga * $item->qty)));
            }
            $printer->feed();
            $printer->setEmphasis(true);
            $printer->text(new CoreItem('Total', $total));
            $printer->setEmphasis(false);
            
            /* Tax and total */
            $printer->text(new CoreItem('Tunai', $invoice->tunai));
            // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text(new CoreItem('Kembali', ($invoice->tunai - $total)));
            $printer->selectPrintMode();
            
            /* Footer */
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih sudah berbelanja di ". strtoupper($warung->nama) ."\n");
            $printer->feed(2);
            $printer->text($date . "\n");
            $printer->feed(4);
            
            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();
            
            $printer->close();

        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    public function printJs($id)
    {
        $user = auth()->user();
        return view('pdf.invoice', [
            'warung'    => $user->warung,
            'invoice'   => $user->invoice()->with('detail')->where('id', $id)->first(),
            'date'      => Carbon::now()->format("d M Y H:i:s")
        ]);
    }

    public function printBarcode($id)
    {
        $invoice = Invoice::with('detail')->where('id', $id)->first();
        $warung = $invoice->user->warung;
        return view('pdf.invoice_barcode', [
            'warung'    => $warung,
            'invoice'   => $invoice,
            'date'      => Carbon::now()->format("d M Y H:i:s")
        ]);
    }
}
