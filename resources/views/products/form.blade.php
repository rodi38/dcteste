@extends('layouts.app')

@section('content')

<form action="{{ $product->exists ? route('products.update', $product->id) : route('products.store') }}" method="POST">
    @csrf
    @if ($product->exists)
        <h1>Editar produto</h1>
        @method('PUT')
    @else
        <h1>Cadastrar produto</h1>
    @endif

    <div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome do produto</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name', $product->name)}}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Preço do produto</label>
            <input type="text" class="form-control" id="price" name="price" value="{{old('price', $product->price)}}">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Quantidade em Estoque</label>
            <input type="number" class="form-control" min="1" id="stock" name="stock"
                value="{{old('stock', $product->stock)}}">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">{{$product->exists ? 'Atualizar' : 'Cadastrar'}}</button>
        </div>
    </div>


</form>

@endsection