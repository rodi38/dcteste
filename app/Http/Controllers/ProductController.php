<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Common\Helpers;
use Illuminate\Database\QueryException;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.form', ['product' => new Product()]);
    }

    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return Helpers::redirectWith('success', 'products.index', 'Produto cadastrado com sucesso');
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return Helpers::redirectWith('success', 'products.index', 'Produto atualizado com sucesso');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return Helpers::redirectWith('success', 'products.index', 'Produto excluído com sucesso');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return Helpers::redirectWith('error', 'products.index', 'O produto não pode ser excluido pois está atrelado a uma venda.');
            }
            return redirect()->route('sellers.index')->with('error', 'Ocorreu um erro ao tentar excluir o vendedor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir o produto: ' . $e->getMessage());
        }
    }


}
