@extends('layout')

@section('title', 'Usuarios')

@section('content')
        <h1>{{ trans('users.title.' . $view) }}</h1>
        <p>
            @if($view == 'index')
            <a href="{{ route('users.trashed') }}" class="btn btn-outline-dark">Ver papelera</a>
            <a href="{{ route('users.create') }}" class="btn btn-info">Crear nuevo usuario...</a>
            @else
                <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Regresar al listado de usuarios</a>
            @endif
        </p>
        @includeWhen($view == 'index', 'users._filters')    {{--Le quitamos el isset porque es directamente un booleano --}}
        @if( $users->count() )

            <div class="table-responsive-lg">
                <table class="table table-sm">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                        <th scope="col" class="sort-desc">Nombre <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                        <th scope="col">Correo <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                        <th scope="col">Rol <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                        <th scope="col">Fechas <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                        <th scope="col" class="text-right th-actions">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('users._row', $users, 'user')
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        @else
            <p>No hay usuarios registrados</p>

        @endif

@endsection