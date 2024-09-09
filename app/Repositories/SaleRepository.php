<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository
{
    public function getAll()
    {
        return Sale::with(['customer', 'seller', 'items.product', 'installments'])->get();
    }

    public function findById($id)
    {
        return Sale::findOrFail($id);
    }

    public function create(array $data)
    {
        return Sale::create($data);
    }

    public function update(Sale $sale, array $data)
    {
        $sale->update($data);
        return $sale;
    }

    public function delete(Sale $sale)
    {
        return $sale->delete();
    }
}
