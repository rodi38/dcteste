<div class="form-group d-none" id="payment">
    <label for="payment_method_id">Método de Pagamento:</label>
    <select name="payment_method_id" id="payment_method_id" class="form-control">
        <option selected></option>

        @foreach($paymentMethods as $method)
            <option value="{{ $method->id }}" {{(isset($sale) && $sale->payment_method_id == $method->id) ? 'selected' : ''}}>
                {{ $method->name }}
            </option>
        @endforeach
    </select>

    <label for="number_installments">Quantidade de parcelas:</label>
    <input type="number" name="number_installments" id="number_installments" class="form-control" min="1" required
        value="{{ isset($sale) && $sale->installments ? $sale->installments->count() : 1 }}">

    <button type="button" id="addInstallments" class="btn btn-secondary mt-2">Gerar parcelas</button>

    <div id="installmentsContainer">
        @if(isset($sale))
            @foreach($sale->installments as $index => $installment)
                <div class="installment-row">
                    <label for="installments[{{$index}}][value]">Valor:</label>
                    <input type="number" name="installments[{{$index}}][value]" id="changeInput" step="0.01"
                        value="{{ $installment->value }}" required class="form-control" {{ $index === $sale->installments->count() - 1 ? 'readonly' : '' }}>

                    <label for="installments[{{$index}}][expiration_date]">Data de vencimento:</label>
                    <input type="date" name="installments[{{$index}}][expiration_date]"
                        value="{{ $installment->expiration_date }}" required>


                    <input type="hidden" name="installments[{{$index}}][paid]" value="0">

                </div>
            @endforeach
        @endif
    </div>
</div>