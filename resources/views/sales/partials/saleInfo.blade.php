<div class="form-group" id="sale-info">
    <label for="customer_id">Cliente:</label>
    <select name="customer_id" id="customer_id" class="form-control">
        <option selected></option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}" {{ (isset($sale) && $sale->customer_id == $customer->id) ? 'selected' : '' }}>
                {{ $customer->name }}</option>
        @endforeach
    </select>

    <label for="seller_id">Vendedor:</label>
    <select name="seller_id" id="seller_id" class="form-control">
        <option selected></option>

        @foreach($sellers as $seller)
            <option value="{{ $seller->id }}" {{ (isset($sale) && $sale->seller_id == $seller->id) ? 'selected' : '' }}>
                {{ $seller->name }}
            </option>
        @endforeach
    </select>
</div>