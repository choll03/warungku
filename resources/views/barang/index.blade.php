@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Data Barang <a href="{{ route('barang.create') }}" class="btn btn-success float-right">Tambah</a></div>

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
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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
            $("#table_barang").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route("getBarang") }}'
                },
                columns: [
                    { data: 'nama'},
                    { data: 'harga_beli'},
                    { data: 'harga_jual'},
                    { data: 'stok' },
                    { data: 'actions', orderable: false, searchable: false}
                ]
            });
        })
    </script>
@endsection