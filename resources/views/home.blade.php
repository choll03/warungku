@extends('layouts.app')

@section('content')


<!-- Main content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </section>
        <!-- Main content -->
    <section class="content ml-2">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Rp. {{ $data['omset_today'] }}</h3>
                <p>Omset Hari Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Rp. {{ $data['omset'] }}</h3>
                <p>Total Omset</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3>Rp. {{ $data['untung_today'] }}</h3>

                <p>Keuntungan Hari Ini</p>
              </div>
              <div class="icon">
                <i  class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rp. {{ $data['untung'] }}</h3>

                <p>Total Keuntungan</p>
              </div>
              <div class="icon">
                <i  class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        
        <div class="row">
          <!-- Left col -->
          <section class="col-md-6 col-sm-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header bg-warning">
                <h3 class="card-title">Stok Hampir Habis!</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Stok Tersisa</th>
                      <th>Order</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['stok_limit'] as $barang)
                    <tr>
                      <td>{{ $barang->nama }}</td>
                      <td>{{ $barang->stok }}</td>
                      <td><a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-success">Re-stok</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
        </section>

        <div class="col-md-6 col-sm-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Diagram Penjualan</h3>
                  <a href=#>Lihat Laporan</a>
                </div>
              </div>
            <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">Rp. 2.500.000</span>
                    <span>Total Omset</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Omset
                  </span>

                  <span>
                    <i class="fas fa-square text-danger"></i> Keuntungan
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
        <!-- /.content -->
        </div>
      </div>
      <!-- /.content-wrapper -->
    </section>
</div>
      @include('footer')
@endsection
@section('script')
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
    $(function () {
        'use strict'

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode      = 'index'
        var intersect = true

        var $salesChart = $('#sales-chart')
        var salesChart  = new Chart($salesChart, {
            type   : 'bar',
            data   : {
                labels  : ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [
                    {
                        backgroundColor: '#007bff',
                        borderColor    : '#007bff',
                        data           : [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                    },
                    {
                        backgroundColor: '#ced4da',
                        borderColor    : '#ced4da',
                        data           : [700, 1700, 2700, 2000, 1800, 1500, 2000]
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips           : {
                    mode     : mode,
                    intersect: intersect
                },
                hover              : {
                    mode     : mode,
                    intersect: intersect
                },
                legend             : {
                    display: false
                },
                scales             : {
                    yAxes: [{
                    // display: false,
                    gridLines: {
                        display      : true,
                        lineWidth    : '4px',
                        color        : 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks    : $.extend({
                        beginAtZero: true,

                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                        if (value >= 1000) {
                            value /= 1000
                            value += 'k'
                        }
                        return '$' + value
                        }
                    }, ticksStyle)
                    }],
                    xAxes: [{
                    display  : true,
                    gridLines: {
                        display: false
                    },
                    ticks    : ticksStyle
                    }]
                }
            }
        })
    })

    </script>
@endsection
