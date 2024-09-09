<?php

namespace App\Repositories;

use App\Models\Seller;

class SellerRepository
{
    public function getAll()
    {
        return Seller::all();
    }

    public function findById($id)
    {
        return Seller::findOrFail($id);
    }

    public function create(array $data)
    {
        return Seller::create($data);
    }

    public function update(Seller $seller, array $data)
    {
        $seller->update($data);
        return $seller;
    }

    public function delete(Seller $seller)
    {
        return $seller->delete();
    }
}
