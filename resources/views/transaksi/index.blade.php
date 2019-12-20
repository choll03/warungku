@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Stok barang</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="table_barang" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Keranjang</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>jumlah</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody id="keranjang">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        
        $(function(){
            var table = $("#table_barang").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route("getBarangForTransaksi") }}'
                },
                columns: [
                    { data: 'nama'},
                    { data: 'harga_jual'},
                    { data: 'stok' },
                    { data: 'actions', orderable: false, searchable: false}
                ]
            });

            var row = table.row();

            $('#table_barang tbody').on( 'click', '.increment', function () {
                var data = $(this).data('barang');

                var barang = table.row($(this).closest("tr")).data();
                if(parseInt(barang['stok']) > 0){
                    barang['stok'] -= 1;
                    table.row($(this).closest("tr")).data(barang);

                    var find = $("#keranjang").find(`#row_${data.id}`)[0];
                    if(!find){
                        $("#keranjang").append(`
                            <tr id="row_${data.id}">
                                <td>${data.nama}</td>
                                <td id="view_qty_${data.id}">${1}</td>
                                <td id="view_harga_${data.id}">${data.harga_jual}</td>
                            </tr>
                        `);
                    }
                    else {
                        console.log(find);
                    }

                    
                }
                else{
                    $(this).addClass('disabled');
                }
                
                // var id = $(this).data('id');
                // var barang = $(this).data('barang');
                // $("#input_id").val(barang.id);
                // $("#input_nama").val(barang.nama);
                // $("#barang_title").html(barang.nama);
                // $("#input_harga").val(barang.harga_jual);
                // $("#input_stok").val(barang.stok);
                // $("#input_qty").val("");
            })

            $('#table_barang tbody').on( 'click', '.decrement', function () {
                var data = $(this).data('barang');

                var barang = table.row($(this).closest("tr")).data();
                if(data.stok > parseInt(barang['stok'])){
                    barang['stok'] += 1;
                    table.row($(this).closest("tr")).data(barang);

                }
                else{
                    $(this).addClass('disabled');
                }
            })
        })

    </script>
@endsection
