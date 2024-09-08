@extends('layouts.app')

@section('content')

<form action="{{ $customer->exists ? route('customers.update', $customer->id) : route('customers.store') }}"
    method="POST">
    @csrf
    @if ($customer->exists)
        <h1>Editar cliente</h1>
        @method('PUT')
    @else
        <h1>Cadastrar cliente</h1>
    @endif

    <div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $customer->name) }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $customer->email) }}">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">{{ $customer->exists ? 'Atualizar' : 'Criar' }}</button>
        </div>
    </div>



</form>
@endsection