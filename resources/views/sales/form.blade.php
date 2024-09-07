@extends('layouts.app')

@section('content')


<form action="{{ isset($sale) ? route('sales.update', $sale->id) : route('sales.store') }}" method="POST">
    @csrf
    @if (isset($sale))
        <h1>Editar Venda</h1>
        @method('PUT');
    @else
        <h1>Criar Venda</h1>
    @endif

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a href="{{route('sales.index')}}" class="page-link">Voltar</a>
            </li>
            <li class="page-item"><a class="page-link" href="#info" onclick="showDiv('info')">Informações</a></li>
            <li class="page-item"><a class="page-link" href="#sale-items" onclick="showDiv('sale-items')">Produto</a>
            </li>
            <li class="page-item"><a class="page-link" href="#payment" onclick="showDiv('payment')">Pagamento</a></li>

        </ul>
    </nav>
    <div class="form-group" id="info">
        <label for="customer_id">Cliente:</label>
        <select name="customer_id" id="customer_id" class="form-control">
            <option selected></option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>

        <label for="seller_id">Vendedor:</label>
        <select name="seller_id" id="seller_id" class="form-control">
            <option selected></option>

            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
            @endforeach
        </select>
    </div>




    <div class="d-none" id="sale-items">
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

    <div class="form-group d-none" id="payment">
        <label for="payment_method_id">Método de Pagamento:</label>
        <select name="payment_method_id" id="payment_method_id" class="form-control">
            <option selected></option>

            @foreach($paymentMethods as $method)
                <option value="{{ $method->id }}">{{ $method->name }}</option>
            @endforeach
        </select>

        <label for="number_installment">Quantidade de parcelas</label>
        <input type="number" name="number_installment" class="form-control" min="1" required>

    </div>

    <button type="button" onclick="addItem()">Adicionar Item</button>

    <button type="submit" class="btn btn-primary">Criar Venda</button>
</form>

@endsection

@push('scripts')
    <script>
        function showDiv(divId) {
            document.getElementById('info').classList.add('d-none');
            document.getElementById('sale-items').classList.add('d-none');
            document.getElementById('payment').classList.add('d-none');
            document.getElementById(divId).classList.remove('d-none');
        }

        document.addEventListener('DOMContentLoaded', function () {
            showDiv('info');
        });
    </script>
@endpush