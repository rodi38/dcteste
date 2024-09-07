@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between">
    <h1>Listagem de Produtos</h1>

    <div>
        <a href="/products/create" class="btn btn-success  btn-sm mx-3">Novo Produto</a>

    </div>

</div>

<table class="table table-striped table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quant. Stock</th>
            <th>Criado em</th>
            <th>Atualizado em</th>
            <th>Açoes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->created_at }}</td>
                <td>{{ $product->total }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning  btn-sm">Editar</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
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