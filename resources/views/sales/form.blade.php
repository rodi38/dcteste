@extends('layouts.app')

@section('content')


<form action="{{ isset($sale) ? route('sales.update', $sale->id) : route('sales.store') }}" method="POST">
    @csrf
    @if (isset($sale))
        <h1>Editar Venda</h1>
        @method('PUT')
    @else
        <h1>Criar Venda</h1>
    @endif

    @include('sales.partials.navigation')

    @include('sales.partials.saleInfo')

    @include('sales.partials.saleItems')

    @include('sales.partials.payment')



    <div class="pt-5">
        <label for="totalValue">Total</label>
        <input type="text" id="totalValue" disabled value="{{ isset($sale) ? $sale->total : 0 }}">
        <button type="submit" class="btn btn-primary">{{isset($sale) ? 'Atualizar' : 'Cadastrar'}}</button>
    </div>

</form>

@endsection

@push('scripts')
    @include('sales.partials.scripts')
@endpush