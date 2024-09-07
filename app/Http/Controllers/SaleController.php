<?php

namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index(){
        $sales = Sale::with(['customer', 'seller', 'items.product', 'installment'])->get();

        return view('sales.index', compact('sales'));
    }

    public function edit($id){
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, $id){
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso');
    }

    public function destroy($id){
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso');
    }

    public function create(){
        $customers = Customer::all();
        $sellers = Seller::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();

        return view('sales.create', compact('customers', 'sellers', 'paymentMethods', 'products'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'seller_id' => 'required|exists:sellers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.amount' => 'required|integer|min:1',
        ]);

        $sale = Sale::create([
            'customer_id' => $validatedData['customer_id'],
            'seller_id' => $validatedData['seller_id'],
            'payment_method_id' => $validatedData['payment_method_id'],
            'total' => 0,
        ]);

        $total = 0;


        foreach ($validatedData['items'] as $itemData) {
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

        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Venda criada com sucesso');
    }



    public function show($id)
    {
        $sale = Sale::with(['customer', 'seller', 'items.product', 'installment'])->findOrFail($id);

        return view('sales.show', compact('sale'));
    }




}
