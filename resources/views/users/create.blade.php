@extends('layout')

@section('title', 'Crear nuevo usuario')

@section('content')
    <div class="card">

        <div class="card-header h4">

            <h1>Crear nuevo usuario</h1>

        </div>
    </div>
            <div class="card-body">
            @include('shared._errors')

            <form action="{{ route('users.store') }}" method="POST">

                @include('users._fields')

                <div class="form-group mt-4">
                    <button type="submit" class="btn-primary btn">Crear usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
                </div>
            </form>

        </div>

@endsection