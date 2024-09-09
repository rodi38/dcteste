@extends('layouts.app')

@section('content')

@include('partials.flash-messages')


<div class="d-flex justify-content-between">
    <h1>Listagem de Vendedores</h1>

    <div>
        <a href="{{ route('sellers.create') }}" class="btn btn-success  btn-sm mx-3">Novo Vendedor</a>

    </div>

</div>

<table class="table table-striped table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Codigo</th>
            <th>Criado em</th>
            <th>Atualizado em</th>
            <th>Açoes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sellers as $seller)
            <tr>
                <td>{{ $seller->id }}</td>
                <td>{{ $seller->name }}</td>
                <td>{{ $seller->email }}</td>
                <td>{{ $seller->code }}</td>
                <td>{{ $seller->created_at }}</td>
                <td>{{ $seller->updated_at }}</td>
                <td>
                    <a href="#" class="btn btn-info  btn-sm">Info</a>
                    <a href="{{ route('sellers.edit', $seller->id) }}" class="btn btn-warning  btn-sm">Editar</a>
                    <form action="{{ route('sellers.destroy', $seller->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection