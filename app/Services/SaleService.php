<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'seller_id' => $data['seller_id'],
                'payment_method_id' => $data['payment_method_id'],
                'total' => 0,
            ]);

            $total = $this->processItems($sale, $data['items']);
            $sale->update(['total' => $total]);

            $this->processInstallments($sale, $data['installments']);

            return $sale;
        });
    }

    public function update(Sale $sale, array $data)
    {
        return DB::transaction(function () use ($sale, $data) {
            $sale->update([
                'customer_id' => $data['customer_id'],
                'seller_id' => $data['seller_id'],
                'payment_method_id' => $data['payment_method_id'],
            ]);

            $sale->items()->delete();
            $total = $this->processItems($sale, $data['items']);
            $sale->update(['total' => $total]);

            $this->processInstallments($sale, $data['installments']);

            return $sale;
        });
    }

    private function processItems(Sale $sale, array $items)
    {
        $total = 0;
        foreach ($items as $itemData) {
            $product = Product::findOrFail($itemData['product_id']);
            $unitPrice = $product->price;
            $subtotal = $itemData['amount'] * $unitPrice;
            $total += $subtotal;

            $sale->items()->create([
                'product_id' => $itemData['product_id'],
                'amount' => $itemData['amount'],
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);
        }
        return $total;
    }

    private function processInstallments(Sale $sale, array $installments)
    {
        foreach ($installments as $index => $installmentData) {
            $installment = $sale->installments()->firstOrNew([
                'number' => $index + 1,
            ]);
            $installment->value = $installmentData['value'];
            $installment->expiration_date = $installmentData['expiration_date'];
            $installment->paid = isset($installmentData['paid']) && $installmentData['paid'] === '1';
            $installment->save();
        }
    }

    public function delete(Sale $sale)
    {
        return $sale->delete();
    }
}
