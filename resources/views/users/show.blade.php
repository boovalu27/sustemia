@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-4 text-success">Detalles del Usuario: {{ $user->name }}</h1>

        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
            <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
            <li class="list-group-item"><strong>Rol:</strong> {{ $user->role->name }}</li>
        </ul>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Volver a la lista de usuarios</a>
    </div>
@endsection
