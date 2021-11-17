@extends('layout')

@section('title', 'Listado de usuarios')

@section('content')
        <h1>{{ $title }}</h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-info">Crear nuevo usuario...</a>
        </p>
        @if( $users->count() )

            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->trashed())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <span class="oi oi-circle-x"></span>
                                    </button>
                                </form>
                                @else
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-link">
                            <span class="oi oi-eye"></span>
                        </a> |
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-link">
                            <span class="oi oi-pencil"></span>
                        </a> |
                        <form action="{{ route('users.trash', $user->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">
                                <span class="oi oi-trash"></span>
                            </button>
                        </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No hay usuarios registrados</p>

        @endif

@endsection

@section('sidebar')
    Barra Lateral

@endsection

@section('footer',  ' El fracaso es la manera de empezar de nuevo, pero más inteligente')