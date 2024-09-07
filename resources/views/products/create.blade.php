@extends('layouts.app')

@section('content')
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <h1>Cadastrar produto</h1>
    <div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome do produto</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Preço do produto</label>
            <input type="text" class="form-control" id="price" name="price">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Quantidade em Estoque</label>
            <input type="number" class="form-control" min="1" id="stock" name="stock">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Criar Produto</button>
        </div>
    </div>


</form>

@endsection