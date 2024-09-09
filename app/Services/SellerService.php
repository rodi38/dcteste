<?php

namespace App\Services;

use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class SellerService
{
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return Seller::create($data);
    }

    public function update(Seller $seller, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $seller->update($data);
        return $seller;
    }

    public function delete(Seller $seller)
    {
        return $seller->delete();
    }
}
