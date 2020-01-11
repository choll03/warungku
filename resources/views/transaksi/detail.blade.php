@extends('layouts.app')

@section('style')
<style>
    .print-only{
        display: none;
    }
</style>
@endsection

@section('content')

<?php 
    $total = 0; 
?>
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Laporan</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
<!-- Main content -->
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <!-- Default box -->
      <div class="card">
                <div class="card-header bg-info">Detail Laporan</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <div class="table-responsive">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td align="left">Nomor Transaksi</td>
                            <td align="left">{{ $data->no_transaksi }}</td>
                        </tr>
                        <tr>
                            <td align="left">Tanggal</td>
                            <td align="left">{{ $data->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->detail as $detail)
                            <?php $total += ($detail->qty * $detail->harga) ?>
                            <tr>
                                <td>{{ $detail->nama }}</td>
                                <td align="center">{{ $detail->qty }}</td>
                                <td align="right">{{ ($detail->qty * $detail->harga) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td align="right" colspan="2">Total</td>
                            <td align="right">{{ $total }}</td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2">Tunai</td>
                            <td align="right">{{ $data->tunai }}</td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2">Kembali</td>
                            <td align="right">{{ $data->tunai - $total }}</td>
                        </tr>
                    </tfoot>
                    
                    </table>
                    <div class="float-auto">
                        <!-- <div class="col-md-6 col-10"> -->
                            <?php echo $barcode ?>
                        <!-- </div> -->
                    </div>
                </div>
                </div>
                <div class="card-footer" style="text-align:right">
                    <button class="btn btn-info">Print Struk</button>
                    <button class="btn btn-warning" id="print_preview">Print Preview</button>
                    
                   
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>

<div id="print-area" class="print-only">
</div>
@endsection
@section('script')
    <script src="{{ asset('js/print.js') }}"></script>
    <script>
        $(function(){
             $("#print_preview").on('click', function(e) {
                $.ajax({
                    url: '{{route("transaksi.print_preview", $data->id)}}',
                    method: 'GET',
                    success: function (print_data){
                        $('#print-area').html(print_data);
                    },
                    complete: function () {
                        printJS({
                            printable: 'print-area', 
                            type: 'html'
                        });
                    }
                });
             });
        })
    </script>
@endsection
