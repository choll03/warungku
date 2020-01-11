@extends('layouts.app')

@section('content')
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
<!-- Main content -->
<section class="content">

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-info">
          <h3 class="card-title">Laporan Keuntungan</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Invoice</th>
                        <th>Total</th>
                        <th>Total Keuntungan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->created_at->format("d/m/Y") }}</td>
                        <td>{{ $d->no_transaksi }}</td>
                        <td class="int">{{ $d->total }}</td>
                        <td class="int">Belom di isi euy gatau kodingannya</td>
                        <td>
                            <a href="{{ route('laporan.show', $d->id) }}" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="hasil">
                        <td colspan="2">JUMLAH</td>
                        <td>jumlah penjualan</td>
                        <td>jumlah keuntungan</td>
                        <td></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
  </div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection