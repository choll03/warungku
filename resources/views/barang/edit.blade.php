@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Barang</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['route' => ['barang.update', $data->id]]) !!}
                    @method('PUT')
                        <div class="form-group">
                            {!! Form::label('nama', 'Nama Brang') !!}
                            {!! Form::text('nama', $data->nama, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('harga_beli', 'Harga Beli') !!}
                            {!! Form::text('harga_beli', $data->harga_beli, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('harga_jual', 'Harga Jual') !!}
                            {!! Form::text('harga_jual', $data->harga_jual, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('stok', 'Stok') !!}
                            {!! Form::text('stok', $data->stok, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('Ubah', ['class' => 'btn btn-primary float-right']) !!}

                    {!! Form::close() !!}
                    
                    
                </div>
                @if ($errors->any())
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
