
@extends('layout')

@section('title', 'Editar usuario')

@section('content')
    <div class="card">

        <div class="card-header h4">

    <h1>Editar usuario</h1>

        </div>
    </div>

    <div class="card-body visible-print">
        @include('shared._errors')


    <form action="{{ route('users.update', $user) }}" method="POST">
        {{ method_field('PUT') }}
        @include('users._fields')

        <div class="form-group mt-4">
            <button type="submit" class="btn-primary btn">Actualizar usuario</button>
            <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
        </div>
    </form>
@endsection
