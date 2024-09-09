@extends('layouts.app')

@section('content')

@include('partials.flash-messages')

<div class="d-flex justify-content-between">
    <h1>Listagem de Vendas</h1>

    <div>
        <a href="{{route('sales.create')}}" class="btn btn-success  btn-sm mx-3">Nova Venda</a>

    </div>

</div>

<table class="table table-striped table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Total</th>
            <th>Data</th>
            <th>Atualizado em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->customer ? $sale->customer->name : 'N/A' }}</td>
                <td>{{ $sale->seller->name }}</td>
                <td>{{ $sale->total }}</td>
                <td>{{ $sale->created_at }}</td>
                <td>{{ $sale->updated_at }}</td>
                <td>
                    <a href="#" class="btn btn-info  btn-sm">Info</a>

                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning  btn-sm">Editar</a>
                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
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