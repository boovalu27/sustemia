@extends(auth()->user() && auth()->user()->role ? (auth()->user()->role->name === 'admin' ? 'layouts.admin' : 'layouts.main') : 'layouts.main')


@section('content')
    <h1>Crear Usuario</h1>

    <!-- Formulario para crear un nuevo usuario -->
    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <!-- Campo de nombre -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de correo electrónico -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo de roles -->
        <div class="mb-3">
            <label for="roles" class="form-label">Roles</label>
            <select name="roles[]" id="roles" class="form-select" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
@endsection
