@extends('layouts.app')

@section('content')
@include('partials.flash-messages')

<form action="{{ $seller->exists ? route('sellers.update', $seller->id) : route('sellers.store') }}" method="POST">
    @csrf
    @if ($seller->exists)
        <h1>Editar vendedor</h1>
        @method('PUT')
    @else
        <h1>Cadastrar vendedor</h1>
    @endif

    <div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $seller->name) }}"
                required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $seller->email) }}"
                required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Codigo</label>
            <input type="number" class="form-control" min="1" id="code" name="code"
                value="{{ old('code', $seller->code) }}" required>
        </div>

        @if (!$seller->exists)
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    required>
            </div>
        @endif
        <div class="mb-3">
            <button type="submit" class="btn btn-success">{{ $seller->exists ? 'Atualizar' : 'Criar' }}</button>
        </div>
    </div>
</form>
@endsection