<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Hash;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::all();

        return view('sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('sellers.form', ['seller' => new Seller()]);
    }

    public function edit(Seller $seller)
    {
        return view('sellers.form', ['seller' => $seller]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|sellers,email',
            'password' => 'required|string|confirmed|min:6',
            'code' => 'required|integer|unique:sellers,code',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        Seller::create($data);

        return redirect()->route('sellers.index')->with('success', 'Vendedor cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        error_log($seller);
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'code' => 'required|integer|unique:sellers,code,' . $seller->id,
        ]);

        $seller->update($request->all());

        return redirect()->route('sellers.index')->with('success', 'Produto atualizado com sucesso');
    }

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();

        return redirect()->route('sellers.index')->with('success', 'Produto excluído com sucesso');
    }
}
