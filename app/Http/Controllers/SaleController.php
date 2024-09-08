<?php

namespace App\Http\Controllers;


use App\Models\Installment;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::with(['customer', 'seller', 'items.product', 'installments'])->get();

        return view('sales.index', compact('sales'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'seller_id' => 'required|exists:sellers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.amount' => 'required|integer|min:1',
            'installments' => 'required|array',
            'installments.*.value' => 'required|numeric|min:0',
            'installments.*.expiration_date' => 'required|date',
            'installments.*.paid' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
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

            foreach ($validatedData['installments'] as $index => $installmentData) {
                $sale->installments()->create([
                    'number' => $index + 1,
                    'value' => $installmentData['value'],
                    'expiration_date' => $installmentData['expiration_date'],
                    'paid' => $installmentData['paid'],
                ]);
            }

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venda criada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao criar a venda: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'seller_id' => 'required|exists:sellers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.amount' => 'required|integer|min:1',
            'installments' => 'required|array',
            'installments.*.value' => 'required|numeric|min:0',
            'installments.*.expiration_date' => 'required|date',
            'installments.*.paid' => 'nullable|in:0,1',
        ]);



        DB::beginTransaction();

        try {
            $sale = Sale::findOrFail($id);
            $sale->update([
                'customer_id' => $validatedData['customer_id'],
                'seller_id' => $validatedData['seller_id'],
                'payment_method_id' => $validatedData['payment_method_id'],
            ]);


            $total = 0;
            $sale->items()->delete();
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


            foreach ($validatedData['installments'] as $index => $installmentData) {
                $installment = $sale->installments()->firstOrNew([
                    'number' => $index + 1,
                ]);
                $installment->value = $installmentData['value'];
                $installment->expiration_date = $installmentData['expiration_date'];
                $installment->paid = isset($installmentData['paid']) && $installmentData['paid'] === '1';
                $installment->save();
            }

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar a venda: ' . $e->getMessage())->withInput();
        }
    }


    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $sellers = Seller::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();
        $installments = Installment::all();

        return view('sales.form', compact('sale', 'customers', 'sellers', 'paymentMethods', 'products', 'installments'));
    }

    public function create()
    {
        $customers = Customer::all();
        $sellers = Seller::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();
        $installments = Installment::all();

        return view('sales.form', compact('customers', 'sellers', 'paymentMethods', 'products', 'installments'));
    }



    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso');
    }





}
