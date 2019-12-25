<?php

use Illuminate\Database\Seeder;
use App\Model\Invoice_detail;

class UpdateHargaBeliInvoice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices = Invoice_detail::all();

        foreach($invoices as $invoice)
        {
            $invoice->harga_beli = $invoice->barang->harga_beli;
            $invoice->save();
        }
    }
}
