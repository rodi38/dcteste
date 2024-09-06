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

    public function index()
    {
        $sales = Sale::with(['customer', 'seller', 'paymentMethod'])->get();

        return view('sales.index', compact('sales'));
    }

    public function create(){
        $customers = Customer::all();
        $sellers = Seller::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();

        return view('sales.create', compact('customers', 'sellers', 'paymentMethods', 'products'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'seller_id' => 'required|exists:sellers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'total' => 'required|numeric|min:0',
            'products.*' => 'required|exists:products,id',
            'quantities.*' => 'required|integer|min:1',
            'prices.*' => 'required|numeric',
            'installments' => 'nullable|integer|min:1',
            'installments.*' => 'nullable|numeric|min:0',
        ]);

        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'seller_id' => $request->seller_id,
            'payment_method_id' => $request->payment_method_id,
            'total' => $request->total,
        ]);

        $products = $request->input('products');
        $quantities = $request->input('quantities');
        $prices = $request->input('prices');

        $totalPrice = 0;

        foreach ($products as $index => $productId) {
            $product = Product::find($productId);
            $quantity = $quantities[$index];
            $unitPrice = $prices[$index];
            $subtotal = $unitPrice * $quantity;

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'amount' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            $totalPrice += $subtotal;

            $product->stock -= $quantity;
            $product->save();
        }

        $sale->total = $totalPrice;
        $sale->save();

        $installments = $request->input('installments', []);
        if (!empty($installments)) {
            foreach ($installments as $installmentValue) {
                Installment::create([
                    'sale_id' => $sale->id,
                    'number' => count($installments),
                    'value' => $installmentValue,
                    'expiration_date' => now()->addMonths(count($installments)), 
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Venda criada com sucesso!');
    }

}
