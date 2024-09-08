<div class="d-none" id="sale-items">
    <div class="d-flex flex-row gap-3 align-items-center justify-content-end">
        <p class="">Adicionar produto</p>
        <a type="button" onclick="addProduct()" class="btn btn-primary fs-6">+</a>

    </div>

    <div id="productsContainer">
        @if (isset($sale))
            @foreach($sale->items as $index => $item)
                <div>
                    <div class="form-group">
                        <label for="items[{{ $index }}][product_id]" class="fs-1">Produto:</label>
                        <select name="items[{{ $index }}][product_id]" class="form-control product-select">
                            <option selected></option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="items[{{ $index }}][amount]">Quantidade:</label>
                        <input type="number" name="items[{{ $index }}][amount]" class="form-control amount-input" min="1"
                            required value="{{ $item->amount }}">
                    </div>
                </div>
            @endforeach
        @endif

    </div>

</div>