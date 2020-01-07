<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Model\Invoice_detail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $omset = $user->invoice()->sum(DB::raw('(SELECT SUM(harga*qty) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id)'));
        $modal = $user->invoice()->sum(DB::raw('(SELECT SUM(harga_beli*qty) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id)'));
        $omset_today = $user->invoice()->whereDate('created_at', Carbon::today())->sum(DB::raw('(SELECT SUM(harga*qty) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id)'));
        $modal_today = $user->invoice()->whereDate('created_at', Carbon::today())->sum(DB::raw('(SELECT SUM(harga_beli*qty) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id)'));


        $label = [];
        $dataset = [];
        $user_id = $user->id;
        $invoice_detail = Invoice_detail::selectRaw('invoice_details.nama, SUM(qty * harga) as total')
        ->whereHas('invoice', function($q) use ($user_id){
            $q->where('user_id', $user_id);
            $q->whereDate('created_at', Carbon::today());
        })
        ->orderBy('nama')
        ->groupBy('barang_id')
        ->limit(5)
        ->get();

        foreach($invoice_detail as $detail)
        {
            $label[] = $detail->nama;
            $dataset[] = $detail->total;
        }

        $stok_limit = $user->warung->barang()->where('stok', '<', 4)->get();
        $data = [
            'omset'         => $omset,
            'untung'        => $omset - $modal,
            'omset_today'   => $omset_today,
            'untung_today'  => $omset_today - $modal_today,
            'stok_limit'    => $stok_limit,
            'label'         => $label,
            'dataset'       => $dataset
        ];

        return view('home', ['data'=> $data]);
    }

    public function print($id)
    {
        $user = \App\User::find(1);

        $warung = $user->warung;
        $invoice =  $user->invoice()->with('detail')->where('id', $id)->first();

        try {
            $ip = "127.0.0.1";
            $connector = new WindowsPrintConnector("smb://". $ip ."/POS-58");
            $printer = new Printer($connector);

            $total = 0;
            /* Date is kept the same for testing */
            // $date = date('l jS \of F Y h:i:s A');
            $date = Carbon::now();
            
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
            
            /* Title of receipt */
            $printer->text("SALES INVOICE\n");
            $printer->setEmphasis(false);
            
            /* Items */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->text(new item('', 'Rp'));
            $printer->setEmphasis(false);
            foreach ($invoice->detail as $item) {
                $total += ($item->harga * $item->qty);
                $printer->text(new Item($item->nama, ($item->harga * $item->qty)));
            }
            $printer->feed();
            $printer->setEmphasis(true);
            $printer->text(new item('Total', $total));
            $printer->setEmphasis(false);
            
            /* Tax and total */
            $printer->text(new item('Tunai', $invoice->tunai));
            // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text(new item('Kembali', ($invoice->tunai - $total)));
            $printer->selectPrintMode();
            
            /* Footer */
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for shopping at ExampleMart\n");
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
        
        // return view('pdf.invoice');
    }
}