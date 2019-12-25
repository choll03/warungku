<style>
 @media print {
    html, body {
        display: block; 
        font-family:"Courier New", Courier, monospace;
        margin: 0;
        font-size:12px;
    }

    @page {
      /* size: 57mm 50mm; */
        /* width: 57mm;
        height: 57mm; */
    }

    .logo {
      width: 30%;
    }

    hr {
        border: 1px dotted #000;
        border-style: none none dotted; 
        color: #fff; 
        background-color: #6c757d;
    }

}
</style>
<?php $total = 0; ?>
<table style="text-align:center;width:100%">
    <tr>
        <td>{{ strtoupper($warung->nama) }}</td>
    </tr>
    <tr>
        <td>{{ $warung->alamat }}</td>
    </tr>
</table>
<hr>
<table width="100%">
    <tr>
        <td>Nomor</td>
        <td align="right">{{ $invoice->no_transaksi }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td align="right">{{ $invoice->created_at->format("d/M/Y") }}</td>
    </tr>
</table>
<hr>
<table width="100%">
    @foreach($invoice->detail as $detail)
        <?php $total += ($detail->qty * $detail->harga) ?>
        <tr>
            <td>{{ $detail->nama }}</td>
            <td align="right">{{ $detail->qty }}</td>
            <td align="right">{{ $detail->qty * $detail->harga }}</td>
        </tr>
    @endforeach
</table>
<hr>
<table width="100%">
    <tr>
        <td align="right">Total</td>
        <td align="right">{{ $total }}</td>
    </tr>
    <tr>
        <td align="right">Tunai</td>
        <td align="right">{{ $invoice->tunai }}</td>
    </tr>
    <tr>
        <td align="right">Kembali</td>
        <td align="right">{{ $invoice->tunai - $total }}</td>
    </tr>
</table>
<br>
<table style="text-align:center;width:100%">
    <tr>
        <td>Terima kasih sudah berbelanja di {{ strtoupper($warung->nama) }}</td>
    </tr>
    <tr>
        <td>{{ $date }}</td>
    </tr>
</table>
<script>
    window.print();
</script>