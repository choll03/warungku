@extends('layouts.app_warung')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Yuk buat warung</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['route' => 'warung.store']) !!}
                        <div class="form-group">
                            {!! Form::label('nama', 'Nama warung') !!}
                            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('alamat', 'Alamat') !!}
                            {!! Form::textarea('alamat', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        {!! Form::submit('Buat', ['class' => 'btn btn-primary float-right']) !!}

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
