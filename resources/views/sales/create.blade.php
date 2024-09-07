@extends('layouts.app')

@section('content')


<form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="customer_id">Cliente:</label>
        <select name="customer_id" id="customer_id" class="form-control">
            <option selected></option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="seller_id">Vendedor:</label>
        <select name="seller_id" id="seller_id" class="form-control">
            <option selected></option>

            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="payment_method_id">Método de Pagamento:</label>
        <select name="payment_method_id" id="payment_method_id" class="form-control">
            <option selected></option>

            @foreach($paymentMethods as $method)
                <option value="{{ $method->id }}">{{ $method->name }}</option>
            @endforeach
        </select>
    </div>

    <div id="sale-items">
        <div class="form-group">
            <label for="items[0][product_id]">Produto:</label>
            <select name="items[0][product_id]" class="form-control">
                <option selected></option>

                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="items[0][amount]">Quantidade:</label>
            <input type="number" name="items[0][amount]" class="form-control" min="1" required>
        </div>
    </div>

    <button type="button" onclick="addItem()">Adicionar Item</button>

    <button type="submit" class="btn btn-primary">Criar Venda</button>
</form>

@endsection